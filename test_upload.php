<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Test storage configuration
echo "Current app URL: " . config('app.url') . "\n";
echo "Storage public disk root: " . Storage::disk('public')->path('') . "\n";
echo "Asset URL for storage: " . asset('storage/categories/test.jpg') . "\n";

// Test file upload simulation
try {
    $testFilePath = public_path('assets/images/category/dairy-bread-eggs.png');

    if (!file_exists($testFilePath)) {
        echo "Source file not found: $testFilePath\n";
        exit;
    }

    echo "Source file exists: $testFilePath\n";

    // Create fake UploadedFile
    $uploadedFile = new UploadedFile(
        $testFilePath,
        'dairy-bread-eggs.png',
        'image/png',
        null,
        true // test mode
    );

    echo "UploadedFile created successfully\n";

    // Test storage
    $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
    $path = $uploadedFile->storeAs('public/categories', $filename);

    echo "File stored at: $path\n";
    echo "Full path: " . Storage::disk('local')->path($path) . "\n";
    echo "File exists: " . (Storage::disk('local')->exists($path) ? 'YES' : 'NO') . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
