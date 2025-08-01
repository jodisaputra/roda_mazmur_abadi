<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FrontendCategoryService
{
    /**
     * Get all active categories with product counts
     */
    public function getActiveCategoriesWithCounts(): Collection
    {
        return Category::active()
            ->root()
            ->with(['children' => function ($query) {
                $query->active()->withCount('products');
            }])
            ->withCount('products')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                // Calculate total products including children
                $totalProducts = $category->products_count;

                if ($category->children->isNotEmpty()) {
                    $totalProducts += $category->children->sum('products_count');
                }

                $category->total_products_count = $totalProducts;
                return $category;
            });
    }

    /**
     * Get products for a specific category and its children
     */
    public function getCategoryProducts(Category $category, string $sort = 'name_asc', int $perPage = 12): LengthAwarePaginator
    {
        // Get category IDs (include children)
        $categoryIds = collect([$category->id]);

        if ($category->children->isNotEmpty()) {
            $categoryIds = $categoryIds->merge($category->children->pluck('id'));
        }

        $productsQuery = Product::active()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'images']);

        // Apply sorting
        $this->applySorting($productsQuery, $sort);

        return $productsQuery->paginate($perPage);
    }

    /**
     * Check if category is accessible (active)
     */
    public function isCategoryAccessible(Category $category): bool
    {
        return $category->status === 'active';
    }

    /**
     * Get category by slug with validation
     */
    public function getCategoryBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)
            ->active()
            ->with(['children' => function ($query) {
                $query->active();
            }])
            ->first();
    }

    /**
     * Get categories for navigation/sidebar
     */
    public function getNavigationCategories(): Collection
    {
        return Category::active()
            ->root()
            ->with(['children' => function ($query) {
                $query->active()->orderBy('name');
            }])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get category statistics
     */
    public function getCategoryStats(Category $category): array
    {
        $directProducts = $category->products()->active()->count();
        $childrenProductsCount = 0;

        if ($category->children->isNotEmpty()) {
            $childrenProductsCount = Product::active()
                ->whereIn('category_id', $category->children->pluck('id'))
                ->count();
        }

        return [
            'direct_products' => $directProducts,
            'children_products' => $childrenProductsCount,
            'total_products' => $directProducts + $childrenProductsCount,
            'has_children' => $category->children->isNotEmpty(),
            'children_count' => $category->children->count()
        ];
    }

    /**
     * Apply sorting to products query
     */
    private function applySorting(Builder $query, string $sort): Builder
    {
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        return $query;
    }

    /**
     * Get sort options for category pages
     */
    public function getSortOptions(): array
    {
        return [
            'name_asc' => 'Name (A-Z)',
            'name_desc' => 'Name (Z-A)',
            'latest' => 'Latest Products',
            'price_low' => 'Price (Low to High)',
            'price_high' => 'Price (High to Low)'
        ];
    }
}
