<?php

namespace App\Http\Controllers\FRONTEND;

use App\Http\Controllers\Controller;
use App\Http\Requests\FRONTEND\CategoryShowRequest;
use App\Models\Category;
use App\Services\FrontendCategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(FrontendCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display all categories
     */
    public function index()
    {
        $categories = $this->categoryService->getActiveCategoriesWithCounts();

        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Display products for a specific category
     */
    public function show(Category $category, CategoryShowRequest $request)
    {
        // Ensure category is accessible
        if (!$this->categoryService->isCategoryAccessible($category)) {
            abort(404);
        }

        // Get all categories for sidebar
        $categories = $this->categoryService->getActiveCategoriesWithCounts();

        // Get products for this category
        $sort = $request->validated()['sort'] ?? 'name_asc';
        $products = $this->categoryService->getCategoryProducts($category, $sort, 12);

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
