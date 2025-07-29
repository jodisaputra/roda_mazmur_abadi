@extends('layouts.frontend')

@section('title', 'Promo Spesial - FreshCart')

@section('content')
<div class="container py-5">
    <!-- Promo Banner -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-gradient text-white border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-center py-5">
                    <h1 class="fw-bold mb-3">🎉 Promo Spesial Hari Ini! 🎉</h1>
                    <p class="lead mb-4">Dapatkan penawaran terbaik untuk produk-produk pilihan</p>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h3 class="fw-bold">GRATIS ONGKIR</h3>
                            <p class="mb-0">Min. pembelian Rp 100.000</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="fw-bold">CASHBACK 15%</h3>
                            <p class="mb-0">Untuk member baru</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="fw-bold">DISKON 30%</h3>
                            <p class="mb-0">Produk pilihan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Sale Products -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold text-danger mb-1">⚡ Flash Sale</h2>
                    <p class="text-muted mb-0">Berakhir dalam waktu terbatas!</p>
                </div>
                <div class="text-danger fw-bold">
                    <i class="bi bi-clock"></i>
                    <span id="countdown">23:59:59</span>
                </div>
            </div>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row g-4 row-cols-lg-4 row-cols-md-3 row-cols-2">
            @foreach($products as $product)
            <div class="col">
                <div class="card card-product h-100 shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="text-center position-relative mb-3">
                            <!-- Discount badge -->
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ rand(20,50) }}%</span>
                            <!-- Limited badge -->
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">Terbatas!</span>

                            <a href="#" class="d-block">
                                <img src="{{ $product->primary_image_url }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid rounded"
                                     style="height: 200px; width: 100%; object-fit: cover;" />
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
                            <a href="#" class="text-decoration-none text-success">
                                <small>{{ $product->category->name ?? 'Uncategorized' }}</small>
                            </a>
                        </div>

                        <h6 class="card-title mb-2">
                            <a href="#" class="text-inherit text-decoration-none">{{ $product->name }}</a>
                        </h6>

                        <!-- Rating -->
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= 4 ? '-fill' : '' }} text-warning small"></i>
                            @endfor
                            <small class="text-muted ms-1">({{ rand(10,99) }})</small>
                        </div>

                        <!-- Progress bar for stock -->
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Tersisa</small>
                                <small class="text-danger fw-bold">{{ rand(5,15) }} item</small>
                            </div>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-danger" style="width: {{ rand(20,80) }}%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-dark fw-bold">{{ $product->formatted_price }}</span>
                                <br><small class="text-decoration-line-through text-muted">Rp {{ number_format($product->price * 1.5, 0, ',', '.') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Promo Code Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center py-4">
                        <h4 class="fw-bold mb-3">Kode Promo Eksklusif</h4>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border border-success rounded p-3">
                                    <h6 class="text-success fw-bold">FRESH100</h6>
                                    <small class="text-muted">Gratis ongkir min. Rp 100.000</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border border-warning rounded p-3">
                                    <h6 class="text-warning fw-bold">NEWBIE15</h6>
                                    <small class="text-muted">Cashback 15% untuk member baru</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border border-danger rounded p-3">
                                    <h6 class="text-danger fw-bold">FLASH30</h6>
                                    <small class="text-muted">Diskon 30% produk tertentu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="py-5">
                    <i class="bi bi-gift text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="mb-3">Belum Ada Promo</h3>
                    <p class="text-muted">Promo menarik akan segera tersedia. Tetap pantau halaman ini!</p>
                    <a href="{{ route('homepage') }}" class="btn btn-success">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

{{-- Include Quick View Modal --}}
@include('partials.quick-view-modal')

@push('scripts')
<script>
// Countdown timer
function startCountdown() {
    const countdownElement = document.getElementById('countdown');
    if (!countdownElement) return;

    let hours = 23;
    let minutes = 59;
    let seconds = 59;

    setInterval(() => {
        seconds--;
        if (seconds < 0) {
            seconds = 59;
            minutes--;
            if (minutes < 0) {
                minutes = 59;
                hours--;
                if (hours < 0) {
                    hours = 23;
                }
            }
        }

        countdownElement.textContent =
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
    }, 1000);
}

// Start countdown when page loads
document.addEventListener('DOMContentLoaded', startCountdown);

// Quick view functionality
function loadQuickViewProduct(productId) {
    const contentContainer = document.getElementById('quickViewContent');
    if (!contentContainer) return;

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
        contentContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <p class="text-danger">Error loading product details. Please try again.</p>
            </div>
        `;
    });
}
</script>
@endpush
