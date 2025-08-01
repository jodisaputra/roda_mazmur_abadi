@extends('layouts.frontend')

@section('title', 'All Categories - FreshCart')

@section('content')
<main>
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
                            <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main section -->
    <div class="mt-8 mb-lg-14 mb-8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Page header -->
                    <div class="card mb-4 bg-light border-0">
                        <div class="card-body p-9">
                            <h1 class="mb-0">Browse All Categories</h1>
                            <p class="mb-0 text-muted">Discover all available product categories</p>
                        </div>
                    </div>

                    @if($categories->isNotEmpty())
                        <!-- Categories grid -->
                        <div class="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2 row-cols-md-2">
                            @foreach($categories as $category)
                                <div class="col">
                                    <div class="card card-product h-100">
                                        <div class="card-body text-center">
                                            <!-- Category image or icon -->
                                            <div class="mb-3">
                                                @if($category->image)
                                                    <img src="{{ Storage::url($category->image) }}"
                                                         alt="{{ $category->name }}"
                                                         class="img-fluid rounded-circle mb-3"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                                         style="width: 80px; height: 80px;">
                                                        <i data-feather="grid" class="text-primary" style="width: 32px; height: 32px;"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Category details -->
                                            <h5 class="mb-1">
                                                <a href="{{ route('categories.show', $category->slug) }}"
                                                   class="text-inherit text-decoration-none">
                                                    {{ $category->name }}
                                                </a>
                                            </h5>

                                            @if($category->description)
                                                <p class="text-muted small mb-3">{{ Str::limit($category->description, 60) }}</p>
                                            @endif

                                            <!-- Product count -->
                                            <div class="mb-3">
                                                <span class="badge bg-light text-dark">
                                                    {{ $category->total_products_count ?? $category->products_count ?? 0 }} Products
                                                </span>
                                            </div>

                                            <!-- Child categories if exist -->
                                            @if($category->children->isNotEmpty())
                                                <div class="mb-3">
                                                    <small class="text-muted">Subcategories:</small>
                                                    <div class="mt-1">
                                                        @foreach($category->children->take(3) as $child)
                                                            <a href="{{ route('categories.show', $child->slug) }}"
                                                               class="badge bg-outline-secondary text-decoration-none me-1 mb-1">
                                                                {{ $child->name }}
                                                            </a>
                                                        @endforeach
                                                        @if($category->children->count() > 3)
                                                            <span class="badge bg-light text-muted">
                                                                +{{ $category->children->count() - 3 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Browse button -->
                                            <a href="{{ route('categories.show', $category->slug) }}"
                                               class="btn btn-primary btn-sm">
                                                <i data-feather="arrow-right" class="me-1" style="width: 16px; height: 16px;"></i>
                                                Browse Category
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Category statistics -->
                        <div class="row mt-8">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center py-5">
                                        <h4 class="mb-3">Category Overview</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3 mb-md-0">
                                                    <h2 class="text-primary mb-0">{{ $categories->count() }}</h2>
                                                    <small class="text-muted">Total Categories</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3 mb-md-0">
                                                    <h2 class="text-success mb-0">{{ $categories->sum('total_products_count') ?: $categories->sum('products_count') }}</h2>
                                                    <small class="text-muted">Total Products</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div>
                                                    <h2 class="text-warning mb-0">{{ $categories->where('children', '!=', '[]')->count() }}</h2>
                                                    <small class="text-muted">Categories with Subcategories</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty state -->
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center py-8">
                                    <div class="mb-4">
                                        <i data-feather="inbox" class="text-muted" style="width: 100px; height: 100px;"></i>
                                    </div>
                                    <h4>No categories available</h4>
                                    <p class="text-muted">Categories will appear here once they are added by the administrator.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .card-product {
        border: 1px solid #e3e6f0;
        transition: all 0.15s ease-in-out;
    }

    .card-product:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-color: #d1d3e2;
        transform: translateY(-2px);
    }

    .bg-outline-secondary {
        background-color: transparent;
        border: 1px solid #6c757d;
        color: #6c757d;
    }

    .bg-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>
@endpush
