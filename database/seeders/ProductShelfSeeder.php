<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Shelf;

class ProductShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active products and shelves
        $products = Product::where('status', 'active')->get();
        $shelves = Shelf::where('is_active', true)->get();

        if ($products->isEmpty() || $shelves->isEmpty()) {
            return;
        }

        // Define shelf assignments with specific products
        $shelfAssignments = [
            'Featured Products' => [
                'iPhone 15 Pro Max',
                'MacBook Air M3',
                'Samsung Galaxy S24 Ultra',
                'Sony WH-1000XM5',
                'iPad Pro 12.9" M2'
            ],
            'Best Sellers' => [
                'Apple AirPods Pro 2',
                'OnePlus 12',
                'Samsung 4K Smart TV 55"',
                'Sony WH-1000XM5',
                'Nintendo Switch OLED'
            ],
            'New Arrivals' => [
                'Google Pixel 8 Pro',
                'ASUS ROG Zephyrus G16',
                'Bose QuietComfort Ultra',
                'Samsung Galaxy Tab S9 Ultra',
                'LG OLED C3 65"'
            ],
            'On Sale' => [
                'Dell XPS 13 Plus',
                'Samsung 4K Smart TV 55"',
                'Sony Bravia XR A80L 55"',
                'Lenovo ThinkPad X1 Carbon'
            ],
            'Premium Collection' => [
                'iPhone 15 Pro Max',
                'MacBook Air M3',
                'ASUS ROG Zephyrus G16',
                'LG OLED C3 65"',
                'Bose QuietComfort Ultra'
            ],
            'Budget Friendly' => [
                'OnePlus 12',
                'Google Pixel 8 Pro',
                'Nintendo Switch OLED',
                'Apple AirPods Pro 2',
                'Samsung 4K Smart TV 55"'
            ],
            'Limited Edition' => [
                'iPhone 15 Pro Max',
                'ASUS ROG Zephyrus G16',
                'PlayStation 5 Slim'
            ],
            'Gaming Zone' => [
                'Nintendo Switch OLED',
                'PlayStation 5 Slim',
                'Xbox Series X',
                'ASUS ROG Zephyrus G16'
            ],
            'Productivity Tools' => [
                'MacBook Air M3',
                'Dell XPS 13 Plus',
                'Lenovo ThinkPad X1 Carbon',
                'iPad Pro 12.9" M2',
                'Samsung Galaxy Tab S9 Ultra'
            ],
            'Entertainment Hub' => [
                'Samsung 4K Smart TV 55"',
                'LG OLED C3 65"',
                'Sony Bravia XR A80L 55"',
                'Sony WH-1000XM5',
                'Apple AirPods Pro 2'
            ]
        ];

        foreach ($shelfAssignments as $shelfName => $productNames) {
            $shelf = $shelves->where('name', $shelfName)->first();

            if (!$shelf) {
                continue;
            }

            foreach ($productNames as $productName) {
                $product = $products->where('name', $productName)->first();

                if ($product) {
                    // Attach product to shelf if not already attached
                    if (!$shelf->products()->where('product_id', $product->id)->exists()) {
                        $shelf->products()->attach($product->id);
                    }
                }
            }
        }

        $this->command->info('Product-Shelf relationships seeded successfully!');
    }
}
