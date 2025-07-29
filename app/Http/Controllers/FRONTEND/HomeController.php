<?php

namespace App\Http\Controllers\FRONTEND;

use App\Models\HeroSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('index');
    }
}
