<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Shelf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Find or create category
                $category = null;
                if (!empty($row['category'])) {
                    $category = Category::where('name', $row['category'])
                        ->orWhere('slug', Str::slug($row['category']))
                        ->first();

                    if (!$category) {
                        $category = Category::create([
                            'name' => $row['category'],
                            'slug' => Str::slug($row['category']),
                            'description' => 'Auto-created from import',
                            'is_active' => true,
                        ]);
                    }
                }

                // Create product
                $product = Product::create([
                    'name' => $row['name'],
                    'slug' => Str::slug($row['name'] . '-' . Str::random(6)),
                    'description' => $row['description'] ?? '',
                    'price' => (float) $row['price'],
                    'sku' => $row['sku'] ?? null,
                    'product_code' => $row['product_code'] ?? null,
                    'stock_quantity' => !empty($row['stock_quantity']) ? (int) $row['stock_quantity'] : 0,
                    'in_stock' => !empty($row['in_stock']) ? (bool) $row['in_stock'] : true,
                    'category_id' => $category?->id,
                    'status' => $row['status'] ?? 'draft',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Handle shelf associations
                if (!empty($row['shelves'])) {
                    $shelfNames = explode(',', $row['shelves']);
                    $shelfIds = [];

                    foreach ($shelfNames as $shelfName) {
                        $shelfName = trim($shelfName);
                        $shelf = Shelf::where('name', $shelfName)
                            ->orWhere('slug', Str::slug($shelfName))
                            ->first();

                        if (!$shelf) {
                            $shelf = Shelf::create([
                                'name' => $shelfName,
                                'slug' => Str::slug($shelfName),
                                'description' => 'Auto-created from import',
                                'is_active' => true,
                            ]);
                        }

                        $shelfIds[] = $shelf->id;
                    }

                    $product->shelves()->sync($shelfIds);
                }

                // Handle image import
                $this->handleImageImport($product, $row);

            } catch (\Exception $e) {
                Log::error('Product import error for row: ' . json_encode($row->toArray()) . '. Error: ' . $e->getMessage());
                continue;
            }
        }
    }

    private function handleImageImport(Product $product, $row)
    {
        // Handle primary image
        if (!empty($row['primary_image'])) {
            $this->downloadAndAttachImage($product, $row['primary_image'], true);
        }

        // Handle additional images (comma separated URLs or file names)
        if (!empty($row['additional_images'])) {
            $imageUrls = explode(',', $row['additional_images']);
            foreach ($imageUrls as $imageUrl) {
                $imageUrl = trim($imageUrl);
                if (!empty($imageUrl)) {
                    $this->downloadAndAttachImage($product, $imageUrl, false);
                }
            }
        }
    }

    private function downloadAndAttachImage(Product $product, $imageSource, $isPrimary = false)
    {
        try {
            $imagePath = null;

            // Check if it's a URL
            if (filter_var($imageSource, FILTER_VALIDATE_URL)) {
                // Download image from URL
                $response = Http::timeout(30)->get($imageSource);

                if ($response->successful()) {
                    $extension = pathinfo(parse_url($imageSource, PHP_URL_PATH), PATHINFO_EXTENSION);
                    if (empty($extension)) {
                        $extension = 'jpg'; // default extension
                    }

                    $filename = 'product-' . $product->id . '-' . Str::random(8) . '.' . $extension;
                    $path = 'products/' . $filename;

                    Storage::disk('public')->put($path, $response->body());
                    $imagePath = $path;
                }
            } else {
                // Assume it's a file name in storage/app/public/imports/images/
                $importPath = 'imports/images/' . $imageSource;

                if (Storage::disk('public')->exists($importPath)) {
                    // Copy to products directory
                    $extension = pathinfo($imageSource, PATHINFO_EXTENSION);
                    $filename = 'product-' . $product->id . '-' . Str::random(8) . '.' . $extension;
                    $newPath = 'products/' . $filename;

                    Storage::disk('public')->copy($importPath, $newPath);
                    $imagePath = $newPath;
                }
            }

            // Create product image record
            if ($imagePath) {
                $product->images()->create([
                    'image' => $imagePath,
                    'alt_text' => $product->name,
                    'is_primary' => $isPrimary,
                    'sort_order' => $isPrimary ? 0 : ($product->images()->count() + 1),
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Image import error for product ' . $product->id . ': ' . $e->getMessage());
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Nama produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh kurang dari 0',
        ];
    }
}
