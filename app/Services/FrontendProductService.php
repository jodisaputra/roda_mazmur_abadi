<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FrontendProductService
{
    /**
     * Get product for quick view
     */
    public function getProductForQuickView(Product $product): ?Product
    {
        if ($product->status !== 'active') {
            return null;
        }

        return $product->load(['images', 'category', 'primaryImage']);
    }

    /**
     * Get all active products with pagination
     */
    public function getAllActiveProducts(int $perPage = 20): LengthAwarePaginator
    {
        return Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all active shelves with product counts (for shelves index page)
     */
    public function getAllShelvesWithCounts(): Collection
    {
        return \App\Models\Shelf::active()
            ->withCount(['products as products_count' => function ($query) {
                $query->where('status', 'active')->where('in_stock', true);
            }])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get products for a specific shelf with pagination
     */
    public function getShelfProducts(\App\Models\Shelf $shelf, string $sort = 'name_asc', int $perPage = 12): LengthAwarePaginator
    {
        $query = $shelf->products()
            ->where('products.status', 'active')
            ->where('products.in_stock', true)
            ->with(['primaryImage', 'category']);

        // Apply sorting
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('products.name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('products.name', 'desc');
                break;
            case 'price_low':
                $query->orderBy('products.price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('products.price', 'desc');
                break;
            case 'latest':
                $query->orderBy('products.created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('products.created_at', 'asc');
                break;
            default:
                $query->orderBy('product_shelf.sort_order');
                break;
        }

        return $query->paginate($perPage);
    }

    /**
     * Get categories with products for a specific shelf (grouped by category)
     */
    public function getShelfCategoriesWithProducts(\App\Models\Shelf $shelf, string $sort = 'name_asc', ?string $categoryFilter = null): Collection
    {
        // Get all categories that have products in this shelf
        $categories = \App\Models\Category::whereHas('products', function($query) use ($shelf) {
            $query->whereHas('shelves', function($subQuery) use ($shelf) {
                $subQuery->where('shelves.id', $shelf->id);
            })
            ->where('status', 'active')
            ->where('in_stock', true);
        })
        ->with(['products' => function($query) use ($shelf, $sort) {
            $query->whereHas('shelves', function($subQuery) use ($shelf) {
                $subQuery->where('shelves.id', $shelf->id);
            })
            ->where('status', 'active')
            ->where('in_stock', true)
            ->with(['primaryImage', 'category']);

            // Apply sorting
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
                    break;
            }
        }])
        ->orderBy('name')
        ->get();

        // Filter by specific category if requested
        if ($categoryFilter) {
            $categories = $categories->filter(function($category) use ($categoryFilter) {
                return $category->slug === $categoryFilter;
            });
        }

        return $categories;
    }

    /**
     * Get shelves with their products for products page
     */
    public function getShelvesWithProducts(int $page = 1, int $perPage = 12): Collection
    {
        $offset = ($page - 1) * $perPage;

        $shelves = \App\Models\Shelf::active()
            ->with(['products' => function ($query) {
                $query->where('status', 'active')
                      ->where('in_stock', true)
                      ->with(['primaryImage', 'category'])
                      ->orderBy('product_shelf.sort_order');
            }])
            ->get();

        // Process each shelf to get paginated products
        return $shelves->map(function($shelf) use ($offset, $perPage) {
            $allProducts = $shelf->products;
            $shelf->totalProducts = $allProducts->count();

            // Get products for current page
            $shelf->activeProducts = $allProducts->skip($offset)->take($perPage);

            // Check if there are more products
            $shelf->moreProducts = $allProducts->count() > ($offset + $perPage);

            return $shelf;
        })->filter(function($shelf) {
            // Only return shelves that have products to show
            return $shelf->activeProducts->isNotEmpty();
        });
    }

    /**
     * Get new/latest products
     */
    public function getNewProducts(int $limit = 20): Collection
    {
        return Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get promotion products
     */
    public function getPromotionProducts(int $limit = 20): Collection
    {
        // For now, return latest products - can be enhanced later with promotion logic
        return Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get product by slug with validation
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['images', 'category'])
            ->first();
    }

    /**
     * Get related products for a given product
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images', 'category'])
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    /**
     * Check if product is accessible (active and in stock)
     */
    public function isProductAccessible(Product $product): bool
    {
        return $product->status === 'active';
    }

    /**
     * Check if product is in stock
     */
    public function isProductInStock(Product $product): bool
    {
        return $product->in_stock;
    }

    /**
     * Get product quick view data for AJAX response
     */
    public function getQuickViewData(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->formatted_price,
            'stock' => $product->stock_quantity,
            'in_stock' => $product->in_stock,
            'description' => $product->description,
            'sku' => $product->sku,
            'category' => $product->category->name ?? null
        ];
    }

    /**
     * Get featured products for homepage
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(string $categorySlug, int $limit = null): Builder|Collection
    {
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return collect();
        }

        $query = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->where('category_id', $category->id)
            ->latest();

        return $limit ? $query->take($limit)->get() : $query;
    }

    /**
     * Get products with filters and sorting
     */
    public function getFilteredProducts(array $filters = [], string $sort = 'latest', int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with(['category', 'primaryImage'])
            ->where('status', 'active');

        // Apply filters
        if (isset($filters['category']) && $filters['category']) {
            $category = Category::where('slug', $filters['category'])->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if (isset($filters['price_min']) && $filters['price_min']) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (isset($filters['price_max']) && $filters['price_max']) {
            $query->where('price', '<=', $filters['price_max']);
        }

        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $query->where('stock_quantity', '>', 0);
        }

        // Apply sorting
        $this->applySorting($query, $sort);

        return $query->paginate($perPage);
    }

    /**
     * Apply sorting to products query
     */
    private function applySorting(Builder $query, string $sort): Builder
    {
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    /**
     * Get sort options for product listings
     */
    public function getSortOptions(): array
    {
        return [
            'latest' => 'Latest Products',
            'oldest' => 'Oldest Products',
            'name_asc' => 'Name (A-Z)',
            'name_desc' => 'Name (Z-A)',
            'price_low' => 'Price (Low to High)',
            'price_high' => 'Price (High to Low)'
        ];
    }
}
