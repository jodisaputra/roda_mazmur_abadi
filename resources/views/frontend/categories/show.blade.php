@extends('layouts.frontend')

@section('title', $category->name . ' - Products')

@section('content')
<main>
    <script>document.body.classList.add('grid-view');</script>
    <!-- Breadcrumb section -->
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('homepage') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('categories.index') }}">Categories</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main section -->
    <div class="mt-8 mb-lg-14 mb-8">
        <div class="container">
            <div class="row gx-10">
                <!-- Sidebar -->
                <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
                    <div class="offcanvas offcanvas-start offcanvas-collapse w-md-50" tabindex="-1" id="offcanvasCategory">
                        <div class="offcanvas-header d-lg-none">
                            <h5 class="offcanvas-title">Filter</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body ps-lg-2 pt-lg-0">
                            <!-- Categories Filter -->
                            <div class="py-4">
                                <h5 class="mb-3">Categories</h5>
                                <ul class="nav nav-pills flex-column">
                                    @foreach($categories ?? [] as $cat)
                                        <li class="nav-item">
                                            @php
                                                // Check if this category or any of its children is active
                                                $isActive = $cat->slug == $category->slug;

                                                // If current category is a child, check if this is its parent
                                                if (!$isActive && $category->parent_id) {
                                                    $isActive = $cat->id == $category->parent_id;
                                                }
                                            @endphp
                            <a class="nav-link {{ $isActive ? 'active' : '' }}"
                               href="{{ route('categories.show', $cat->slug) }}">
                                <span class="category-name">{{ $cat->name }}</span>
                                <span class="badge {{ $isActive ? 'bg-white bg-opacity-25 text-white' : 'bg-light text-dark' }} ms-2">{{ $cat->total_products_count ?? $cat->products_count ?? 0 }}</span>
                            </a>                                            <!-- Show child categories always if they exist -->
                                            @if($cat->children && $cat->children->isNotEmpty())
                                                <ul class="nav nav-pills flex-column ms-3 mt-2">
                                                    @foreach($cat->children as $child)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ $child->slug == $category->slug ? 'active' : '' }} text-sm"
                                                               href="{{ route('categories.show', $child->slug) }}">
                                                                <i class="bi bi-arrow-right-short me-1"></i>
                                                                <span class="category-name">{{ $child->name }}</span>
                                                                <span class="badge {{ $child->slug == $category->slug ? 'bg-white bg-opacity-25 text-white' : 'bg-light text-dark' }} ms-2">{{ $child->products_count ?? 0 }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main content -->
                <section class="col-lg-9 col-md-12">
                    <!-- Category header card -->
                    <div class="card mb-4 bg-light border-0">
                        <div class="card-body p-9">
                            <h2 class="mb-0">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="mb-0 text-muted">{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Toolbar -->
                    <div class="d-lg-flex justify-content-between align-items-center">
                        <div class="mb-3 mb-lg-0">
                            <p class="mb-0">
                                <span class="text-dark">{{ $products->total() }}</span>
                                Products found
                            </p>
                        </div>

                        <!-- Filter and sort options -->
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <!-- Filter button for mobile -->
                                <button class="btn btn-outline-gray-400 text-muted d-md-none me-2"
                                        type="button"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasCategory">
                                    <i class="feather-icon icon-filter me-1"></i>
                                    Filter
                                </button>

                                <!-- Sort dropdown -->
                                <div class="me-2">
                                    <select class="form-select" onchange="applySorting(this.value)">
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Sort by: Name A-Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Sort by: Name Z-A</option>
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sort by: Latest</option>
                                    </select>
                                </div>

                                <!-- View toggle -->
                                <div class="btn-group" role="group" aria-label="View toggle">
                                    <input type="radio" class="btn-check" name="viewmode" id="gridview" checked>
                                    <label class="btn btn-outline-secondary" for="gridview" data-bs-toggle="tooltip" title="Grid View">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                    </label>
                                    <input type="radio" class="btn-check" name="viewmode" id="listview">
                                    <label class="btn btn-outline-secondary" for="listview" data-bs-toggle="tooltip" title="List View">
                                        <i class="bi bi-list"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($products->count() > 0)
                        <!-- Products grid -->
                        <div class="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2 row-cols-md-2 mt-2" id="productsGrid">
                            @include('frontend.categories.partials.product-grid', ['products' => $products])
                        </div>

                        <!-- Load More Button -->
                        @if($products->hasMorePages())
                            <div class="row mt-8">
                                <div class="col text-center">
                                    <button type="button" id="loadMoreBtn" class="btn btn-outline-primary btn-lg px-5"
                                            data-page="{{ $products->currentPage() + 1 }}"
                                            data-category="{{ $category->slug }}">
                                        <span class="load-text">Load More Products</span>
                                        <span class="loading-text d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </span>
                                    </button>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            Showing <span id="currentCount">{{ $products->count() }}</span>
                                            of <span id="totalCount">{{ $products->total() }}</span> products
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Enhanced Empty state -->
                        <div class="row mt-8">
                            <div class="col-12">
                                <div class="empty-state-card text-center p-5">
                                    <div class="empty-state-icon mb-4">
                                        <i class="bi bi-box-seam" style="font-size: 4rem; color: #6c757d;"></i>
                                    </div>
                                    <h3 class="text-dark mb-3">No Products Available</h3>
                                    <p class="text-muted mb-4 fs-6">
                                        We couldn't find any products in the <strong>{{ $category->name }}</strong> category at the moment.
                                        <br>
                                        Check back later or explore other categories for amazing products.
                                    </p>

                                    <!-- Category info -->
                                    <div class="row justify-content-center mb-4">
                                        <div class="col-md-8">
                                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <div>
                                                    <strong>{{ $category->name }}</strong> -
                                                    @if($category->description)
                                                        {{ $category->description }}
                                                    @else
                                                        Products will be added soon to this category.
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action buttons -->
                                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center align-items-center">
                                        <a href="{{ route('categories.index') }}" class="btn btn-primary px-4">
                                            <i class="bi bi-grid-3x3-gap me-2"></i>
                                            Browse All Categories
                                        </a>
                                        <a href="{{ route('homepage') }}" class="btn btn-outline-secondary px-4">
                                            <i class="bi bi-house me-2"></i>
                                            Back to Home
                                        </a>
                                        @if($category->parent_id)
                                            @php
                                                $parentCategory = \App\Models\Category::find($category->parent_id);
                                            @endphp
                                            <a href="{{ route('categories.show', $parentCategory->slug) }}" class="btn btn-outline-primary px-4">
                                                <i class="bi bi-arrow-up me-2"></i>
                                                View {{ $parentCategory->name }}
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Related categories -->
                                    @if($categories->count() > 1)
                                        <div class="mt-5">
                                            <h6 class="text-muted mb-3">Try these categories:</h6>
                                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                @foreach($categories->take(4) as $relatedCat)
                                                    @if($relatedCat->slug !== $category->slug && $relatedCat->total_products_count > 0)
                                                        <a href="{{ route('categories.show', $relatedCat->slug) }}"
                                                           class="btn btn-outline-secondary btn-sm">
                                                            {{ $relatedCat->name }}
                                                            <span class="badge bg-secondary ms-1">{{ $relatedCat->total_products_count }}</span>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .card-product {
        border: 0;
        transition: all 0.15s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .card-product:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .card-product .card-product-action {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.25s ease-in-out;
        z-index: 2;
    }

    .card-product:hover .card-product-action {
        opacity: 1;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #dee2e6;
        border-radius: 50%;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }

    .btn-action:hover {
        background: rgba(13, 110, 253, 0.9);
        color: #fff;
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .btn-action.text-danger {
        color: #dc3545 !important;
    }

    .btn-action.text-primary {
        color: #0d6efd !important;
    }

    .icon-xs {
        width: 1rem;
        height: 1rem;
    }

    /* View toggle improvements */
    .btn-group label {
        padding: 0.5rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-group label i {
        font-size: 1.1rem;
    }

    .btn-check:checked + .btn-outline-secondary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .offcanvas-collapse {
        border: none;
        box-shadow: none;
    }

    @media (min-width: 992px) {
        .offcanvas-collapse {
            position: static;
            z-index: auto;
            flex-grow: 1;
            width: auto !important;
            height: auto !important;
            visibility: visible !important;
            background-color: transparent !important;
            border: 0 !important;
        }
        .offcanvas-collapse .offcanvas-body {
            padding: 0;
        }
    }

    .nav-pills .nav-link {
        border-radius: 0.375rem;
        color: #6c757d;
        background: none;
        border: none;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-height: 2.5rem;
    }

    .nav-pills .nav-link .category-name {
        flex-grow: 1;
        margin-right: 0.75rem;
    }

    .nav-pills .nav-link .badge {
        flex-shrink: 0;
        min-width: 2rem;
        text-align: center;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }

    .nav-pills .nav-link.active .badge {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    .nav-pills .nav-link.active:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    /* Child category styles */
    .nav-pills .nav-pills .nav-link {
        font-size: 0.875rem;
        padding: 0.375rem 0.5rem;
        color: #6c757d;
        border-left: 2px solid transparent;
        margin-left: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-height: 2.25rem;
    }

    .nav-pills .nav-pills .nav-link .category-name {
        flex-grow: 1;
        margin-right: 0.5rem;
    }

    .nav-pills .nav-pills .nav-link .badge {
        flex-shrink: 0;
        min-width: 1.75rem;
        text-align: center;
        font-size: 0.75rem;
    }

    .nav-pills .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
        border-left-color: #0d6efd;
    }

    /* Badge styles for active nav-links - More specific selectors */
    .nav-pills .nav-link.active .badge.bg-white {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }

    .nav-pills .nav-pills .nav-link.active {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-left-color: #0d6efd !important;
    }

    .nav-pills .nav-pills .nav-link.active .badge.bg-white {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }

    /* Additional specific selectors to override Bootstrap */
    .nav-pills .nav-link.active span.badge,
    .nav-pills .nav-link.active .badge,
    a.nav-link.active .badge {
        background-color: rgba(255, 255, 255, 0.3) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        font-weight: 600 !important;
    }

    .nav-pills .nav-pills .nav-link.active span.badge,
    .nav-pills .nav-pills .nav-link.active .badge,
    .nav-pills .nav-pills a.nav-link.active .badge {
        background-color: rgba(255, 255, 255, 0.3) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        font-weight: 600 !important;
    }

    /* Force override any Bootstrap badge classes */
    .nav-link.active .badge.bg-light,
    .nav-link.active .badge.text-dark,
    .nav-link.active .badge.bg-white {
        background-color: rgba(255, 255, 255, 0.3) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
    }

    .nav-pills .nav-pills .nav-link.active:hover {
        background-color: rgba(13, 110, 253, 0.15);
        color: #0d6efd;
    }

    /* Icons for child categories */
    .bi-arrow-right-short {
        font-size: 1rem;
        opacity: 0.7;
        margin-right: 0.25rem !important;
    }

    /* Better spacing for nested lists */
    .nav-pills .nav-pills {
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem;
        border-left: 1px solid #e9ecef;
        margin-left: 1rem !important;
        padding-left: 0.5rem;
    }

    /* Improved badge styling */
    .badge.bg-light.text-dark {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
        font-weight: 500;
    }

    .nav-link.active .badge.bg-light.text-dark {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.3);
    }

    /* List view styles */
    .list-view .row-cols-1 .card-product {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        height: auto;
    }

    .list-view .row-cols-1 .card-product .card-body {
        display: flex;
        flex-direction: row;
        align-items: center;
        width: 100%;
        padding: 1.5rem;
    }

    .list-view .row-cols-1 .card-product .product-image {
        width: 180px !important;
        height: 150px !important;
        margin-right: 1.5rem;
        margin-bottom: 0 !important;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .list-view .row-cols-1 .card-product .position-relative {
        flex-shrink: 0;
    }

    .list-view .row-cols-1 .card-product .product-details {
        flex-grow: 1;
        padding-left: 1rem;
    }

    .list-view .row-cols-1 .card-product .card-product-action {
        position: relative;
        top: auto;
        right: auto;
        flex-direction: row;
        gap: 10px;
        opacity: 1;
        margin-left: auto;
        flex-shrink: 0;
        align-self: flex-start;
    }

    .list-view .row-cols-1 .card-product .product-details h2 {
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .list-view .row-cols-1 .card-product .product-details .text-warning {
        margin-bottom: 1rem;
    }

    /* Grid view default styles */
    .grid-view .card-product-action {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.25s ease-in-out;
        z-index: 2;
    }

    .grid-view .card-product:hover .card-product-action {
        opacity: 1;
    }

    /* Ensure action buttons stay within card bounds */
    .grid-view .card-product {
        position: relative;
        overflow: hidden;
    }

    .grid-view .card-product .position-relative {
        position: relative;
        overflow: hidden;
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .list-view .row-cols-1 .card-product {
            flex-direction: column;
            text-align: center;
        }

        .list-view .row-cols-1 .card-product .card-body {
            flex-direction: column;
            padding: 1rem;
        }

        .list-view .row-cols-1 .card-product .product-image {
            width: 100% !important;
            height: 200px !important;
            margin-right: 0;
            margin-bottom: 1rem !important;
        }

        .list-view .row-cols-1 .card-product .product-details {
            padding-left: 0;
        }

        .list-view .row-cols-1 .card-product .card-product-action {
            margin-left: 0;
            margin-top: 1rem;
            justify-content: center;
        }
    }

    /* Load More Button Styling */
    #loadMoreBtn {
        transition: all 0.3s ease;
        border-width: 2px;
        min-width: 200px;
    }

    #loadMoreBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }

    #loadMoreBtn:disabled {
        transform: none;
        box-shadow: none;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }

    /* Empty State Styles */
    .empty-state-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        margin: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .empty-state-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #6610f2, #6f42c1, #d63384, #dc3545, #fd7e14, #ffc107, #198754, #20c997, #0dcaf0);
        animation: gradientMove 3s ease-in-out infinite;
    }

    @keyframes gradientMove {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

    .empty-state-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .empty-state-card .alert {
        background-color: rgba(13, 202, 240, 0.1);
        border: 1px solid rgba(13, 202, 240, 0.2);
        border-radius: 8px;
    }

    .empty-state-card .btn {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .empty-state-card .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .empty-state-card .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff;
    }

    .empty-state-card .btn-outline-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    /* Related categories badges */
    .empty-state-card .btn-sm {
        transition: all 0.2s ease;
    }

    .empty-state-card .btn-sm:hover {
        transform: scale(1.05);
    }

    /* Responsive adjustments for empty state */
    @media (max-width: 768px) {
        .empty-state-card {
            margin: 1rem 0;
            padding: 2rem 1rem !important;
        }

        .empty-state-icon i {
            font-size: 3rem !important;
        }

        .empty-state-card h3 {
            font-size: 1.5rem;
        }

        .empty-state-card .d-flex {
            flex-direction: column !important;
        }

        .empty-state-card .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function applySorting(sortValue) {
        const url = new URL(window.location);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    }

    // Initialize tooltips and functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // View toggle functionality
        const gridViewRadio = document.getElementById('gridview');
        const listViewRadio = document.getElementById('listview');
        const productsGrid = document.getElementById('productsGrid');

        if (gridViewRadio && listViewRadio && productsGrid) {
            gridViewRadio.addEventListener('change', function() {
                if (this.checked) {
                    productsGrid.className = 'row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2 row-cols-md-2 mt-2';
                    // Show grid view styling
                    document.body.classList.remove('list-view');
                    document.body.classList.add('grid-view');
                }
            });

            listViewRadio.addEventListener('change', function() {
                if (this.checked) {
                    productsGrid.className = 'row g-4 row-cols-1 mt-2';
                    // Show list view styling
                    document.body.classList.remove('grid-view');
                    document.body.classList.add('list-view');
                }
            });
        }

        // Load More functionality
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const page = this.getAttribute('data-page');
                const category = this.getAttribute('data-category');
                const loadText = this.querySelector('.load-text');
                const loadingText = this.querySelector('.loading-text');

                // Show loading state
                loadText.classList.add('d-none');
                loadingText.classList.remove('d-none');
                this.disabled = true;

                // Prepare URL with current filters
                const url = new URL(window.location);
                url.searchParams.set('page', page);

                // Make AJAX request
                fetch(url.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append new products
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;

                        while (tempDiv.firstChild) {
                            productsGrid.appendChild(tempDiv.firstChild);
                        }

                        // Update current count
                        const currentCount = document.getElementById('currentCount');
                        if (currentCount) {
                            const newCount = productsGrid.children.length;
                            currentCount.textContent = newCount;
                        }

                        // Update button state
                        if (data.has_more) {
                            this.setAttribute('data-page', data.next_page);
                            loadText.classList.remove('d-none');
                            loadingText.classList.add('d-none');
                            this.disabled = false;
                        } else {
                            // Hide load more button if no more pages
                            this.parentElement.style.display = 'none';
                        }

                        // Initialize tooltips for new elements
                        var newTooltipTriggerList = [].slice.call(tempDiv.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        newTooltipTriggerList.forEach(function(tooltipTriggerEl) {
                            new bootstrap.Tooltip(tooltipTriggerEl);
                        });

                        // Smooth scroll to new content
                        setTimeout(() => {
                            const newItems = productsGrid.querySelectorAll('.col');
                            if (newItems.length > 0) {
                                const lastLoadedItem = newItems[newItems.length - Math.min(12, newItems.length)];
                                lastLoadedItem.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }, 100);

                    } else {
                        console.error('Failed to load more products');
                        // Reset button state
                        loadText.classList.remove('d-none');
                        loadingText.classList.add('d-none');
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button state
                    loadText.classList.remove('d-none');
                    loadingText.classList.add('d-none');
                    this.disabled = false;
                });
            });
        }
    });
</script>
@endpush
