<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Kategori untuk semua produk elektronik seperti smartphone, laptop, dan gadget lainnya.',
                'status' => 'active',
                'parent_id' => null,
            ],
            [
                'name' => 'Smartphones',
                'description' => 'Kategori khusus untuk smartphone dan ponsel pintar.',
                'status' => 'active',
                'parent_id' => null, // Will be updated after Electronics is created
            ],
            [
                'name' => 'Laptops & Computers',
                'description' => 'Kategori untuk laptop, desktop, dan aksesoris komputer.',
                'status' => 'active',
                'parent_id' => null, // Will be updated after Electronics is created
            ],
            [
                'name' => 'Audio & Video',
                'description' => 'Kategori untuk perangkat audio dan video seperti headphone, speaker, TV.',
                'status' => 'active',
                'parent_id' => null, // Will be updated after Electronics is created
            ],
            [
                'name' => 'Gaming',
                'description' => 'Kategori untuk konsol gaming dan aksesoris gaming.',
                'status' => 'active',
                'parent_id' => null,
            ],
            [
                'name' => 'Tablets',
                'description' => 'Kategori untuk tablet dan iPad.',
                'status' => 'active',
                'parent_id' => null, // Will be updated after Electronics is created
            ],
            [
                'name' => 'Smart TV',
                'description' => 'Kategori khusus untuk Smart TV dan perangkat streaming.',
                'status' => 'active',
                'parent_id' => null, // Will be updated after Audio & Video is created
            ],
            [
                'name' => 'Headphones',
                'description' => 'Kategori khusus untuk headphone dan earphone.',
                'status' => 'active',
                'parent_id' => null, // Will be updated after Audio & Video is created
            ],
        ];

        // Create main categories first
        $electronicsCategory = Category::updateOrCreate(
            ['name' => 'Electronics'],
            $categories[0]
        );

        $audioVideoCategory = Category::updateOrCreate(
            ['name' => 'Audio & Video'],
            $categories[3]
        );

        $gamingCategory = Category::updateOrCreate(
            ['name' => 'Gaming'],
            $categories[4]
        );

        // Create subcategories with proper parent relationships
        Category::updateOrCreate(
            ['name' => 'Smartphones'],
            array_merge($categories[1], ['parent_id' => $electronicsCategory->id])
        );

        Category::updateOrCreate(
            ['name' => 'Laptops & Computers'],
            array_merge($categories[2], ['parent_id' => $electronicsCategory->id])
        );

        Category::updateOrCreate(
            ['name' => 'Tablets'],
            array_merge($categories[5], ['parent_id' => $electronicsCategory->id])
        );

        Category::updateOrCreate(
            ['name' => 'Smart TV'],
            array_merge($categories[6], ['parent_id' => $audioVideoCategory->id])
        );

        Category::updateOrCreate(
            ['name' => 'Headphones'],
            array_merge($categories[7], ['parent_id' => $audioVideoCategory->id])
        );
    }
}
