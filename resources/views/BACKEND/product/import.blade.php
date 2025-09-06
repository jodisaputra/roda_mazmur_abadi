@extends('layouts.backend')

@section('title', 'Import Produk')

@push('styles')
<style>
    .import-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .step-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: white;
    }

    .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
    }

    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }

    .file-upload-area.dragover {
        border-color: #28a745;
        background-color: #d4edda;
    }

    .uploaded-files {
        margin-top: 1rem;
    }

    .file-item {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        background: #f8f9fa;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .file-item .file-name {
        flex: 1;
        margin-left: 0.5rem;
    }

    .file-item .file-size {
        color: #6c757d;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Import Produk</h1>
            <p class="text-muted">Import produk dalam jumlah besar menggunakan file Excel</p>
        </div>
        <div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="import-container">
        <!-- Step 1: Download Template -->
        <div class="step-card">
            <div class="d-flex align-items-start">
                <div class="step-number">1</div>
                <div class="flex-fill">
                    <h5 class="mb-2">Download Template Excel</h5>
                    <p class="text-muted mb-3">
                        Download template Excel untuk melihat format yang benar dan contoh data produk.
                    </p>
                    <a href="{{ route('admin.products.download-template') }}" class="btn btn-success">
                        <i class="bi bi-download"></i> Download Template
                    </a>
                </div>
            </div>
        </div>

        <!-- Step 2: Prepare Images (Optional) -->
        <div class="step-card">
            <div class="d-flex align-items-start">
                <div class="step-number">2</div>
                <div class="flex-fill">
                    <h5 class="mb-2">Persiapkan Gambar (Opsional)</h5>
                    <p class="text-muted mb-3">
                        Jika Anda ingin mengimpor gambar, ada dua cara:
                    </p>
                    <ul class="text-muted mb-3">
                        <li><strong>URL Gambar:</strong> Masukkan URL langsung di kolom Excel (gambar akan diunduh otomatis)</li>
                        <li><strong>Upload File:</strong> Upload file gambar di bawah, lalu tulis nama file di Excel</li>
                    </ul>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Format yang didukung:</strong> JPG, PNG, GIF, SVG. Maksimal 5MB per file.
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Import Form -->
        <div class="step-card">
            <div class="d-flex align-items-start">
                <div class="step-number">3</div>
                <div class="flex-fill">
                    <h5 class="mb-3">Upload File Excel & Gambar</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Excel File Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">File Excel <span class="text-danger">*</span></label>
                            <div class="file-upload-area" id="excelUploadArea">
                                <i class="bi bi-file-earmark-spreadsheet fs-1 text-muted"></i>
                                <p class="mt-2 mb-2">Klik atau drag & drop file Excel di sini</p>
                                <p class="text-muted small">Format: XLSX, XLS, CSV. Maksimal 10MB</p>
                                <input type="file" name="excel_file" id="excelFile" accept=".xlsx,.xls,.csv" required style="display: none;">
                            </div>
                            <div id="excelFiles" class="uploaded-files"></div>
                        </div>

                        <!-- Images Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gambar Produk (Opsional)</label>
                            <div class="file-upload-area" id="imageUploadArea">
                                <i class="bi bi-images fs-1 text-muted"></i>
                                <p class="mt-2 mb-2">Klik atau drag & drop gambar di sini</p>
                                <p class="text-muted small">Format: JPG, PNG, GIF, SVG. Maksimal 5MB per file</p>
                                <input type="file" name="images[]" id="imageFiles" accept="image/*" multiple style="display: none;">
                            </div>
                            <div id="uploadedImages" class="uploaded-files"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-upload"></i> Mulai Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="step-card">
            <h5 class="mb-3">Petunjuk Penggunaan</h5>
            <div class="row">
                <div class="col-md-6">
                    <h6>Kolom Wajib:</h6>
                    <ul class="small">
                        <li><strong>name:</strong> Nama produk</li>
                        <li><strong>price:</strong> Harga produk (angka)</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Kolom Opsional:</h6>
                    <ul class="small">
                        <li><strong>description:</strong> Deskripsi produk</li>
                        <li><strong>sku:</strong> Kode SKU (unik)</li>
                        <li><strong>product_code:</strong> Kode produk internal</li>
                        <li><strong>stock_quantity:</strong> Jumlah stok (angka)</li>
                        <li><strong>in_stock:</strong> Status stok (true/false)</li>
                        <li><strong>status:</strong> Status (active/draft/inactive)</li>
                        <li><strong>category:</strong> Nama kategori</li>
                        <li><strong>shelves:</strong> Nama shelf (pisahkan dengan koma)</li>
                        <li><strong>primary_image:</strong> URL/nama file gambar utama</li>
                        <li><strong>additional_images:</strong> URL/nama file (pisahkan dengan koma)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Excel file upload
    const excelUploadArea = document.getElementById('excelUploadArea');
    const excelFileInput = document.getElementById('excelFile');
    const excelFilesContainer = document.getElementById('excelFiles');

    // Image upload
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageFileInput = document.getElementById('imageFiles');
    const uploadedImagesContainer = document.getElementById('uploadedImages');

    // Setup file upload for Excel
    setupFileUpload(excelUploadArea, excelFileInput, excelFilesContainer, false);

    // Setup file upload for Images
    setupFileUpload(imageUploadArea, imageFileInput, uploadedImagesContainer, true);

    function setupFileUpload(uploadArea, fileInput, container, multiple) {
        // Click to upload
        uploadArea.addEventListener('click', () => fileInput.click());

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');

            if (multiple) {
                fileInput.files = e.dataTransfer.files;
            } else {
                // For single file, create a new FileList
                const dt = new DataTransfer();
                dt.items.add(e.dataTransfer.files[0]);
                fileInput.files = dt.files;
            }

            displayFiles(fileInput.files, container);
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            displayFiles(e.target.files, container);
        });
    }

    function displayFiles(files, container) {
        container.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';

            const fileSize = formatFileSize(file.size);

            fileItem.innerHTML = `
                <i class="bi bi-file-check text-success"></i>
                <span class="file-name">${file.name}</span>
                <span class="file-size">${fileSize}</span>
            `;

            container.appendChild(fileItem);
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endpush
