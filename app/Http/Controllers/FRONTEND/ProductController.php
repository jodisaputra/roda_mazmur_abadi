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
    }

    /**
     * Display all products page
     */
    public function index(ProductListRequest $request)
    {
        $validated = $request->validated();
        $perPage = $validated['per_page'] ?? 20;

        $products = $this->productService->getAllActiveProducts($perPage);

        return view('frontend.products.index', compact('products'));
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
