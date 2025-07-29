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
}
