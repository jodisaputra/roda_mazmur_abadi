<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Get all categories with optional relations
     */
    public function getAllCategories(array $relations = []): Collection
    {
        return Category::with($relations)->orderBy('name')->get();
    }

    /**
     * Get categories for parent selection (excluding the current category and its descendants)
     */
    public function getParentOptions(?int $excludeId = null): Collection
    {
        $query = Category::whereNull('parent_id')->with('children');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Create a new category
     */
    public function createCategory(array $data): Category
    {
        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $this->handleImageUpload($data['image']);
        }

        // Eloquent Sluggable will automatically generate slug from name
        return Category::create($data);
    }

    /**
     * Update an existing category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        // Prevent circular parent relationships
        if (isset($data['parent_id']) && $data['parent_id']) {
            if ($this->wouldCreateCircularReference($category->id, $data['parent_id'])) {
                throw new \InvalidArgumentException('Cannot set parent category as it would create a circular reference.');
            }
        }

        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            // Delete old image if exists
            if ($category->image) {
                $this->deleteImage($category->image);
            }
            $data['image'] = $this->handleImageUpload($data['image']);
        }

        // Eloquent Sluggable will automatically regenerate slug if name changes

        $category->update($data);
        return $category->fresh();
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Category $category): bool
    {
        // Check if category has children
        if ($category->children()->exists()) {
            throw new \InvalidArgumentException('Cannot delete category that has child categories.');
        }

        // Delete image if exists
        if ($category->image) {
            $this->deleteImage($category->image);
        }

        return $category->delete();
    }

    /**
     * Get category by ID with relations
     */
    public function getCategoryById(int $id, array $relations = []): ?Category
    {
        return Category::with($relations)->find($id);
    }

    /**
     * Get category by slug
     */
    public function getCategoryBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }

    /**
     * Generate a unique slug using Eloquent Sluggable
     */
    public function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        // For AJAX requests, we'll use a simple approach to generate preview slug
        // The actual unique slug will be generated when saving the model

        // Create basic slug
        $slug = \Illuminate\Support\Str::slug($name);

        // Check for uniqueness manually for preview
        $query = Category::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $counter = 1;
        $originalSlug = $slug;

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $query = Category::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if setting a parent would create a circular reference
     */
    private function wouldCreateCircularReference(int $categoryId, int $parentId): bool
    {
        $parent = Category::find($parentId);

        while ($parent) {
            if ($parent->id === $categoryId) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }

    /**
     * Get active categories
     */
    public function getActiveCategories(): Collection
    {
        return Category::active()->orderBy('name')->get();
    }

    /**
     * Get root categories (no parent)
     */
    public function getRootCategories(): Collection
    {
        return Category::root()->orderBy('name')->get();
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Category $category): Category
    {
        $category->update([
            'status' => $category->status === 'active' ? 'disabled' : 'active'
        ]);

        return $category->fresh();
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload($image): string
    {
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/categories', $filename);
        return 'categories/' . $filename;
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
}
