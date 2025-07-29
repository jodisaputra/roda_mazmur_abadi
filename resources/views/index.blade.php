@extends('layouts.frontend')

@section('title', 'Homepage - FreshCart')

@section('content')
    <section class="mt-8">
        <div class="container">
            <div class="hero-slider">
                <div
                    style="background: url('{{ asset('assets/images/slider/slide-1.jpg') }}') no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                    <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <h2 class="text-dark display-5 fw-bold mt-4">SuperMarket For Fresh Grocery</h2>
                        <p class="lead">Introduced a new model for online grocery shopping and convenient home delivery.
                        </p>
                        <a href="#!" class="btn btn-dark mt-3">
                            Shop Now
                            <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div
                    style="background: url('{{ asset('assets/images/slider/slider-2.jpg') }}') no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                    <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <span class="badge text-bg-warning">Free Shipping - orders over $100</span>
                        <h2 class="text-dark display-5 fw-bold mt-4">
                            Free Shipping on
                            <br />
                            orders over
                            <span class="text-primary">$100</span>
                        </h2>
                        <p class="lead">Free Shipping to First-Time Customers Only, After promotions and discounts are
                            applied.</p>
                        <a href="#!" class="btn btn-dark mt-3">
                            Shop Now
                            <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Start-->
    @forelse($shelves as $shelf)
        @if($shelf->activeProducts->isNotEmpty())
        <section class="my-lg-14 my-8">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-6">
                        <h3 class="mb-0">{{ $shelf->name }}</h3>
                    </div>
                </div>

                <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                    @foreach($shelf->activeProducts->take(10) as $product)
                    <div class="col">
                        <div class="card card-product">
                            <div class="card-body">
                                <div class="text-center position-relative">
                                    <a href="#"><img src="{{ $product->primary_image_url }}"
                                            alt="{{ $product->name }}" class="mb-3 img-fluid" /></a>

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
                                    <a href="#" class="text-decoration-none text-muted">
                                        <small>{{ $product->category->name ?? 'Uncategorized' }}</small>
                                    </a>
                                </div>
                                <h2 class="fs-6">
                                    <a href="#" class="text-inherit text-decoration-none">{{ $product->name }}</a>
                                </h2>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span class="text-dark">{{ $product->formatted_price }}</span>
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
        <section class="my-lg-14 my-8">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="mb-4">Belum Ada Produk</h3>
                        <p class="text-muted">Produk akan segera tersedia.</p>
                    </div>
                </div>
            </div>
        </section>
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
