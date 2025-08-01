<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get active root categories with their children and products count
        $categories = Category::active()
            ->root()
            ->with(['children' => function ($query) {
                $query->active()->withCount('products');
            }])
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Calculate total products count for parent categories (including children's products)
        $categories->each(function ($category) {
            if ($category->children->isNotEmpty()) {
                $totalProducts = $category->products_count + $category->children->sum('products_count');
                $category->total_products_count = $totalProducts;
            } else {
                $category->total_products_count = $category->products_count;
            }
        });

        $view->with('categories', $categories);
    }
}
