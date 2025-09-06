<?php

namespace App\Http\Controllers\FRONTEND;

use App\Models\Product;
use App\Http\Requests\FRONTEND\ProductListRequest;
use App\Http\Controllers\Controller;
use App\Services\FrontendProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(FrontendProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get product quick view data
     */
    public function quickView(Product $product)
    {
        try {
            $product = $this->productService->getProductForQuickView($product);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not available'
                ]);
            }

            // Render the quick view content
            $html = view('partials.quick-view-content', compact('product'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'product' => $this->productService->getQuickViewData($product)
            ]);

        } catch (\Exception $e) {
            logger('Quick view error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error loading product details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display all shelves page (like categories index)
     */
    public function index()
    {
        // Get all active shelves with product counts
        $shelves = $this->productService->getAllShelvesWithCounts();

        return view('frontend.products.index', compact('shelves'));
    }

    /**
     * Show products for a specific shelf (organized by categories)
     */
    public function showShelf(\App\Models\Shelf $shelf)
    {
        $sort = request('sort', 'name_asc');
        $categoryFilter = request('category');

        // Get categories with their products for this shelf
        $categories = $this->productService->getShelfCategoriesWithProducts($shelf, $sort, $categoryFilter);

        // Get other shelves for sidebar
        $otherShelves = \App\Models\Shelf::where('id', '!=', $shelf->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get all categories for this shelf (for filter dropdown)
        $allCategories = \App\Models\Category::whereHas('products', function($query) use ($shelf) {
            $query->whereHas('shelves', function($subQuery) use ($shelf) {
                $subQuery->where('shelves.id', $shelf->id);
            })
            ->where('status', 'active')
            ->where('in_stock', true);
        })
        ->orderBy('name')
        ->get();

        return view('frontend.shelves.show', compact('shelf', 'categories', 'sort', 'otherShelves', 'allCategories', 'categoryFilter'));
    }

    /**
     * Load more products for a specific category within a shelf
     */
    public function loadMoreCategoryProducts(\App\Models\Shelf $shelf, \App\Models\Category $category)
    {
        $offset = request('offset', 0);
        $limit = request('limit', 8);
        $sort = request('sort', 'name_asc');

        // Get products for this category within the shelf
        $query = $shelf->products()
            ->where('products.category_id', $category->id)
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
                $query->orderBy('products.name', 'asc');
                break;
        }

        $products = $query->skip($offset)->take($limit)->get();

        // Generate HTML for products
        $html = '';
        foreach ($products as $product) {
            $html .= view('frontend.partials.product-card', compact('product'))->render();
        }

        return response()->json([
            'html' => $html,
            'count' => $products->count()
        ]);
    }

    /**
     * Display new products page
     */
    public function newProducts()
    {
        $products = $this->productService->getNewProducts(20);

        return view('frontend.products.new', compact('products'));
    }

    /**
     * Display promotions page
     */
    public function promotions()
    {
        $products = $this->productService->getPromotionProducts(20);

        return view('frontend.promotions', compact('products'));
    }

    /**
     * Display single product page
     */
    public function show(Product $product)
    {
        // Ensure product is accessible
        if (!$this->productService->isProductAccessible($product)) {
            abort(404);
        }

        $product->load(['images', 'category']);

        // Get related products
        $relatedProducts = $this->productService->getRelatedProducts($product, 4);

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
