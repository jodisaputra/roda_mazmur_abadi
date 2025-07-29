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
        ];

        foreach ($shelves as $shelf) {
            Shelf::updateOrCreate(
                ['slug' => $shelf['slug']],
                $shelf
            );
        }
    }
}
