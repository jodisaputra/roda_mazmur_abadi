@extends('layouts.frontend')

@section('title', 'Homepage - FreshCart')

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
                <div class="row align-items-center mb-4">
                    <div class="col">
                        <h3 class="mb-0 fw-bold">{{ $shelf->name }}</h3>
                        <p class="text-muted mb-0">Pilihan terbaik untuk kebutuhan Anda</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                    @foreach($shelf->activeProducts->take(10) as $product)
                    <div class="col">
                        <div class="card card-product h-100 shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="text-center position-relative mb-3">
                                    <!-- Discount badge -->
                                    @if(rand(1,3) == 1)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ rand(10,30) }}%</span>
                                    @endif

                                    <a href="{{ route('products.show', $product->slug) }}" class="d-block">
                                        <img src="{{ $product->primary_image_url }}"
                                             alt="{{ $product->name }}"
                                             class="img-fluid rounded"
                                             style="height: 150px; width: 100%; object-fit: cover;" />
                                    </a>

                                    <div class="card-product-action">
                                        <a href="#" class="btn-action quick-view-btn"
                                            data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                            data-product-id="{{ $product->id }}" onclick="loadQuickViewProduct({{ $product->id }}); return false;">
                                            <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true"
                                                title="Quick View"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="text-small mb-1">
                                    @if($product->category && $product->category->slug)
                                    <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none text-success">
                                        <small>{{ $product->category->name }}</small>
                                    </a>
                                    @else
                                    <small class="text-success">Uncategorized</small>
                                    @endif
                                </div>

                                <h6 class="card-title mb-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-inherit text-decoration-none">{{ Str::limit($product->name, 40) }}</a>
                                </h6>

                                <!-- Rating -->
                                <div class="mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= 4 ? '-fill' : '' }} text-warning small"></i>
                                    @endfor
                                    <small class="text-muted ms-1">({{ rand(10,99) }})</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-dark fw-bold">{{ $product->formatted_price }}</span>
                                        @if(rand(1,3) == 1)
                                        <br><small class="text-decoration-line-through text-muted">Rp {{ number_format($product->price * 1.3, 0, ',', '.') }}</small>
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
@endsection

{{-- Include Quick View Modal --}}
@include('partials.quick-view-modal')

@push('scripts')
    <script>
        console.log('Homepage loaded successfully');

        // Check if Bootstrap is loaded
        console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'Loaded' : 'Not loaded');

        // Function to load quick view content - available globally
        function loadQuickViewProduct(productId) {
            console.log('Loading quick view for product:', productId);

            const contentContainer = document.getElementById('quickViewContent');
            if (!contentContainer) {
                console.error('Quick view content container not found');
                return;
            }

            // Show loading spinner
            contentContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Loading product details...</p>
                </div>
            `;

            // Fetch product data
            fetch('/product/' + productId + '/quick-view', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    contentContainer.innerHTML = data.html;
                    console.log('Quick view content loaded successfully');

                    // Setup thumbnail listeners after content loads
                    setupThumbnailListeners();
                } else {
                    contentContainer.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <p class="text-danger">Error: ${data.message || 'Loading product details failed'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                contentContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <p class="text-danger">Error loading product details. Please try again.</p>
                        <p class="text-muted small">${error.message}</p>
                    </div>
                `;
            });
        }

        // Global function to setup thumbnail listeners
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
