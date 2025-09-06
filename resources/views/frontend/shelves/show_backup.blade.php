@extends('layouts.frontend')

@section('title', $shelf->name . ' - Products - FreshCart')

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
                                <a href="{{ route('homepage') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.index') }}">Shelf Produk</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $shelf->name }}</li>
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
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4">
                    <div class="py-4">
                        <!-- Search -->
                        <div class="mb-4">
                            <h5 class="mb-3">Filter Produk</h5>
                            <form method="GET" id="filterForm">
                                <!-- Sort -->
                                <div class="mb-3">
                                    <label class="form-label">Urutkan</label>
                                    <select class="form-select" name="sort" onchange="document.getElementById('filterForm').submit();">
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <!-- Other Shelves -->
                        <div class="py-4">
                            <h5 class="mb-3">Shelf Lainnya</h5>
                            <ul class="nav nav-pills flex-column">
                                @foreach($shelves as $shelfItem)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $shelfItem->id == $shelf->id ? 'active' : '' }}"
                                           href="{{ route('shelves.show', $shelfItem->slug) }}">
                                            <span class="shelf-name">{{ $shelfItem->name }}</span>
                                            <span class="badge {{ $shelfItem->id == $shelf->id ? 'bg-white bg-opacity-25 text-white' : 'bg-light text-dark' }} ms-2">{{ $shelfItem->products_count ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="col-lg-9 col-md-8">
                    <div class="card mb-4 bg-light border-0">
                        <div class="card-body p-9">
                            <h1 class="mb-2">{{ $shelf->name }}</h1>
                            <p class="mb-0 text-muted">
                                Menampilkan produk dari shelf {{ $shelf->name }}
                                @if($shelf->capacity)
                                    (Kapasitas: {{ $shelf->capacity }})
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($products->count() > 0)
                        <!-- Products header -->
                        <div class="d-lg-flex justify-content-between align-items-center">
                            <div class="mb-3 mb-lg-0">
                                <p class="mb-0">
                                    Menampilkan <span class="text-dark">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                                    dari <span class="text-dark">{{ $products->total() }}</span> hasil
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                @if($products->total() > 0)
                                    <div class="me-2">
                                        @if($products->total() == 1)
                                            <span class="badge bg-light text-dark">{{ $products->total() }} Product</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ $products->total() }} Products</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Products grid -->
                        <div class="row g-4 row-cols-lg-3 row-cols-2 mt-2" id="productsGrid">
                            @include('frontend.products.partials.product-grid', ['products' => $products])
                        </div>

                        <!-- Load More Button -->
                        @if($products->hasMorePages())
                            <div class="row mt-5">
                                <div class="col text-center">
                                    <button type="button" id="loadMoreBtn" class="btn btn-outline-primary btn-lg px-5"
                                            data-page="{{ $products->currentPage() + 1 }}"
                                            data-shelf="{{ $shelf->slug }}">
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
                        <!-- Empty state -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="mb-3">Tidak Ada Produk di Shelf Ini</h3>
                            <p class="text-muted mb-4">Produk untuk shelf {{ $shelf->name }} akan segera tersedia</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                Lihat Shelf Lainnya
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

{{-- Include Quick View Modal --}}
@include('partials.quick-view-modal')

@push('scripts')
<script>
// Quick view functionality
function loadQuickViewProduct(productId) {
    console.log('Loading quick view for product:', productId);

    const contentContainer = document.getElementById('quickViewContent');
    if (!contentContainer) {
        console.error('Quick view content container not found');
        return;
    }

    contentContainer.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading product details...</p>
        </div>
    `;

    fetch('/product/' + productId + '/quick-view', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            contentContainer.innerHTML = data.html;
        } else {
            contentContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <p class="text-danger">Error: ${data.message || 'Loading product details failed'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        contentContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <p class="text-danger">Error loading product details. Please try again.</p>
            </div>
        `;
    });
}

// Load More functionality
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const productsGrid = document.getElementById('productsGrid');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            const shelf = this.getAttribute('data-shelf');
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
                        this.parentElement.parentElement.style.display = 'none';
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

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
