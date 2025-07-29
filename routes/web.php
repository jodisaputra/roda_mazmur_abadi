<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FRONTEND\HomeController;
use App\Http\Controllers\BACKEND\CategoryController;
use App\Http\Controllers\BACKEND\ProductController;
use App\Http\Controllers\BACKEND\DashboardController;
use App\Http\Controllers\BACKEND\ShelfController;

Route::get('/', HomeController::class)->name('home');

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::post('categories/generate-slug', [CategoryController::class, 'generateSlug'])->name('categories.generate-slug');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{product}/toggle-stock', [ProductController::class, 'toggleStock'])->name('products.toggle-stock');
    Route::post('products/generate-slug', [ProductController::class, 'generateSlug'])->name('products.generate-slug');
    Route::post('products/generate-sku', [ProductController::class, 'generateSku'])->name('products.generate-sku');
    Route::post('products/{product}/set-primary-image', [ProductController::class, 'setPrimaryImage'])->name('products.set-primary-image');

    // Shelves
    Route::resource('shelves', ShelfController::class);
    Route::get('shelves/{shelf}/manage-products', [ShelfController::class, 'manageProducts'])->name('shelves.manage-products');
    Route::post('shelves/{shelf}/update-products', [ShelfController::class, 'updateProducts'])->name('shelves.update-products');
});
