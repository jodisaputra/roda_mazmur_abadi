@extends('layouts.frontend')

@section('title', $product->name . ' - FreshCart')

@section('content')
<main>
    <!-- Breadcrumb -->
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('homepage') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Section -->
    <section class="mt-8">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-6">
                    <!-- Product Image Gallery -->
                    <div class="product" id="product">
                        @if($product->images->isNotEmpty())
                            <div class="zoom"
                                 style="background-image: url('{{ Storage::url($product->images->first()->image_path) }}')">
                                <!-- Main product image -->
                                <img src="{{ Storage::url($product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid"
                                     id="mainProductImage">
                            </div>
                        @else
                            <div class="zoom no-image">
                                <div class="no-image-placeholder">
                                    <i class="bi bi-image" style="font-size: 4rem; color: #6c757d;"></i>
                                    <p class="text-muted mt-2 mb-0">No Image Available</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Product Thumbnails -->
                    @if($product->images->count() > 1)
                        <div class="product-tools">
                            <div class="thumbnails row g-3" id="productThumbnails">
                                @foreach($product->images as $index => $image)
                                    <div class="col">
                                        <div class="thumbnails-img {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ Storage::url($image->image_path) }}"
                                                 alt="{{ $product->name }}"
                                                 class="img-fluid"
                                                 data-image="{{ Storage::url($image->image_path) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-7 col-xl-6">
                    <div class="ps-lg-10 mt-6 mt-md-0">
                        <!-- Category badge -->
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="mb-4 d-block">
                            {{ $product->category->name }}
                        </a>

                        <!-- Product title -->
                        <h1 class="mb-1">{{ $product->name }}</h1>

                        <!-- Rating (placeholder for future implementation) -->
                        <div class="mb-4">
                            <small class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    ★
                                @endfor
                            </small>
                            <a href="#!" class="ms-2">(30 reviews)</a>
                        </div>

                        <!-- Price -->
                        <div class="fs-4">
                            <span class="fw-bold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        <hr class="my-6">

                        <!-- Product description -->
                        @if($product->description)
                            <div class="mb-5">
                                <h6 class="mb-1">Description:</h6>
                                <p>{{ $product->description }}</p>
                            </div>
                        @endif

                        <!-- Stock status -->
                        <div class="mb-4">
                            @if($product->stock_quantity > 0)
                                <span class="badge bg-light-success text-dark-success">
                                    ✓ In Stock ({{ $product->stock_quantity }} items)
                                </span>
                            @else
                                <span class="badge bg-light-danger text-dark-danger">
                                    ✗ Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Product actions (without Add to cart) -->
                        <div class="mt-3 row justify-content-start g-2 align-items-center">
                            <div class="col-md-6 col-6">
                                <a class="btn btn-outline-primary me-2" href="#!" title="Compare">
                                    🔄 Compare
                                </a>
                                <a class="btn btn-outline-danger" href="#!" title="Wishlist">
                                    ❤️ Wishlist
                                </a>
                            </div>
                        </div>

                        <hr class="my-6">

                        <!-- Product info table -->
                        <div>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Product Code:</td>
                                        <td>{{ $product->sku ?? 'FBT-' . $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Availability:</td>
                                        <td>
                                            @if($product->stock_quantity > 0)
                                                In Stock
                                            @else
                                                Out of Stock
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Category:</td>
                                        <td>
                                            <a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                                        </td>
                                    </tr>
                                    @if($product->shelf)
                                        <tr>
                                            <td>Shelf:</td>
                                            <td>{{ $product->shelf->name }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Details Tabs -->
    <section class="mt-lg-14 mt-8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills nav-lb-tab" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="product-tab" data-bs-toggle="pill" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                                Product Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="pill" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="false">
                                Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">
                                Reviews
                            </button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Product Details Tab -->
                        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
                            <div class="my-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($product->description)
                                            <p class="mb-0">{{ $product->description }}</p>
                                        @else
                                            <p class="mb-0">Product description will be available soon.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Tab -->
                        <div class="tab-pane fade" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                            <div class="my-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Product Code</td>
                                                        <td>{{ $product->sku ?? 'FBT-' . $product->id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Category</td>
                                                        <td>{{ $product->category->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Stock Quantity</td>
                                                        <td>{{ $product->stock_quantity }} items</td>
                                                    </tr>
                                                    @if($product->shelf)
                                                        <tr>
                                                            <td>Shelf</td>
                                                            <td>{{ $product->shelf->name }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>
                                                            @if($product->stock_quantity > 0)
                                                                <span class="badge bg-success">Available</span>
                                                            @else
                                                                <span class="badge bg-danger">Out of Stock</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                            <div class="my-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="me-lg-12 mb-6 mb-md-0">
                                            <div class="mb-5">
                                                <h6 class="mb-3">Customer reviews</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="text-warning">
                                                        <small>
                                                            ★★★★★
                                                        </small>
                                                    </div>
                                                    <span class="ms-3">4.1 out of 5</span>
                                                </div>
                                                <p class="fs-6 text-muted">11,130 global ratings</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="mb-10">
                                            <div class="d-flex justify-content-between align-items-center mb-8">
                                                <div>
                                                    <h5>Reviews</h5>
                                                </div>
                                                <div>
                                                    <a href="#" class="btn btn-outline-gray-400 btn-sm">Write a Review</a>
                                                </div>
                                            </div>
                                            <div class="d-flex border-bottom pb-6 mb-6">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 3rem; height: 3rem; font-size: 1.2rem; font-weight: bold;">
                                                    S
                                                </div>
                                                <div class="ms-1">
                                                    <h6 class="mb-1">Shankar Subbaraman</h6>
                                                    <p class="small">
                                                        <span class="text-muted">30 December 2022</span>
                                                        <span class="text-primary ms-3 fw-bold">Verified Purchase</span>
                                                    </p>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="text-warning">
                                                            <small>★★★★★</small>
                                                        </div>
                                                        <span class="ms-3 text-dark fw-bold">Great product quality!</span>
                                                    </div>
                                                    <p>
                                                        Product quality is excellent. Fast delivery and great packaging.
                                                        Would definitely recommend this product to others.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
        <section class="my-lg-14 my-14">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Related Items</h3>
                    </div>
                </div>
                <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-2 mt-2">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col">
                            <div class="card card-product">
                                <div class="card-body">
                                    <!-- Badge for sale -->
                                    <!-- Product Image -->
                                    <div class="text-center py-6">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                            @if($relatedProduct->images->isNotEmpty())
                                                <img src="{{ Storage::url($relatedProduct->images->first()->image_path) }}"
                                                     alt="{{ $relatedProduct->name }}"
                                                     class="mb-3 img-fluid"
                                                     style="height: 180px; object-fit: cover;">
                                            @else
                                                <div class="no-image-placeholder-small d-flex flex-column align-items-center justify-content-center"
                                                     style="height: 180px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px;">
                                                    <i class="bi bi-image" style="font-size: 2rem; color: #6c757d;"></i>
                                                    <small class="text-muted mt-1">No Image</small>
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                    <!-- Product details -->
                                    <div class="text-small mb-1">
                                        <a href="{{ route('categories.show', $relatedProduct->category->slug) }}" class="text-decoration-none text-muted">
                                            <small>{{ $relatedProduct->category->name }}</small>
                                        </a>
                                    </div>
                                    <h2 class="fs-6">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-inherit text-decoration-none">
                                            {{ Str::limit($relatedProduct->name, 40) }}
                                        </a>
                                    </h2>

                                    <!-- Rating (placeholder) -->
                                    <div>
                                        <small class="text-warning">★★★★★</small>
                                        <span class="text-muted small">4.5(149)</span>
                                    </div>

                                    <!-- Price -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="text-dark">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div>
                                            @if($relatedProduct->stock_quantity > 0)
                                                <span class="badge bg-success text-white">
                                                    In Stock
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white">
                                                    Out of Stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection

@push('styles')
<style>
    /* Product gallery styles */
    .product .zoom {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: contain;
        width: 100%;
        height: 450px;
        cursor: zoom-in;
        border: 1px solid #eee;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .product .zoom img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    .product-tools {
        margin-top: 1rem;
    }

    .thumbnails-img {
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: border-color 0.3s ease;
        background: #f8f9fa;
    }

    .thumbnails-img.active,
    .thumbnails-img:hover {
        border-color: #0aad0a;
    }

    .thumbnails-img img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        display: block;
    }

    /* Input spinner styles */
    .input-spinner {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        overflow: hidden;
        display: flex;
        align-items: stretch;
    }

    .input-spinner .button-minus,
    .input-spinner .button-plus {
        background: #f8f9fa;
        border: none;
        width: 40px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 18px;
        font-weight: bold;
    }

    .input-spinner .button-minus:hover,
    .input-spinner .button-plus:hover {
        background: #e9ecef;
        color: #495057;
    }

    .input-spinner .quantity-field {
        border: none;
        text-align: center;
        width: 60px;
        height: 38px;
        background: white;
        font-weight: 500;
        flex: 1;
        min-width: 60px;
    }

    .input-spinner .quantity-field:focus {
        outline: none;
        box-shadow: none;
    }

    /* Card product styles */
    .card-product {
        border: 1px solid #e3e6f0;
        transition: all 0.15s ease-in-out;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .card-product:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-color: #d1d3e2;
        transform: translateY(-2px);
    }

    .card-product .card-body {
        padding: 1.5rem;
        position: relative;
    }

    /* Tab styles */
    .nav-lb-tab {
        border-bottom: 1px solid #e3e6f0;
        margin-bottom: 0;
    }

    .nav-lb-tab .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        background: transparent;
        color: #6c757d;
        padding: 1rem 1.5rem;
        font-weight: 500;
        border-radius: 0;
        margin-bottom: -1px;
    }

    .nav-lb-tab .nav-link.active {
        border-bottom-color: #0aad0a;
        color: #0aad0a;
        background: transparent;
    }

    .nav-lb-tab .nav-link:hover {
        border-bottom-color: #0aad0a;
        color: #0aad0a;
        background: transparent;
    }

    /* Badge styles */
    .bg-light-success {
        background-color: rgba(10, 173, 10, 0.1) !important;
    }

    .text-dark-success {
        color: #0aad0a !important;
    }

    .bg-light-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .text-dark-danger {
        color: #dc3545 !important;
    }

    /* No image placeholder styles */
    .product .zoom.no-image {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px dashed #dee2e6;
        cursor: default;
    }

    .no-image-placeholder {
        text-align: center;
        padding: 2rem;
    }

    .no-image-placeholder-small {
        transition: all 0.3s ease;
    }

    .no-image-placeholder-small:hover {
        background-color: #e9ecef !important;
        border-color: #adb5bd !important;
    }

    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    /* Button styling improvements */
    .btn-primary {
        background-color: #0aad0a;
        border-color: #0aad0a;
    }

    .btn-primary:hover {
        background-color: #089808;
        border-color: #089808;
    }

    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-outline-gray-400 {
        border-color: #9ca3af;
        color: #6b7280;
    }

    .btn-outline-gray-400:hover {
        background-color: #9ca3af;
        border-color: #9ca3af;
        color: white;
    }

    /* Additional spacing */
    .mt-8 {
        margin-top: 4rem !important;
    }

    .mb-8 {
        margin-bottom: 4rem !important;
    }

    .py-6 {
        padding-top: 3rem !important;
        padding-bottom: 3rem !important;
    }

    .pb-6 {
        padding-bottom: 3rem !important;
    }

    .mb-6 {
        margin-bottom: 3rem !important;
    }

    .mb-10 {
        margin-bottom: 5rem !important;
    }

    .me-lg-12 {
        margin-right: 6rem !important;
    }

    @media (max-width: 991.98px) {
        .me-lg-12 {
            margin-right: 0 !important;
        }
    }

    /* Text utilities */
    .fs-6 {
        font-size: 1rem !important;
    }

    .text-inherit {
        color: inherit !important;
    }

    .text-inherit:hover {
        color: #0aad0a !important;
    }

    /* Border utilities */
    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }

    /* Table styling */
    .table-borderless td {
        border: none;
        padding: 0.5rem 0;
    }

    .table-borderless td:first-child {
        color: #6c757d;
        font-weight: 500;
        width: 40%;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .product .zoom {
            height: 300px;
        }

        .thumbnails-img img {
            height: 60px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle quantity buttons
        const minusButtons = document.querySelectorAll('.button-minus');
        const plusButtons = document.querySelectorAll('.button-plus');

        minusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('.quantity-field');
                const currentValue = parseInt(input.value);
                const minValue = parseInt(input.min) || 1;

                if (currentValue > minValue) {
                    input.value = currentValue - 1;
                }
            });
        });

        plusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('.quantity-field');
                const currentValue = parseInt(input.value);
                const maxValue = parseInt(input.max) || 999;

                if (currentValue < maxValue) {
                    input.value = currentValue + 1;
                }
            });
        });

        // Handle thumbnail clicks
        const thumbnails = document.querySelectorAll('.thumbnails-img img');
        const mainImage = document.getElementById('mainProductImage');
        const zoomDiv = document.querySelector('.zoom');

        thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', function() {
                // Remove active class from all thumbnails
                document.querySelectorAll('.thumbnails-img').forEach(thumb => {
                    thumb.classList.remove('active');
                });

                // Add active class to clicked thumbnail
                this.parentNode.classList.add('active');

                // Update main image
                if (mainImage) {
                    mainImage.src = this.src;
                }

                // Update zoom background
                if (zoomDiv) {
                    zoomDiv.style.backgroundImage = `url('${this.src}')`;
                }
            });
        });

        // Simple zoom functionality
        const zoomElements = document.querySelectorAll('.zoom');
        zoomElements.forEach(element => {
            element.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const offsetX = e.clientX - rect.left;
                const offsetY = e.clientY - rect.top;
                const x = (offsetX / this.offsetWidth) * 100;
                const y = (offsetY / this.offsetHeight) * 100;
                this.style.backgroundPosition = x + '% ' + y + '%';
                this.style.backgroundSize = '200%';
            });

            element.addEventListener('mouseleave', function() {
                this.style.backgroundPosition = 'center center';
                this.style.backgroundSize = 'contain';
            });
        });
    });
</script>
@endpush
