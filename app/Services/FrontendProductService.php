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
