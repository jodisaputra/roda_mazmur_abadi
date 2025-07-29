<?php

namespace App\Http\Controllers\FRONTEND;

use App\Models\HeroSlider;
use App\Models\Shelf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Get active shelves with their active products (limit 10 products per shelf)
        $shelves = Shelf::active()
            ->with(['activeProducts' => function ($query) {
                $query->with(['primaryImage', 'category'])
                      ->limit(10);
            }])
            ->get();

        return view('index', compact('shelves'));
    }
}
