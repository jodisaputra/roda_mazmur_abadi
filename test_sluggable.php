<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->boot();

use App\Models\Category;

// Test creating category with Eloquent Sluggable
echo "Testing Eloquent Sluggable...\n";

$category = Category::create([
    'name' => 'Eloquent Test Category',
    'status' => 'active'
]);

echo "Created category with slug: " . $category->slug . "\n";

// Test duplicate name
$category2 = Category::create([
    'name' => 'Eloquent Test Category',
    'status' => 'active'
]);

echo "Created duplicate with slug: " . $category2->slug . "\n";

// Clean up
$category->delete();
$category2->delete();

echo "Test completed successfully!\n";
