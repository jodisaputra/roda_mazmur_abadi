<?php

namespace App\Http\Controllers\FRONTEND;

use App\Http\Controllers\Controller;
use App\Http\Requests\FRONTEND\SearchRequest;
use App\Services\SearchService;
use App\Models\Category;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Search products based on query
     */
    public function search(SearchRequest $request)
    {
        $validated = $request->validated();

        $query = $validated['q'] ?? '';
        $categorySlug = $validated['category'] ?? null;
        $sort = $validated['sort'] ?? 'relevance';

        $products = $this->searchService->searchProducts($query, $categorySlug, $sort, 12);
        $categories = $this->searchService->getActiveCategories();
        $stats = $this->searchService->getSearchStats($query, $categorySlug);

        // Get selected category if provided
        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = Category::where('slug', $categorySlug)->first();
        }

        // Handle AJAX request for load more
        if ($request->ajax()) {
            $html = view('frontend.search.partials.product-grid', compact('products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'has_more' => $products->hasMorePages(),
                'next_page' => $products->hasMorePages() ? $products->currentPage() + 1 : null
            ]);
        }

        return view('frontend.search.results', compact(
            'products',
            'categories',
            'stats',
            'query',
            'selectedCategory',
            'sort'
        ));
    }    /**
     * AJAX search suggestions
     */
    public function suggestions(SearchRequest $request)
    {
        $validated = $request->validated();
        $suggestions = $this->searchService->getSearchSuggestions($validated['q'] ?? '', 5);

        // Format suggestions with proper URLs
        $formattedSuggestions = $suggestions->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'url' => route('products.show', $product->slug),
                'image' => null // Will add later if needed
            ];
        });

        return response()->json(['suggestions' => $formattedSuggestions]);
    }
}
