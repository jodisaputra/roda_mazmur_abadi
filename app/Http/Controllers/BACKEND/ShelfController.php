<?php

namespace App\Http\Controllers\BACKEND;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use App\Services\ShelfService;
use App\Http\Requests\BACKEND\StoreShelfRequest;
use App\Http\Requests\BACKEND\UpdateShelfRequest;
use App\Http\Requests\BACKEND\UpdateShelfProductsRequest;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    protected $shelfService;

    public function __construct(ShelfService $shelfService)
    {
        $this->shelfService = $shelfService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->shelfService->getShelvesForDataTable();
        }

        return view('BACKEND.shelves.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('BACKEND.shelves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShelfRequest $request)
    {
        try {
            $this->shelfService->createShelf($request->validated());

            sweet_alert_success('Success!', 'Shelf created successfully.');
            return redirect()->route('admin.shelves.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to create shelf: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shelf $shelf)
    {
        $shelf->load(['products' => function ($query) {
            $query->with(['category', 'primaryImage']);
        }]);

        return view('BACKEND.shelves.show', compact('shelf'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shelf $shelf)
    {
        return view('BACKEND.shelves.edit', compact('shelf'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShelfRequest $request, Shelf $shelf)
    {
        try {
            $this->shelfService->updateShelf($shelf, $request->validated());

            sweet_alert_success('Success!', 'Shelf updated successfully.');
            return redirect()->route('admin.shelves.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to update shelf: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shelf $shelf)
    {
        try {
            $this->shelfService->deleteShelf($shelf);
            return response()->json(['success' => true, 'message' => 'Shelf deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete shelf: ' . $e->getMessage()]);
        }
    }

    /**
     * Manage products in shelf
     */
    public function manageProducts(Shelf $shelf)
    {
        $data = $this->shelfService->getShelfWithProducts($shelf);
        $capacityInfo = $this->shelfService->getAvailableProductsCount($shelf);

        return view('BACKEND.shelves.manage-products', array_merge($data, ['capacityInfo' => $capacityInfo]));
    }

    /**
     * Update products in shelf
     */
    public function updateProducts(UpdateShelfProductsRequest $request, Shelf $shelf)
    {
        try {
            $products = $request->input('products', []);
            $this->shelfService->updateShelfProducts($shelf, $products);

            sweet_alert_success('Success!', 'Shelf products updated successfully.');
            return redirect()->route('admin.shelves.show', $shelf);
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to update shelf products: ' . $e->getMessage());
            return back();
        }
    }
}
