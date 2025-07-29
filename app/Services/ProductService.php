<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Get all products with optional relations
     */
    public function getAllProducts(array $relations = []): Collection
    {
        return Product::with($relations)->orderBy('name')->get();
    }

    /**
     * Get active categories for product selection
     */
    public function getActiveCategories(): Collection
    {
        return Category::active()->orderBy('name')->get();
    }

    /**
     * Create a new product
     */
    public function createProduct(array $data): Product
    {
        // Handle images if provided
        $images = $data['images'] ?? [];
        $primaryIndex = (int) ($data['primary_image_index'] ?? 0);
        $shelves = $data['shelves'] ?? [];
        unset($data['images'], $data['primary_image_index'], $data['shelves']);

        // Create the product
        $product = Product::create($data);

        // Handle image uploads
        if (!empty($images)) {
            $this->handleImageUploads($product, $images, $primaryIndex);
        }

        // Handle shelves
        if (!empty($shelves)) {
            $product->shelves()->sync($shelves);
        }

        return $product->load(['category', 'images', 'shelves']);
    }

    /**
     * Update an existing product
     */
    public function updateProduct(Product $product, array $data): Product
    {
        // Handle images
        $images = $data['images'] ?? [];
        $keepImages = $data['keep_images'] ?? [];
        $primaryIndex = (int) ($data['primary_image_index'] ?? 0);
        $shelves = $data['shelves'] ?? [];
        unset($data['images'], $data['keep_images'], $data['primary_image_index'], $data['shelves']);

        // Update the product
        $product->update($data);

        // Handle image management
        $this->manageProductImages($product, $images, $keepImages, $primaryIndex);

        // Handle shelves
        $product->shelves()->sync($shelves);

        return $product->fresh(['category', 'images', 'shelves']);
    }

    /**
     * Delete a product
     */
    public function deleteProduct(Product $product): bool
    {
        // Delete all associated images
        foreach ($product->images as $image) {
            $this->deleteImage($image->image);
            $image->delete();
        }

        return $product->delete();
    }

    /**
     * Get product by ID with relations
     */
    public function getProductById(int $id, array $relations = []): ?Product
    {
        return Product::with($relations)->find($id);
    }

    /**
     * Get product by slug
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->first();
    }

    /**
     * Generate a unique slug using Eloquent Sluggable
     */
    public function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = Product::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;

            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Search products by name or description
     */
    public function searchProducts(string $query, array $relations = []): Collection
    {
        return Product::with($relations)
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(int $categoryId, array $relations = []): Collection
    {
        return Product::with($relations)
            ->where('category_id', $categoryId)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get products by status
     */
    public function getProductsByStatus(string $status, array $relations = []): Collection
    {
        return Product::with($relations)
            ->where('status', $status)
            ->orderBy('name')
            ->get();
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product): Product
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return $product->fresh();
    }

    /**
     * Toggle product stock status
     */
    public function toggleStockStatus(Product $product): Product
    {
        $product->update([
            'in_stock' => !$product->in_stock
        ]);

        return $product->fresh();
    }

    /**
     * Handle multiple image uploads
     */
    private function handleImageUploads(Product $product, array $images, int $primaryIndex = 0): void
    {
        // First, reset all existing images to not primary
        $product->images()->update(['is_primary' => false]);

        $sortOrder = 0;

        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                $imagePath = $this->handleImageUpload($image);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'alt_text' => $product->name,
                    'is_primary' => $index === $primaryIndex,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }
    }

    /**
     * Manage product images during update
     */
    private function manageProductImages(Product $product, array $newImages, array $keepImages, int $primaryIndex = 0): void
    {
        // Get current images
        $currentImages = $product->images;

        // Delete images that are not in keep list
        foreach ($currentImages as $image) {
            if (!in_array($image->id, $keepImages)) {
                $this->deleteImage($image->image);
                $image->delete();
            }
        }

        // Add new images
        if (!empty($newImages)) {
            // Reset all existing images to not primary first
            $product->images()->update(['is_primary' => false]);

            $maxSortOrder = $product->images()->max('sort_order') ?? -1;
            $sortOrder = $maxSortOrder + 1;

            foreach ($newImages as $index => $image) {
                if ($image instanceof UploadedFile) {
                    $imagePath = $this->handleImageUpload($image);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                        'alt_text' => $product->name,
                        'is_primary' => $index === $primaryIndex,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }
        }

        // Ensure there's always a primary image
        $this->ensurePrimaryImage($product);
    }

    /**
     * Ensure product has a primary image
     */
    private function ensurePrimaryImage(Product $product): void
    {
        $primaryCount = $product->images()->where('is_primary', true)->count();

        // If there are multiple primary images, keep only the first one
        if ($primaryCount > 1) {
            $product->images()->update(['is_primary' => false]);
            $firstImage = $product->images()->orderBy('sort_order')->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }
        // If there's no primary image, set the first one as primary
        elseif ($primaryCount === 0) {
            $firstImage = $product->images()->orderBy('sort_order')->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }
    }

    /**
     * Handle single image upload
     */
    private function handleImageUpload(UploadedFile $image): string
    {
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/products', $filename);
        return 'products/' . $filename;
    }

    /**
     * Delete image file
     */
    private function deleteImage(string $imagePath): void
    {
        $fullPath = storage_path('app/public/' . str_replace('/', DIRECTORY_SEPARATOR, $imagePath));
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Set primary image
     */
    public function setPrimaryImage(Product $product, int $imageId): bool
    {
        // Reset all images to not primary
        $product->images()->update(['is_primary' => false]);

        // Set the selected image as primary
        $image = $product->images()->find($imageId);
        if ($image) {
            $image->update(['is_primary' => true]);
            return true;
        }

        return false;
    }

    /**
     * Generate unique SKU
     */
    public function generateUniqueSku(string $prefix = 'PRD'): string
    {
        do {
            $sku = $prefix . '-' . strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }
}
