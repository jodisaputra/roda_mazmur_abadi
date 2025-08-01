<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample image URLs from placeholder services
        $sampleImages = [
            'products/sample-product-1.jpg',
            'products/sample-product-2.jpg',
            'products/sample-product-3.jpg',
            'products/sample-product-4.jpg',
            'products/sample-product-5.jpg',
            'products/sample-smartphone-1.jpg',
            'products/sample-smartphone-2.jpg',
            'products/sample-laptop-1.jpg',
            'products/sample-laptop-2.jpg',
            'products/sample-headphone-1.jpg',
            'products/sample-headphone-2.jpg',
            'products/sample-tv-1.jpg',
            'products/sample-tv-2.jpg',
            'products/sample-gaming-1.jpg',
            'products/sample-gaming-2.jpg',
        ];

        // Create sample image directory if it doesn't exist
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }

        // Create placeholder images if they don't exist
        $this->createPlaceholderImages($sampleImages);

        // Get all products without images
        $productsWithoutImages = Product::whereDoesntHave('images')->get();

        echo "Adding images to " . $productsWithoutImages->count() . " products...\n";

        foreach ($productsWithoutImages as $product) {
            // Random number of images per product (1-3)
            $imageCount = rand(1, 3);

            for ($i = 0; $i < $imageCount; $i++) {
                // Select appropriate image based on product category
                $imagePath = $this->selectImageForProduct($product, $sampleImages, $i);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'alt_text' => $product->name . ' - Image ' . ($i + 1),
                    'is_primary' => $i === 0, // First image is primary
                    'sort_order' => $i + 1,
                ]);
            }
        }

        echo "Successfully added images to products!\n";
    }

    /**
     * Create placeholder images
     */
    private function createPlaceholderImages($sampleImages)
    {
        foreach ($sampleImages as $imagePath) {
            $fullPath = storage_path('app/public/' . $imagePath);

            if (!file_exists($fullPath)) {
                // Create a simple placeholder image (you can replace this with actual image downloading)
                $dir = dirname($fullPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }

                // Copy from a default image or create a simple placeholder
                $defaultImagePath = public_path('template/assets/images/default-product.svg');
                if (file_exists($defaultImagePath)) {
                    copy($defaultImagePath, $fullPath);
                } else {
                    // Create a simple text file as placeholder
                    file_put_contents($fullPath, 'Placeholder image for ' . basename($imagePath));
                }
            }
        }
    }

    /**
     * Select appropriate image for product based on category
     */
    private function selectImageForProduct($product, $sampleImages, $imageIndex)
    {
        $categoryName = strtolower($product->category->name ?? '');

        // Select image based on category
        if (str_contains($categoryName, 'smartphone') || str_contains($categoryName, 'phone')) {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'smartphone'));
        } elseif (str_contains($categoryName, 'laptop') || str_contains($categoryName, 'computer')) {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'laptop'));
        } elseif (str_contains($categoryName, 'audio') || str_contains($categoryName, 'headphone')) {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'headphone'));
        } elseif (str_contains($categoryName, 'tv') || str_contains($categoryName, 'television')) {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'tv'));
        } elseif (str_contains($categoryName, 'gaming') || str_contains($categoryName, 'game')) {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'gaming'));
        } else {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'sample-product'));
        }

        // If no category-specific images, use general product images
        if (empty($categoryImages)) {
            $categoryImages = array_filter($sampleImages, fn($img) => str_contains($img, 'sample-product'));
        }

        // Select image
        $imageArray = array_values($categoryImages);
        $selectedImage = $imageArray[($imageIndex) % count($imageArray)] ?? $sampleImages[0];

        return $selectedImage;
    }
}
