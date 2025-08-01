<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shelf;

class ShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shelves = [
            [
                'name' => 'Featured Products',
                'slug' => 'featured-products',
                'is_active' => true,
                'capacity' => 10,
            ],
            [
                'name' => 'Best Sellers',
                'slug' => 'best-sellers',
                'is_active' => true,
                'capacity' => 8,
            ],
            [
                'name' => 'New Arrivals',
                'slug' => 'new-arrivals',
                'is_active' => true,
                'capacity' => 12,
            ],
            [
                'name' => 'On Sale',
                'slug' => 'on-sale',
                'is_active' => true,
                'capacity' => 15,
            ],
            [
                'name' => 'Premium Collection',
                'slug' => 'premium-collection',
                'is_active' => true,
                'capacity' => 6,
            ],
            [
                'name' => 'Budget Friendly',
                'slug' => 'budget-friendly',
                'is_active' => true,
                'capacity' => 20,
            ],
            [
                'name' => 'Limited Edition',
                'slug' => 'limited-edition',
                'is_active' => true,
                'capacity' => 5,
            ],
            [
                'name' => 'Gaming Zone',
                'slug' => 'gaming-zone',
                'is_active' => true,
                'capacity' => 8,
            ],
            [
                'name' => 'Productivity Tools',
                'slug' => 'productivity-tools',
                'is_active' => true,
                'capacity' => 10,
            ],
            [
                'name' => 'Entertainment Hub',
                'slug' => 'entertainment-hub',
                'is_active' => true,
                'capacity' => 12,
            ],
        ];

        foreach ($shelves as $shelf) {
            Shelf::updateOrCreate(
                ['slug' => $shelf['slug']],
                $shelf
            );
        }
    }
}
