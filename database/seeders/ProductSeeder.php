<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some categories first
        $categories = Category::all();

        if ($categories->isEmpty()) {
            // Create a default category if none exists
            $category = Category::create([
                'name' => 'General',
                'slug' => 'general',
                'status' => 'active'
            ]);
            $categories = collect([$category]);
        }

        $products = [
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Smartphone flagship terbaru dari Samsung dengan teknologi AI canggih, kamera 200MP, dan performa tinggi untuk segala kebutuhan.',
                'price' => 15999000,
                'stock_quantity' => 25,
                'sku' => 'SAM-S24-001',
                'product_code' => 'SAMSUNG001',
                'status' => 'active',
                'in_stock' => true,
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'iPhone terbaru dengan chip A17 Pro, kamera yang powerful, dan desain titanium yang premium.',
                'price' => 22999000,
                'stock_quantity' => 15,
                'sku' => 'APL-I15PM-001',
                'product_code' => 'APPLE001',
                'status' => 'active',
                'in_stock' => true,
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'Laptop ultraportable dengan chip M3 yang revolusioner, perfect untuk produktivitas dan kreativitas.',
                'price' => 18999000,
                'stock_quantity' => 8,
                'sku' => 'APL-MBA-M3-001',
                'product_code' => 'APPLE002',
                'status' => 'active',
                'in_stock' => true,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Headphone wireless premium dengan teknologi noise canceling terdepan untuk pengalaman audio terbaik.',
                'price' => 4999000,
                'stock_quantity' => 35,
                'sku' => 'SNY-WH1000XM5-001',
                'product_code' => 'SONY001',
                'status' => 'active',
                'in_stock' => true,
            ],
            [
                'name' => 'Dell XPS 13 Plus',
                'description' => 'Laptop premium dengan desain minimalis, performa tinggi, dan layar InfinityEdge yang memukau.',
                'price' => 23999000,
                'stock_quantity' => 5,
                'sku' => 'DEL-XPS13P-001',
                'product_code' => 'DELL001',
                'status' => 'active',
                'in_stock' => true,
            ],
            [
                'name' => 'iPad Pro 12.9" M2',
                'description' => 'Tablet pro dengan chip M2 yang powerful, Perfect untuk digital art, produktivitas, dan entertainment.',
                'price' => 16999000,
                'stock_quantity' => 12,
                'sku' => 'APL-IPP129-M2-001',
                'product_code' => 'APPLE003',
                'status' => 'draft',
                'in_stock' => true,
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Gaming console hybrid dengan layar OLED yang vibrant untuk gaming di rumah maupun portable.',
                'price' => 4299000,
                'stock_quantity' => 0,
                'sku' => 'NIN-SW-OLED-001',
                'product_code' => 'NINTENDO001',
                'status' => 'active',
                'in_stock' => false,
            ],
            [
                'name' => 'Samsung 4K Smart TV 55"',
                'description' => 'Smart TV 4K dengan teknologi QLED, HDR10+, dan berbagai fitur smart untuk hiburan keluarga.',
                'price' => 12999000,
                'stock_quantity' => 18,
                'sku' => 'SAM-TV55-4K-001',
                'product_code' => 'SAMSUNG002',
                'status' => 'active',
                'in_stock' => true,
            ],
        ];

        foreach ($products as $productData) {
            $productData['category_id'] = $categories->random()->id;
            Product::create($productData);
        }
    }
}
