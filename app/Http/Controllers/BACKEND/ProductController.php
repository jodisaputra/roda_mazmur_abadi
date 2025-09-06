<?php

namespace App\Http\Controllers\BACKEND;

use App\Http\Controllers\Controller;
use App\Http\Requests\BACKEND\StoreProductRequest;
use App\Http\Requests\BACKEND\UpdateProductRequest;
use App\Imports\ProductImport;
use App\Models\Product;
use App\Services\ProductDataTableService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected ProductDataTableService $dataTableService;

    public function __construct(ProductService $productService, ProductDataTableService $dataTableService)
    {
        $this->productService = $productService;
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

        return view('BACKEND.product.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productService->getActiveCategories();
        $shelves = \App\Models\Shelf::active()->with('products')->get();

        return view('BACKEND.product.create', compact('categories', 'shelves'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->validated());

            sweet_alert_success('Success!', 'Product created successfully.');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to create product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images']);

        return view('BACKEND.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = $this->productService->getActiveCategories();
        $shelves = \App\Models\Shelf::active()->with('products')->get();
        $product->load(['category', 'images', 'shelves']);

        return view('BACKEND.product.edit', compact('product', 'categories', 'shelves'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->productService->updateProduct($product, $request->validated());

            sweet_alert_success('Success!', 'Product updated successfully.');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            sweet_alert_error('Error!', 'Failed to update product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->productService->deleteProduct($product);

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product): JsonResponse
    {
        try {
            $this->productService->toggleStatus($product);

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Toggle product stock status
     */
    public function toggleStock(Product $product): JsonResponse
    {
        try {
            $this->productService->toggleStockStatus($product);

            return response()->json([
                'success' => true,
                'message' => 'Product stock status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product stock status: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Generate unique slug from name
     */
    public function generateSlug(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $productId = $request->get('product_id'); // For edit form

        if (empty($name)) {
            return response()->json(['slug' => '']);
        }

        $slug = $this->productService->generateUniqueSlug($name, $productId);

        return response()->json(['slug' => $slug]);
    }

    /**
     * Generate unique SKU
     */
    public function generateSku(): JsonResponse
    {
        $sku = $this->productService->generateUniqueSku();

        return response()->json(['sku' => $sku]);
    }

    /**
     * Set primary image for product
     */
    public function setPrimaryImage(Product $product, Request $request): JsonResponse
    {
        try {
            $imageId = $request->get('image_id');
            $success = $this->productService->setPrimaryImage($product, $imageId);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Primary image updated successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to set primary image: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show import form
     */
    public function showImport()
    {
        return view('BACKEND.product.import');
    }

    /**
     * Handle Excel import
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Max 5MB per image
        ]);

        try {
            // Store uploaded images first if any
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->getClientOriginalName();
                    $image->storeAs('imports/images', $filename, 'public');
                }
            }

            // Import Excel file
            Excel::import(new ProductImport, $request->file('excel_file'));

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil diimpor dari Excel!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return redirect()
                ->back()
                ->withErrors($errorMessages)
                ->withInput();

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download sample Excel template
     */
    public function downloadTemplate()
    {
        $templatePath = storage_path('app/templates/product_import_template.xlsx');

        if (!file_exists($templatePath)) {
            // Create template if doesn't exist
            $this->createTemplate();
        }

        return response()->download($templatePath, 'template_import_produk.xlsx');
    }

    /**
     * Create Excel template for import
     */
    private function createTemplate()
    {
        // Create templates directory if doesn't exist
        $templatesDir = storage_path('app/templates');
        if (!file_exists($templatesDir)) {
            mkdir($templatesDir, 0755, true);
        }

        // Sample data for template
        $headers = [
            'name',
            'description',
            'price',
            'sku',
            'product_code',
            'stock_quantity',
            'in_stock',
            'status',
            'category',
            'shelves',
            'primary_image',
            'additional_images'
        ];        $sampleData = [
            [
                'iPhone 15 Pro Max',
                'iPhone terbaru dengan teknologi canggih dan kamera professional. Dilengkapi dengan chip A17 Pro dan sistem kamera ProRAW.',
                22999000,
                'IPHONE15PM256NT',
                'APL-IP15PM-256-NT',
                50,
                true,
                'active',
                'Smartphones',
                'Featured Products,Electronics,Best Sellers',
                'https://example.com/iphone15pro.jpg',
                'https://example.com/iphone15pro-2.jpg,https://example.com/iphone15pro-3.jpg'
            ],
            [
                'MacBook Air M3',
                'Laptop tipis dan ringan dengan chip M3 yang powerful untuk produktivitas maksimal. Performa luar biasa dengan efisiensi energi tinggi.',
                18999000,
                'MBAIRM3512MN',
                'APL-MBA-M3-512-MN',
                25,
                true,
                'active',
                'Laptops & Computers',
                'Featured Products,Computers',
                'macbook-air-m3.jpg',
                'macbook-air-m3-side.jpg,macbook-air-m3-open.jpg'
            ]
        ];

        // Create Excel file using PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Product Import Template');

        // Set headers with styling
        $columnIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
            $sheet->getStyleByColumnAndRow($columnIndex, 1)->getFont()->setBold(true);
            $sheet->getStyleByColumnAndRow($columnIndex, 1)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE2E2E2');
            $sheet->getColumnDimensionByColumn($columnIndex)->setWidth(20);
            $columnIndex++;
        }

        // Set sample data
        $rowIndex = 2;
        foreach ($sampleData as $data) {
            $columnIndex = 1;
            foreach ($data as $value) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                $columnIndex++;
            }
            $rowIndex++;
        }

        // Add instructions worksheet
        $instructionsSheet = $spreadsheet->createSheet();
        $instructionsSheet->setTitle('Instructions');

        $instructions = [
            ['PETUNJUK IMPORT PRODUK'],
            [''],
            ['KOLOM WAJIB:'],
            ['name', 'Nama produk (wajib diisi)'],
            ['price', 'Harga produk dalam rupiah (wajib diisi, angka)'],
            [''],
            ['KOLOM OPSIONAL:'],
            ['description', 'Deskripsi lengkap produk'],
            ['sku', 'Kode SKU produk (unik)'],
            ['product_code', 'Kode produk internal'],
            ['stock_quantity', 'Jumlah stok (angka, default: 0)'],
            ['in_stock', 'Status stok tersedia (true/false, default: true)'],
            ['status', 'Status produk (active/draft/inactive, default: draft)'],
            ['category', 'Nama kategori (otomatis dibuat jika belum ada)'],
            ['shelves', 'Nama shelf, pisahkan dengan koma jika lebih dari 1'],
            ['primary_image', 'URL gambar utama atau nama file'],
            ['additional_images', 'URL/nama file gambar tambahan, pisahkan dengan koma'],
            [''],
            ['CARA IMPORT GAMBAR:'],
            ['1. URL: Masukkan URL lengkap gambar (akan diunduh otomatis)'],
            ['2. File: Upload file gambar di form, lalu tulis nama file di Excel'],
            [''],
            ['CONTOH:'],
            ['primary_image: https://example.com/gambar.jpg'],
            ['primary_image: nama-file.jpg (jika sudah diupload)'],
            ['additional_images: gambar1.jpg,gambar2.jpg,gambar3.jpg'],
            [''],
            ['CATATAN PENTING:'],
            ['- Kolom name dan price wajib diisi'],
            ['- SKU harus unik jika diisi'],
            ['- Status: active (aktif), draft (draft), inactive (tidak aktif)'],
            ['- in_stock: true (tersedia), false (tidak tersedia)'],
            ['- stock_quantity: angka untuk jumlah stok']
        ];

        $rowIndex = 1;
        foreach ($instructions as $instruction) {
            if (count($instruction) === 1) {
                $instructionsSheet->setCellValue('A' . $rowIndex, $instruction[0]);
                if (strpos($instruction[0], 'PETUNJUK') !== false ||
                    strpos($instruction[0], 'KOLOM') !== false ||
                    strpos($instruction[0], 'CARA') !== false ||
                    strpos($instruction[0], 'CONTOH') !== false) {
                    $instructionsSheet->getStyle('A' . $rowIndex)->getFont()->setBold(true);
                }
            } else if (count($instruction) === 2) {
                $instructionsSheet->setCellValue('A' . $rowIndex, $instruction[0]);
                $instructionsSheet->setCellValue('B' . $rowIndex, $instruction[1]);
                $instructionsSheet->getStyle('A' . $rowIndex)->getFont()->setBold(true);
            }
            $rowIndex++;
        }

        $instructionsSheet->getColumnDimension('A')->setWidth(25);
        $instructionsSheet->getColumnDimension('B')->setWidth(60);

        // Save template
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(storage_path('app/templates/product_import_template.xlsx'));
    }
}
