@extends('layouts.frontend')

@section('title', 'Search Results - ' . $query)

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
                            <li class="breadcrumb-item active" aria-current="page">
                                Search Results
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <section class="mt-8 mb-lg-14 mb-8">
        <div class="container">
            <!-- Search Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h2 class="mb-1">Search Results</h2>
                            <p class="text-muted mb-0">
                                Found <strong>{{ $products->total() }}</strong> products for
                                <strong>"{{ $query }}"</strong>
                                @if($selectedCategory)
                                    in <strong>{{ $selectedCategory->name }}</strong>
                                @endif
                            </p>
                        </div>

                        <!-- Search Form -->
                        <div class="search-form-container">
                            <form action="{{ route('search') }}" method="GET" class="d-flex">
                                <!-- Hidden fields to maintain current filters -->
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif

                                <div class="input-group" style="min-width: 300px;">
                                    <input type="text" name="q" class="form-control"
                                           placeholder="Search products..."
                                           value="{{ $query }}" required>
                                    <button class="btn btn-success" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Filters Sidebar -->
                <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Filters</h5>
                        </div>
                        <div class="card-body">
                            <!-- Category Filter -->
                            <div class="mb-4">
                                <h6 class="mb-3">Categories</h6>
                                <form action="{{ route('search') }}" method="GET">
                                    <input type="hidden" name="q" value="{{ $query }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="category"
                                               value="" id="all-categories"
                                               {{ !request('category') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="all-categories">
                                            All Categories
                                        </label>
                                    </div>

                                    @foreach($categories as $category)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="category"
                                                   value="{{ $category->slug }}" id="cat-{{ $category->slug }}"
                                                   {{ request('category') == $category->slug ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cat-{{ $category->slug }}">
                                                {{ $category->name }}
                                                <small class="text-muted">({{ $category->products_count ?? 0 }})</small>
                                            </label>
                                        </div>
                                    @endforeach

                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2">
                                        Apply Filter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Results Area -->
                <section class="col-lg-9 col-md-8">
                    <!-- Toolbar -->
                    <div class="d-lg-flex justify-content-between align-items-center mb-4">
                        <div class="mb-3 mb-lg-0">
                            <p class="mb-0">
                                Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                                of {{ $products->total() }} results
                            </p>
                        </div>

                        <!-- Sort Options -->
                        <div class="d-flex align-items-center">
                            <form action="{{ route('search') }}" method="GET" class="d-flex align-items-center">
                                <input type="hidden" name="q" value="{{ $query }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">

                                <label for="sort" class="form-label me-2 mb-0">Sort by:</label>
                                <select name="sort" id="sort" class="form-select form-select-sm"
                                        onchange="this.form.submit()" style="width: auto;">
                                    <option value="relevance" {{ $sort == 'relevance' ? 'selected' : '' }}>Relevance</option>
                                    <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                    <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                    <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Price Low to High</option>
                                    <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Price High to Low</option>
                                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    @if($products->count() > 0)
                        <!-- Products Grid -->
                        <div class="row g-4 row-cols-xl-3 row-cols-lg-2 row-cols-1" id="productsGrid">
                            @include('frontend.search.partials.product-grid', ['products' => $products])
                        </div>

                        <!-- Load More Button -->
                        @if($products->hasMorePages())
                            <div class="row mt-8">
                                <div class="col text-center">
                                    <button type="button" id="loadMoreBtn" class="btn btn-outline-primary btn-lg px-5"
                                            data-page="{{ $products->currentPage() + 1 }}">
                                        <span class="load-text">Load More Products</span>
                                        <span class="loading-text d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- No Results -->
                        <div class="text-center py-8">
                            <div class="mb-4">
                                <i class="bi bi-search" style="font-size: 4rem; color: #6c757d;"></i>
                            </div>
                            <h4 class="mb-3">No products found</h4>
                            <p class="text-muted mb-4">
                                We couldn't find any products matching "<strong>{{ $query }}</strong>"
                                @if($selectedCategory)
                                    in category "<strong>{{ $selectedCategory->name }}</strong>"
                                @endif
                            </p>

                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                <a href="{{ route('search', ['q' => $query]) }}" class="btn btn-outline-primary">
                                    Search in all categories
                                </a>
                                <a href="{{ route('homepage') }}" class="btn btn-primary">
                                    Back to Homepage
                                </a>
                            </div>

                            <!-- Category Suggestions -->
                            @if($selectedCategory && $categories->where('products_count', '>', 0)->count() > 0)
                            <div class="mt-4">
                                <h6 class="text-muted mb-3">Try searching in these categories:</h6>
                                <div class="row g-2 justify-content-center">
                                    @foreach($categories->where('products_count', '>', 0)->take(6) as $suggestedCategory)
                                        <div class="col-auto">
                                            <a href="{{ route('search', ['q' => $query, 'category' => $suggestedCategory->slug]) }}"
                                               class="btn btn-sm btn-outline-success">
                                                {{ $suggestedCategory->name }} ({{ $suggestedCategory->products_count }})
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Search Suggestions -->
                            <div class="mt-5">
                                <h6 class="text-muted mb-3">Try these suggestions:</h6>
                                <ul class="list-unstyled">
                                    <li class="text-muted">• Check your spelling</li>
                                    <li class="text-muted">• Use different keywords</li>
                                    <li class="text-muted">• Try more general terms</li>
                                    <li class="text-muted">• Browse our categories with products above</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    .card-product {
        border: 1px solid #e3e6f0;
        transition: all 0.15s ease-in-out;
        border-radius: 8px;
    }

    .card-product:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-color: #d1d3e2;
        transform: translateY(-2px);
    }

    .product-img {
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .card-product:hover .product-img {
        transform: scale(1.05);
    }

    .no-image-placeholder {
        transition: all 0.3s ease;
    }

    .card-product:hover .no-image-placeholder {
        background-color: #e9ecef !important;
        border-color: #adb5bd !important;
    }

    .search-form-container .input-group {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .form-check-input:checked {
        background-color: #0aad0a;
        border-color: #0aad0a;
    }

    /* Load More Button Styling */
    #loadMoreBtn {
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #loadMoreBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    #loadMoreBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .search-form-container .input-group {
            min-width: 250px !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load More functionality
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const productsGrid = document.getElementById('productsGrid');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            const loadText = this.querySelector('.load-text');
            const loadingText = this.querySelector('.loading-text');

            // Show loading state
            loadText.classList.add('d-none');
            loadingText.classList.remove('d-none');
            this.disabled = true;

            // Prepare URL with current page parameters
            const url = new URL(window.location.href);
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

                    // Update button state
                    if (data.has_more) {
                        this.setAttribute('data-page', data.next_page);
                        loadText.classList.remove('d-none');
                        loadingText.classList.add('d-none');
                        this.disabled = false;
                    } else {
                        // Hide load more button if no more pages
                        this.parentElement.parentElement.style.display = 'none';
                    }

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
                console.error('Error loading more products:', error);
                // Reset button state
                loadText.classList.remove('d-none');
                loadingText.classList.add('d-none');
                this.disabled = false;
            });
        });
    }

    // Auto-submit form when category filter changes
    const categoryRadios = document.querySelectorAll('input[name="category"]');

    categoryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            console.log('Category radio changed:', this.value, 'checked:', this.checked);

            if (this.checked) {
                // Get the closest form element
                const categoryForm = this.closest('form');
                console.log('Form found:', categoryForm);
                console.log('Form action:', categoryForm.action);

                // Check form data before submission
                const formData = new FormData(categoryForm);
                console.log('Form data before submit:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ':', value);
                }

                // Small delay to ensure UI updates
                setTimeout(() => {
                    console.log('Submitting form...');
                    categoryForm.submit();
                }, 100);
            }
        });
    });

    // Auto-submit form when sort dropdown changes
    const sortSelect = document.querySelector('select[name="sort"]');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
});
</script>
@endpush
