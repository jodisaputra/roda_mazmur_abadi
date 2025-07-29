<?php

namespace App\Services;

use App\Models\Shelf;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ShelfService
{
    /**
     * Get shelves for DataTables
     */
    public function getShelvesForDataTable()
    {
        $shelves = Shelf::select(['id', 'name', 'slug', 'is_active', 'capacity', 'created_at'])
                       ->withCount('products');

        return DataTables::of($shelves)
            ->addIndexColumn()
            ->addColumn('status', function ($shelf) {
                return $shelf->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('products_count', function ($shelf) {
                return $shelf->products_count . '/' . ($shelf->capacity ?? '∞');
            })
            ->addColumn('action', function ($shelf) {
                return '
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('admin.shelves.show', $shelf->id) . '">
                                <i class="bi bi-eye me-2"></i>View Details
                            </a></li>
                            <li><a class="dropdown-item" href="' . route('admin.shelves.edit', $shelf->id) . '">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteShelf(' . $shelf->id . ')">
                                <i class="bi bi-trash me-2"></i>Delete
                            </a></li>
                        </ul>
                    </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Create a new shelf
     */
    public function createShelf(array $data): Shelf
    {
        return Shelf::create([
            'name' => $data['name'],
            'capacity' => $data['capacity'] ?? null,
            'is_active' => $data['is_active'] ?? false,
        ]);
    }

    /**
     * Update shelf
     */
    public function updateShelf(Shelf $shelf, array $data): bool
    {
        return $shelf->update([
            'name' => $data['name'],
            'capacity' => $data['capacity'] ?? null,
            'is_active' => $data['is_active'] ?? false,
        ]);
    }

    /**
     * Delete shelf
     */
    public function deleteShelf(Shelf $shelf): bool
    {
        return $shelf->delete();
    }

    /**
     * Get shelf with products for management
     */
    public function getShelfWithProducts(Shelf $shelf): array
    {
        // Get products that are not assigned to any shelf or only assigned to current shelf
        $products = Product::with(['category', 'primaryImage'])
                          ->active()
                          ->inStock()
                          ->whereDoesntHave('shelves', function ($query) use ($shelf) {
                              $query->where('shelf_id', '!=', $shelf->id);
                          })
                          ->get();

        $shelfProducts = $shelf->products()->get();

        // Get unavailable products with reasons
        $unavailableProducts = $this->getUnavailableProducts($shelf);

        return [
            'shelf' => $shelf,
            'products' => $products,
            'shelfProducts' => $shelfProducts,
            'unavailableProducts' => $unavailableProducts
        ];
    }

    /**
     * Get products that cannot be added to shelf with reasons
     */
    private function getUnavailableProducts(Shelf $shelf): array
    {
        $unavailable = [];

        // Products already in other shelves
        $productsInOtherShelves = Product::with(['category', 'primaryImage', 'shelves'])
                                        ->whereHas('shelves', function ($query) use ($shelf) {
                                            $query->where('shelf_id', '!=', $shelf->id);
                                        })
                                        ->get();

        foreach ($productsInOtherShelves as $product) {
            $otherShelf = $product->shelves->where('id', '!=', $shelf->id)->first();
            $unavailable[] = [
                'product' => $product,
                'reason' => 'Already in shelf: ' . $otherShelf->name,
                'type' => 'in_other_shelf'
            ];
        }

        // Products that are out of stock
        $outOfStockProducts = Product::with(['category', 'primaryImage'])
                                   ->where('in_stock', false)
                                   ->whereDoesntHave('shelves')
                                   ->get();

        foreach ($outOfStockProducts as $product) {
            $unavailable[] = [
                'product' => $product,
                'reason' => 'Out of stock',
                'type' => 'out_of_stock'
            ];
        }

        // Inactive products
        $inactiveProducts = Product::with(['category', 'primaryImage'])
                                  ->where('status', '!=', 'active')
                                  ->whereDoesntHave('shelves')
                                  ->get();

        foreach ($inactiveProducts as $product) {
            $unavailable[] = [
                'product' => $product,
                'reason' => 'Product inactive',
                'type' => 'inactive'
            ];
        }

        return $unavailable;
    }

    /**
     * Update shelf products with sort order
     */
    public function updateShelfProducts(Shelf $shelf, array $productIds): void
    {
        DB::transaction(function () use ($shelf, $productIds) {
            // Validate capacity
            if ($shelf->capacity && count($productIds) > $shelf->capacity) {
                throw new \Exception("Cannot add more than {$shelf->capacity} products to this shelf.");
            }

            // Validate products availability
            foreach ($productIds as $productId) {
                $product = Product::find($productId);

                if (!$product) {
                    throw new \Exception("Product with ID {$productId} not found.");
                }

                if (!$product->in_stock) {
                    throw new \Exception("Product '{$product->name}' is out of stock and cannot be added to shelf.");
                }

                if ($product->status !== 'active') {
                    throw new \Exception("Product '{$product->name}' is not active and cannot be added to shelf.");
                }

                // Check if product is already in another shelf
                $existingShelf = $product->shelves()->where('shelf_id', '!=', $shelf->id)->first();
                if ($existingShelf) {
                    throw new \Exception("Product '{$product->name}' is already assigned to shelf '{$existingShelf->name}'.");
                }
            }

            // Prepare data for sync with sort order
            $syncData = [];
            foreach ($productIds as $index => $productId) {
                $syncData[$productId] = [
                    'sort_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Use sync to prevent duplicate entries
            $shelf->products()->sync($syncData);
        });
    }    /**
     * Check if shelf can accept more products
     */
    public function canAddProducts(Shelf $shelf, int $additionalCount = 1): bool
    {
        if (!$shelf->capacity) {
            return true; // Unlimited capacity
        }

        $currentCount = $shelf->products()->count();
        return ($currentCount + $additionalCount) <= $shelf->capacity;
    }

    /**
     * Get available products count for shelf
     */
    public function getAvailableProductsCount(Shelf $shelf): array
    {
        $currentCount = $shelf->products()->count();
        $maxCapacity = $shelf->capacity;
        $availableSlots = $maxCapacity ? ($maxCapacity - $currentCount) : null;

        return [
            'current' => $currentCount,
            'max' => $maxCapacity,
            'available' => $availableSlots,
            'is_full' => $maxCapacity ? ($currentCount >= $maxCapacity) : false
        ];
    }

    /**
     * Get all active shelves with their products
     */
    public function getActiveShelvesWithProducts(): Collection
    {
        return Shelf::active()
                   ->with(['activeProducts' => function ($query) {
                       $query->with(['category', 'primaryImage'])
                             ->limit(10); // Limit products per shelf
                   }])
                   ->get();
    }

    /**
     * Get shelf by slug with products
     */
    public function getShelfBySlug(string $slug): ?Shelf
    {
        return Shelf::where('slug', $slug)
                   ->active()
                   ->with(['activeProducts' => function ($query) {
                       $query->with(['category', 'primaryImage']);
                   }])
                   ->first();
    }

    /**
     * Get featured products shelf
     */
    public function getFeaturedProductsShelf(): ?Shelf
    {
        return $this->getShelfBySlug('featured-products');
    }

    /**
     * Get best sellers shelf
     */
    public function getBestSellersShelf(): ?Shelf
    {
        return $this->getShelfBySlug('best-sellers');
    }

    /**
     * Get new arrivals shelf
     */
    public function getNewArrivalsShelf(): ?Shelf
    {
        return $this->getShelfBySlug('new-arrivals');
    }
}
