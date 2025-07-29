<?php

namespace App\Http\Controllers\BACKEND;

use App\Http\Controllers\Controller;
use App\Http\Requests\BACKEND\StoreCategoryRequest;
use App\Http\Requests\BACKEND\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryDataTableService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected CategoryDataTableService $dataTableService;

    public function __construct(CategoryService $categoryService, CategoryDataTableService $dataTableService)
    {
        $this->categoryService = $categoryService;
        $this->dataTableService = $dataTableService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dataTableService->getDataTable();
        }

        $html = $this->dataTableService->getHtmlBuilder();

        return view('BACKEND.category.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = $this->categoryService->getParentOptions();

        return view('BACKEND.category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());

            sweet_alert_success('Success!', 'Category created successfully.');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to create category: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children']);

        return view('BACKEND.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = $this->categoryService->getParentOptions($category->id);

        return view('BACKEND.category.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $this->categoryService->updateCategory($category, $request->validated());

            sweet_alert_success('Success!', 'Category updated successfully.');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to update category: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->categoryService->deleteCategory($category);

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Category $category): JsonResponse
    {
        try {
            $this->categoryService->toggleStatus($category);

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category status: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Generate unique slug from name
     */
    public function generateSlug(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $categoryId = $request->get('category_id'); // For edit form

        if (empty($name)) {
            return response()->json(['slug' => '']);
        }

        $slug = $this->categoryService->generateUniqueSlug($name, $categoryId);

        return response()->json(['slug' => $slug]);
    }
}
