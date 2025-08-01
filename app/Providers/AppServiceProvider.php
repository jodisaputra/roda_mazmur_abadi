<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\CategoryComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register CategoryComposer for navbar and all frontend views
        View::composer([
            'layouts.partials.frontend.navbar',
            'layouts.frontend'
        ], CategoryComposer::class);
    }
}
