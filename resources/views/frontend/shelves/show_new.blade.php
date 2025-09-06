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

    <!-- Shelf Header -->
    <div class="mt-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body text-center py-5">
                            @if($shelf->image)
                                <img src="{{ Storage::url('shelves/' . $shelf->image) }}"
                                     class="mb-3"
                                     style="width: 80px; height: 80px; object-fit: cover;"
                                     alt="{{ $shelf->name }}">
                            @endif
                            <h2 class="h3 mb-2">{{ $shelf->name }}</h2>
                            @if($shelf->description)
                                <p class="text-muted mb-0">{{ $shelf->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main section -->
    <div class="mt-6 mb-lg-14 mb-8">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4">
                    <div class="py-4">
                        <!-- Filter -->
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

                        <!-- Categories Filter -->
                        @if($allCategories && $allCategories->count() > 0)
                            <div class="mb-4">
                                <h5 class="mb-3">Kategori</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <a href="{{ route('shelf.show', $shelf->slug) }}"
                                           class="text-decoration-none d-flex justify-content-between align-items-center {{ !request('category') ? 'fw-bold text-primary' : 'text-dark' }}">
                                            <span>Semua Kategori</span>
                                        </a>
                                    </li>
                                    @foreach($allCategories as $category)
                                        <li class="mb-2">
                                            <a href="{{ route('shelf.show', $shelf->slug) }}?category={{ $category->slug }}"
                                               class="text-decoration-none d-flex justify-content-between align-items-center {{ request('category') === $category->slug ? 'fw-bold text-primary' : 'text-dark' }}">
                                                <span>{{ $category->name }}</span>
                                                <small class="text-muted">
                                                    ({{ $category->products->whereIn('id', $shelf->products->pluck('id'))->count() }})
                                                </small>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Other Shelves -->
                        @if($otherShelves && $otherShelves->count() > 0)
                            <div class="mb-4">
                                <h5 class="mb-3">Shelf Lainnya</h5>
                                <ul class="list-unstyled">
                                    @foreach($otherShelves as $otherShelf)
                                        <li class="mb-2">
                                            <a href="{{ route('shelf.show', $otherShelf->slug) }}"
                                               class="text-decoration-none text-dark">
                                                {{ $otherShelf->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        <div class="col-12">
                            <!-- Results Info -->
                            <div class="d-lg-flex justify-content-between align-items-center mb-4">
                                <div>
                                    @php
                                        $totalProducts = $categories->sum(function($category) {
                                            return $category->products->count();
                                        });
                                    @endphp
                                    <p class="mb-0">
                                        Menampilkan <span class="text-dark fw-bold">{{ $totalProducts }}</span> produk
                                        @if(request('category'))
                                            dalam kategori "{{ $allCategories->where('slug', request('category'))->first()->name ?? '' }}"
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories and Products -->
                    @if($categories && $categories->count() > 0)
                        @foreach($categories as $category)
                            @if($category->products && $category->products->count() > 0)
                                <!-- Category Section -->
                                <div class="category-section mb-8">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div>
                                            <h4 class="mb-1">{{ $category->name }}</h4>
                                            @if($category->description)
                                                <p class="text-muted mb-0 small">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                        <span class="badge bg-light text-dark">{{ $category->products->count() }} produk</span>
                                    </div>

                                    <!-- Products Grid -->
                                    <div class="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2">
                                        @foreach($category->products->take(8) as $product)
                                            <div class="col">
                                                <div class="card card-product h-100">
                                                    <div class="card-body text-center">
                                                        <!-- Product Image -->
                                                        @if($product->primaryImage)
                                                            <a href="#" onclick="showQuickView({{ $product->id }})">
                                                                <img src="{{ Storage::url('products/' . $product->primaryImage->image) }}"
                                                                     alt="{{ $product->name }}"
                                                                     class="mb-3 img-fluid"
                                                                     style="height: 120px; width: 120px; object-fit: cover;">
                                                            </a>
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center mb-3"
                                                                 style="height: 120px; width: 120px; margin: 0 auto;">
                                                                <i class="bi bi-image text-muted fs-1"></i>
                                                            </div>
                                                        @endif

                                                        <!-- Product Name -->
                                                        <h6 class="mb-1">
                                                            <a href="#" onclick="showQuickView({{ $product->id }})" class="text-inherit text-decoration-none">
                                                                {{ Str::limit($product->name, 30) }}
                                                            </a>
                                                        </h6>

                                                        <!-- Category -->
                                                        <div class="text-small mb-2">
                                                            <span class="text-muted">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                                                        </div>

                                                        <!-- Price -->
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            @if($product->discount_price && $product->discount_price < $product->price)
                                                                <span class="text-dark fw-bold me-2">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                                                <span class="text-decoration-line-through text-muted small">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                            @else
                                                                <span class="text-dark fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                            @endif
                                                        </div>

                                                        <!-- Action Button -->
                                                        <div class="product-action mt-3">
                                                            <button type="button" class="btn btn-primary btn-sm w-100" onclick="showQuickView({{ $product->id }})">
                                                                <i class="feather-icon icon-shopping-bag me-2"></i>Lihat Detail
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($category->products->count() > 8)
                                        <div class="text-center mt-4">
                                            <button class="btn btn-outline-primary load-more-category"
                                                    data-category="{{ $category->slug }}"
                                                    data-shelf="{{ $shelf->slug }}"
                                                    data-loaded="8"
                                                    data-total="{{ $category->products->count() }}">
                                                Muat Lebih Banyak dari {{ $category->name }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @else
                        <!-- Empty State -->
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center py-8">
                                    <div class="mb-4">
                                        <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                    <h4>Tidak Ada Produk</h4>
                                    <p class="text-muted">
                                        @if(request('category'))
                                            Tidak ada produk dalam kategori yang dipilih untuk shelf ini.
                                            <br><a href="{{ route('shelf.show', $shelf->slug) }}" class="btn btn-link p-0">Lihat semua kategori</a>
                                        @else
                                            Shelf ini belum memiliki produk.
                                            <br><a href="{{ route('products.index') }}" class="btn btn-link p-0">Jelajahi shelf lainnya</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@include('partials.quick-view-modal')
@endsection

@push('scripts')
<script>
// Load More Category Products
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.load-more-category').forEach(button => {
        button.addEventListener('click', function() {
            const categorySlug = this.dataset.category;
            const shelfSlug = this.dataset.shelf;
            const loaded = parseInt(this.dataset.loaded);
            const total = parseInt(this.dataset.total);

            // Show loading state
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memuat...';
            this.disabled = true;

            // Make AJAX request
            fetch(`/shelf/${shelfSlug}/category/${categorySlug}/products?offset=${loaded}&limit=8`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    // Find the category section and append products
                    const categorySection = this.closest('.category-section');
                    const productsGrid = categorySection.querySelector('.row.g-4');
                    productsGrid.insertAdjacentHTML('beforeend', data.html);

                    // Update loaded count
                    const newLoaded = loaded + data.count;
                    this.dataset.loaded = newLoaded;

                    // Check if more products available
                    if (newLoaded >= total) {
                        this.style.display = 'none';
                    } else {
                        this.innerHTML = `Muat Lebih Banyak dari ${categorySlug}`;
                        this.disabled = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = 'Error - Coba Lagi';
                this.disabled = false;
            });
        });
    });
});

// Quick View Modal
function showQuickView(productId) {
    // Implementation for quick view modal
    $('#quickViewModal').modal('show');
    // Load product details via AJAX
}
</script>
@endpush
