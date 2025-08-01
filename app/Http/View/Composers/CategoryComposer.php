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
        // Get active root categories with their children
        $categories = Category::active()
            ->root()
            ->with(['children' => function ($query) {
                $query->active()->with('products');
            }])
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $view->with('categories', $categories);
    }
}
