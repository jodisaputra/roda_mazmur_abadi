<?php

namespace App\Http\Controllers\FRONTEND;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::active()
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

        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Display products for a specific category
     */
    public function show(Category $category, Request $request)
    {
        // Ensure category is active
        if ($category->status !== 'active') {
            abort(404);
        }

        // Get all categories for sidebar with correct product counts (including children)
        $categories = Category::active()
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

        // Get products for this category and its children
        $categoryIds = collect([$category->id]);

        // Add children category IDs if exist
        if ($category->children->isNotEmpty()) {
            $categoryIds = $categoryIds->merge($category->children->pluck('id'));
        }

        $productsQuery = Product::active()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'images']);

        // Apply sorting
        $sort = $request->get('sort', 'name_asc');
        switch ($sort) {
            case 'name_desc':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'latest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
            default:
                $productsQuery->orderBy('name', 'asc');
                break;
        }

        $products = $productsQuery->paginate(12);

        // Handle AJAX request for load more
        if ($request->ajax()) {
            $html = view('frontend.categories.partials.product-grid', compact('products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'has_more' => $products->hasMorePages(),
                'next_page' => $products->hasMorePages() ? $products->currentPage() + 1 : null
            ]);
        }

        return view('frontend.categories.show', compact('category', 'products', 'categories'));
    }
}
