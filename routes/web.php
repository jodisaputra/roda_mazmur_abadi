<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FRONTEND\HomeController;
use App\Http\Controllers\BACKEND\CategoryController;
use App\Http\Controllers\BACKEND\DashboardController;

Route::get('/', HomeController::class)->name('home');

// Test SweetAlert Frontend
Route::get('/test-frontend-alert', function () {
    sweet_alert_success('Frontend Success!', 'SweetAlert is working on frontend!');
    return redirect()->route('home');
})->name('test.frontend.alert');

Auth::routes();


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    // Test SweetAlert
    Route::get('/test-alert', function () {
        sweet_alert_success('Test Success!', 'SweetAlert is working perfectly!');
        return redirect()->route('admin.categories.index');
    })->name('test.alert');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::post('categories/generate-slug', [CategoryController::class, 'generateSlug'])->name('categories.generate-slug');
});
