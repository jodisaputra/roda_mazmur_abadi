@extends('layouts.frontend')

@section('title', 'Homepage - FreshCart')

@push('styles')
<style>
    /* Horizontal scroll for mobile - Simple and safe approach */
    @media (max-width: 767.98px) {
        /* Main scrollable container */
        .products-scroll {
            display: flex;
            gap: 0.75rem;
            padding: 0 1rem 10px 1rem;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .products-scroll::-webkit-scrollbar {
            display: none;
        }

        .product-item-mobile {
            flex: 0 0 160px;
            width: 160px;
        }

        .card-product .card-body {
            padding: 0.75rem 0.5rem;
        }

        .card-product h6 {
            font-size: 0.85rem;
            line-height: 1.2;
        }

        .section-header {
            padding-left: 1rem;
        }
    }

    /* Desktop and larger screens */
    @media (min-width: 768px) {
        .products-scroll {
            display: block;
        }
    }

    /* Product card basic styling */
    .card-product {
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        height: 100%;
    }

    /* Badge improvements */
    .badge.bg-danger {
        font-size: 0.7rem;
        border-radius: 15px;
        padding: 0.25rem 0.5rem;
    }

    /* Rating stars sizing */
    .bi-star, .bi-star-fill {
        color: #ffc107;
    }
</style>
@endpush

@section('content')
    <!-- Hero Slider Section - Bootstrap Carousel -->
    <section class="hero-section">
        <div class="container">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner rounded-3">
                    <div class="carousel-item active">
                        <a href="#">
                            <img src="{{ asset('assets/images/slider/slide-1.jpg') }}" class="d-block w-100" alt="Slider 1">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a href="#">
                            <img src="{{ asset('assets/images/slider/slider-2.jpg') }}" class="d-block w-100" alt="Slider 2">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a href="#">
                            <img src="{{ asset('assets/images/slider/slide-1.jpg') }}" class="d-block w-100" alt="Slider 3">
                        </a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Products Start-->
    @forelse($shelves as $shelf)
        @if($shelf->activeProducts->isNotEmpty())
        <section class="py-4 {{ $loop->even ? 'bg-light' : '' }}">
            <div class="container">
                <!-- Section Header -->
                <div class="row align-items-center mb-4 section-header">
                    <div class="col">
                        <h3 class="mb-0 fw-bold">{{ $shelf->name }}</h3>
                        <p class="text-muted mb-0 d-none d-md-block">Pilihan terbaik untuk kebutuhan Anda</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('shelf.show', $shelf->slug) }}" class="btn btn-outline-success btn-sm">
                            <span class="d-none d-sm-inline">Lihat Semua</span>
                            <span class="d-inline d-sm-none">Semua</span>
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Products Container - Horizontal scroll on mobile, grid on desktop -->
                <div class="products-container">
                    <!-- Mobile: Horizontal Scroll -->
                    <div class="products-scroll d-md-none">
                        @foreach($shelf->activeProducts->take(6) as $product)
                        <div class="product-item-mobile">
                            <div class="card card-product shadow-sm border-0">
                                <div class="card-body">
                                    <div class="text-center position-relative mb-3">
                                        <!-- Discount badge -->
                                        @if(rand(1,3) == 1)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-1 small">-{{ rand(10,30) }}%</span>
                                        @endif

                                        <!-- Product Image -->
                                        <a href="#" onclick="showQuickView({{ $product->id }}); return false;" class="d-block">
                                            <img src="{{ $product->primary_image_url }}"
                                                 alt="{{ $product->name }}"
                                                 class="img-fluid rounded"
                                                 style="height: 120px; width: 100%; object-fit: cover;" />
                                        </a>
                                    </div>

                                    <!-- Product Category -->
                                    <div class="text-small mb-1">
                                        @if($product->category && $product->category->slug)
                                        <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none text-success">
                                            <small>{{ $product->category->name }}</small>
                                        </a>
                                        @else
                                        <small class="text-success">Uncategorized</small>
                                        @endif
                                    </div>

                                    <!-- Product Title -->
                                    <h6 class="card-title mb-2">
                                        <a href="#" onclick="showQuickView({{ $product->id }}); return false;" class="text-inherit text-decoration-none">
                                            {{ Str::limit($product->name, 30) }}
                                        </a>
                                    </h6>

                                    <!-- Mobile Rating -->
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 4; $i++)
                                            <i class="bi bi-star-fill text-warning" style="font-size: 0.7rem;"></i>
                                        @endfor
                                        <i class="bi bi-star text-warning" style="font-size: 0.7rem;"></i>
                                        <small class="text-muted ms-1">({{ rand(10,99) }})</small>
                                    </div>

                                    <!-- Price -->
                                    <div>
                                        <span class="text-dark fw-bold small">{{ $product->formatted_price }}</span>
                                        @if(rand(1,3) == 1)
                                        <br><small class="text-decoration-line-through text-muted" style="font-size: 0.7rem;">Rp {{ number_format($product->price * 1.3, 0, ',', '.') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Desktop: Grid Layout -->
                    <div class="row g-3 g-md-4 d-none d-md-flex">
                        @foreach($shelf->activeProducts->take(6) as $product)
                        <div class="col-6 col-lg-2 col-md-3">
                            <div class="card card-product h-100 shadow-sm border-0">
                                <div class="card-body p-2 p-md-3">
                                    <div class="text-center position-relative mb-3">
                                        <!-- Discount badge -->
                                        @if(rand(1,3) == 1)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-1 m-md-2 small">-{{ rand(10,30) }}%</span>
                                        @endif

                                        <!-- Product Image -->
                                        <a href="#" onclick="showQuickView({{ $product->id }}); return false;" class="d-block">
                                            <img src="{{ $product->primary_image_url }}"
                                                 alt="{{ $product->name }}"
                                                 class="img-fluid rounded"
                                                 style="height: 120px; width: 100%; object-fit: cover;" />
                                        </a>

                                        <!-- Quick View Action - Desktop only -->
                                        <div class="card-product-action">
                                            <a href="#" class="btn-action quick-view-btn"
                                                onclick="showQuickView({{ $product->id }}); return false;">
                                                <i class="bi bi-eye" data-bs-toggle="tooltip" title="Quick View"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Product Category -->
                                    <div class="text-small mb-1">
                                        @if($product->category && $product->category->slug)
                                        <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none text-success">
                                            <small>{{ $product->category->name }}</small>
                                        </a>
                                        @else
                                        <small class="text-success">Uncategorized</small>
                                        @endif
                                    </div>

                                    <!-- Product Title -->
                                    <h6 class="card-title mb-2 lh-sm">
                                        <a href="#" onclick="showQuickView({{ $product->id }}); return false;" class="text-inherit text-decoration-none">
                                            {{ Str::limit($product->name, 35) }}
                                        </a>
                                    </h6>

                                    <!-- Desktop Rating -->
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= 4 ? '-fill' : '' }} text-warning small"></i>
                                        @endfor
                                        <small class="text-muted ms-1">({{ rand(10,99) }})</small>
                                    </div>

                                    <!-- Price -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-dark fw-bold small">{{ $product->formatted_price }}</span>
                                            @if(rand(1,3) == 1)
                                            <br><small class="text-decoration-line-through text-muted" style="font-size: 0.75rem;">Rp {{ number_format($product->price * 1.3, 0, ',', '.') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif
    @empty
        @include('partials.empty-products', [
            'title' => 'Produk Belum Tersedia',
            'description' => 'Kami sedang mempersiapkan koleksi produk terbaik untuk Anda. Tetap pantau halaman ini untuk update produk terbaru!',
            'contactUrl' => '#',
            'subscribeUrl' => '#',
            'newsletterAction' => null // Set to route when newsletter functionality is ready
        ])
    @endforelse
    <!-- Products End-->

{{-- Include Quick View Modal --}}
@include('partials.quick-view-modal')

@push('scripts')
    <script>
        console.log('Homepage loaded successfully');

        // Check if Bootstrap is loaded
        console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'Loaded' : 'Not loaded');

        // Function to load quick view content - available globally
        function showQuickView(productId) {
            console.log('showQuickView called with productId:', productId);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            modal.show();

            // Reset content to loading state
            document.getElementById('quickViewContent').innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3" style="color: #333333 !important;">Memuat detail produk...</p>
                </div>
            `;

            // Load product details via AJAX
            const url = `/product/${productId}/quick-view`;
            console.log('Fetching from URL:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response received:', response);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.html) {
                    document.getElementById('quickViewContent').innerHTML = data.html;
                } else if (data.success === false) {
                    throw new Error(data.message || 'Product not available');
                } else {
                    throw new Error('No content received');
                }
            })
            .catch(error => {
                console.error('Error loading product details:', error);
                document.getElementById('quickViewContent').innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Gagal Memuat Detail</h5>
                        <p class="text-muted">Terjadi kesalahan saat memuat detail produk: ${error.message}</p>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                `;
            });
        }

        function loadQuickViewProduct(productId) {
            showQuickView(productId);
        }        // Global function to setup thumbnail listeners
        function setupThumbnailListeners() {
            console.log('Setting up thumbnail listeners from homepage script');

            setTimeout(() => {
                const thumbnails = document.querySelectorAll('.thumbnail-image');
                const mainImage = document.getElementById('mainProductImage');

                console.log('Found', thumbnails.length, 'thumbnails from homepage');
                console.log('Main image found:', mainImage ? 'Yes' : 'No');

                thumbnails.forEach(function(thumbnail, index) {
                    // Remove existing listeners
                    thumbnail.removeEventListener('click', handleThumbnailClick);

                    // Add new listener
                    thumbnail.addEventListener('click', handleThumbnailClick);
                    console.log('Added listener to thumbnail', index);
                });

                // Setup quantity controls - removed since quantity selector was removed
                console.log('Thumbnail listeners setup complete');

            }, 300);
        }        // Handle thumbnail click
        function handleThumbnailClick(event) {
            event.preventDefault();
            event.stopPropagation();

            console.log('Thumbnail clicked from homepage handler');

            const imageSrc = this.getAttribute('data-image-src');
            const index = parseInt(this.getAttribute('data-image-index'));

            console.log('Image source:', imageSrc);
            console.log('Index:', index);

            const mainImage = document.getElementById('mainProductImage');

            if (mainImage && imageSrc) {
                console.log('Changing main image');

                // Fade effect
                mainImage.style.opacity = '0.5';

                setTimeout(() => {
                    mainImage.src = imageSrc;
                    mainImage.style.opacity = '1';
                    console.log('Image changed successfully');
                }, 150);

                // Update active state
                const thumbnails = document.querySelectorAll('.thumbnail-image');
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                this.classList.add('active');

                console.log('Active state updated');
            } else {
                console.error('Main image not found or image source missing');
            }
        }

        // Debug: Check elements when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');

            // Check if modal exists
            const modal = document.getElementById('quickViewModal');
            console.log('Quick view modal found:', modal ? 'Yes' : 'No');

            // Check if content container exists
            const contentContainer = document.getElementById('quickViewContent');
            console.log('Quick view content container found:', contentContainer ? 'Yes' : 'No');

            // Check buttons
            const quickViewButtons = document.querySelectorAll('.quick-view-btn');
            console.log('Found', quickViewButtons.length, 'quick view buttons');

            quickViewButtons.forEach((button, index) => {
                const productId = button.getAttribute('data-product-id');
                console.log(`Button ${index + 1}: Product ID = ${productId}`);
            });
        });
    </script>
@endpush

@endsection
