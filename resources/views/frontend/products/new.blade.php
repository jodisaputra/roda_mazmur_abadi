@extends('layouts.frontend')

@section('title', 'Produk Terbaru - FreshCart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="mb-5 text-center">
                <h1 class="fw-bold">Produk Terbaru</h1>
                <p class="text-muted">Temukan produk-produk segar terbaru kami</p>
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
                            <!-- New badge -->
                            <span class="badge bg-success position-absolute top-0 start-0 m-2">Baru!</span>

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

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-dark fw-bold">{{ $product->formatted_price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="py-5">
                    <i class="bi bi-box-seam text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="mb-3">Belum Ada Produk Baru</h3>
                    <p class="text-muted">Produk baru akan segera tersedia. Tetap pantau halaman ini!</p>
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
// Reuse the same scripts from homepage for quick view functionality
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
        contentContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <p class="text-danger">Error loading product details. Please try again.</p>
            </div>
        `;
    });
}
</script>
@endpush
