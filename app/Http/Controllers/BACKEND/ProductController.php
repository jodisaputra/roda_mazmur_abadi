<?php

namespace App\Http\Controllers\BACKEND;

use App\Http\Controllers\Controller;
use App\Http\Requests\BACKEND\StoreProductRequest;
use App\Http\Requests\BACKEND\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductDataTableService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected ProductDataTableService $dataTableService;

    public function __construct(ProductService $productService, ProductDataTableService $dataTableService)
    {
        $this->productService = $productService;
        $this->dataTableService = $dataTableService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dataTableService->getDataTable();
        }

        $html = $this->dataTableService->getHtmlBuilder();

        return view('BACKEND.product.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productService->getActiveCategories();

        return view('BACKEND.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->validated());

            sweet_alert_success('Success!', 'Product created successfully.');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to create product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images']);

        return view('BACKEND.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = $this->productService->getActiveCategories();
        $product->load(['category', 'images']);

        return view('BACKEND.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->productService->updateProduct($product, $request->validated());

            sweet_alert_success('Success!', 'Product updated successfully.');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to update product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->productService->deleteProduct($product);

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product): JsonResponse
    {
        try {
            $this->productService->toggleStatus($product);

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Toggle product stock status
     */
    public function toggleStock(Product $product): JsonResponse
    {
        try {
            $this->productService->toggleStockStatus($product);

            return response()->json([
                'success' => true,
                'message' => 'Product stock status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product stock status: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Generate unique slug from name
     */
    public function generateSlug(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $productId = $request->get('product_id'); // For edit form

        if (empty($name)) {
            return response()->json(['slug' => '']);
        }

        $slug = $this->productService->generateUniqueSlug($name, $productId);

        return response()->json(['slug' => $slug]);
    }

    /**
     * Generate unique SKU
     */
    public function generateSku(): JsonResponse
    {
        $sku = $this->productService->generateUniqueSku();

        return response()->json(['sku' => $sku]);
    }

    /**
     * Set primary image for product
     */
    public function setPrimaryImage(Product $product, Request $request): JsonResponse
    {
        try {
            $imageId = $request->get('image_id');
            $success = $this->productService->setPrimaryImage($product, $imageId);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Primary image updated successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to set primary image: ' . $e->getMessage()
            ], 400);
        }
    }
}
