<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Search for products with filters and sorting
     */
    public function searchProducts(string $query = null, string $categorySlug = null, string $sort = 'relevance', int $perPage = 12): LengthAwarePaginator
    {
        $productsQuery = Product::with(['category', 'images'])
            ->where('status', 'active');

        // Apply search query if provided
        if (!empty($query)) {
            $productsQuery->where(function (Builder $q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            });
        }

        // Apply category filter if provided
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $productsQuery->where('category_id', $category->id);
            }
        }

        // Apply sorting
        $this->applySorting($productsQuery, $sort);

        return $productsQuery->paginate($perPage);
    }

    /**
     * Get search suggestions for autocomplete
     */
    public function getSearchSuggestions(string $query, int $limit = 5): Collection
    {
        if (strlen($query) < 2) {
            return collect();
        }

        return Product::where('status', 'active')
            ->where(function (Builder $q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'slug', 'price')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all active categories for filter dropdown
     */
    public function getActiveCategories(): Collection
    {
        return Category::where('status', 'active')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    /**
     * Get search statistics
     */
    public function getSearchStats(string $query = null, string $categorySlug = null): array
    {
        $totalProducts = Product::where('status', 'active');

        if (!empty($query)) {
            $totalProducts->where(function (Builder $q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            });
        }

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $totalProducts->where('category_id', $category->id);
            }
        }

        $count = $totalProducts->count();

        return [
            'total_results' => $count,
            'query' => $query,
            'category_slug' => $categorySlug,
            'has_results' => $count > 0
        ];
    }

    /**
     * Apply sorting to the products query
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
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'relevance':
            default:
                // For relevance, we can add more sophisticated scoring later
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    /**
     * Format price for display
     */
    public function formatPrice(float $price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Get sort options for dropdown
     */
    public function getSortOptions(): array
    {
        return [
            'relevance' => 'Most Relevant',
            'name_asc' => 'Name (A-Z)',
            'name_desc' => 'Name (Z-A)',
            'price_low' => 'Price (Low to High)',
            'price_high' => 'Price (High to Low)',
            'latest' => 'Latest Products'
        ];
    }
}
