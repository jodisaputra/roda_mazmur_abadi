<?php

namespace App\Http\Controllers\FRONTEND;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Get product quick view data
     */
    public function quickView(Product $product)
    {
        // Load necessary relationships
        $product->load(['images', 'category', 'primaryImage']);

        // Check if product is active and in stock
        if ($product->status !== 'active') {
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
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->formatted_price,
                'stock' => $product->stock_quantity,
                'in_stock' => $product->in_stock
            ]
        ]);
    }

    /**
     * Display all products page
     */
    public function index()
    {
        $products = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->paginate(20);

        return view('frontend.products.index', compact('products'));
    }

    /**
     * Display new products page
     */
    public function newProducts()
    {
        $products = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->take(20)
            ->get();

        return view('frontend.products.new', compact('products'));
    }

    /**
     * Display promotions page
     */
    public function promotions()
    {
        // For now, just show all products with a "promotion" view
        $products = Product::with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->take(20)
            ->get();

        return view('frontend.promotions', compact('products'));
    }
}
