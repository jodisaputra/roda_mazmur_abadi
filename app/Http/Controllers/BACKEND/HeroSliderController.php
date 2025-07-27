<?php

namespace App\Http\Controllers\BACKEND;

use App\Models\HeroSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeroSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all active hero sliders ordered by sort order
        $heroSliders = HeroSlider::active()->ordered()->get();

        // Return the view with the hero sliders
        return view('backend.hero_sliders.index', compact('heroSliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
