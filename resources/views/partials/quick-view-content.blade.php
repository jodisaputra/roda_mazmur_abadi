<!-- Product Image Gallery -->
<div class="col-lg-6">
    <div class="product-gallery">
        <!-- Main Image Display -->
        <div class="main-image-wrapper mb-3">
            @if($product->images->isNotEmpty())
                <img id="mainProductImage"
                     src="{{ asset('storage/' . $product->images->first()->image) }}"
                     alt="{{ $product->name }}"
                     class="main-product-image" />
            @else
                <img id="mainProductImage"
                     src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="main-product-image" />
            @endif

            <!-- Image overlay with zoom icon -->
            <div class="image-overlay">
                <i class="bi bi-zoom-in text-white" style="font-size: 2rem;"></i>
            </div>
        </div>

        <!-- Product Thumbnails -->
        @if($product->images->count() > 1)
        <div class="thumbnails-wrapper">
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                @foreach($product->images->take(4) as $index => $image)
                <div class="thumbnail-item">
                    <img src="{{ asset('storage/' . $image->image) }}"
                         alt="{{ $product->name }}"
                         class="thumbnail-image {{ $index === 0 ? 'active' : '' }}"
                         data-image-src="{{ asset('storage/' . $image->image) }}"
                         data-image-index="{{ $index }}" />
                </div>
                @endforeach
                @if($product->images->count() > 4)
                <div class="thumbnail-item more-images">
                    <div class="more-count">+{{ $product->images->count() - 4 }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Product Details -->
<div class="col-lg-6">
    <div class="product-details">
        <!-- Category Badge -->
        <div class="mb-3">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                <i class="bi bi-tag me-1"></i>
                {{ $product->category->name ?? 'Uncategorized' }}
            </span>
        </div>

        <!-- Product Title -->
        <h2 class="product-title mb-3">{{ $product->name }}</h2>

        <!-- Rating -->
        <div class="d-flex align-items-center mb-3">
            <div class="rating me-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= 4 ? '-fill' : '' }} text-warning"></i>
                @endfor
            </div>
            <span class="text-muted">({{ rand(10,99) }} reviews)</span>
        </div>

        <!-- Price -->
        <div class="price-section mb-4">
            <div class="current-price">{{ $product->formatted_price }}</div>
            @if(rand(1,3) == 1)
            <div class="original-price">Rp {{ number_format($product->price * 1.3, 0, ',', '.') }}</div>
            <div class="discount-badge">{{ rand(10,30) }}% OFF</div>
            @endif
        </div>

        <!-- Stock Status -->
        <div class="stock-status mb-4">
            @if($product->in_stock && $product->stock_quantity > 0)
                <div class="d-flex align-items-center text-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span class="fw-semibold">Tersedia ({{ $product->stock_quantity }} item)</span>
                </div>
            @else
                <div class="d-flex align-items-center text-danger">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <span class="fw-semibold">Stok Habis</span>
                </div>
            @endif
        </div>

        <!-- Product Description -->
        @if($product->description)
        <div class="description-section mb-4">
            <h6 class="fw-bold mb-2">Deskripsi Produk</h6>
            <p class="text-muted">{{ Str::limit($product->description, 200) }}</p>
        </div>
        @endif

        <!-- Product Specifications -->
        <div class="specifications mb-4">
            <h6 class="fw-bold mb-3">Spesifikasi</h6>
            <div class="spec-grid">
                <div class="spec-item">
                    <span class="spec-label">Kode Produk:</span>
                    <span class="spec-value">{{ $product->sku ?? $product->product_code ?? 'N/A' }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Kategori:</span>
                    <span class="spec-value">{{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>
                @if($product->weight)
                <div class="spec-item">
                    <span class="spec-label">Berat:</span>
                    <span class="spec-value">{{ $product->weight }}</span>
                </div>
                @endif
                @if($product->dimensions)
                <div class="spec-item">
                    <span class="spec-label">Dimensi:</span>
                    <span class="spec-value">{{ $product->dimensions }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-success w-100" type="button">
                <i class="bi bi-whatsapp me-1"></i>
                Hubungi Penjual
            </button>
        </div>

        <!-- Trust Badges -->
        <div class="trust-badges mt-4">
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="trust-item">
                        <i class="bi bi-shield-check text-success"></i>
                        <small class="text-muted d-block">100% Original</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="trust-item">
                        <i class="bi bi-truck text-success"></i>
                        <small class="text-muted d-block">Gratis Ongkir</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="trust-item">
                        <i class="bi bi-arrow-clockwise text-success"></i>
                        <small class="text-muted d-block">Easy Return</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced quick view script with better functionality
(function() {
    console.log('Modern quick view script executing');

    // Setup thumbnail functionality
    setTimeout(function() {
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        const mainImage = document.getElementById('mainProductImage');

        thumbnails.forEach(function(thumbnail, index) {
            thumbnail.addEventListener('click', function(e) {
                e.preventDefault();

                const imageSrc = this.getAttribute('data-image-src');
                if (mainImage && imageSrc) {
                    // Add loading effect
                    mainImage.style.opacity = '0.5';

                    setTimeout(() => {
                        mainImage.src = imageSrc;
                        mainImage.style.opacity = '1';
                    }, 200);

                    // Update active state
                    thumbnails.forEach(thumb => thumb.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

    }, 300);
})();
</script>

<style>
/* Global Modal Text Visibility */
#quickViewModal .modal-content {
    background: #ffffff !important;
    color: #000000 !important;
}

/* Override untuk elemen umum, tapi tidak untuk button */
#quickViewModal .modal-content *:not(.btn):not(.btn *) {
    color: inherit !important;
}

#quickViewModal h1, #quickViewModal h2, #quickViewModal h3,
#quickViewModal h4, #quickViewModal h5, #quickViewModal h6 {
    color: #000000 !important;
    font-weight: 700 !important;
}

#quickViewModal p, #quickViewModal span:not(.btn span), #quickViewModal div:not(.btn):not(.btn div) {
    color: #333333 !important;
}

/* Warna khusus tetap berlaku */
#quickViewModal .text-success:not(.btn):not(.btn .text-success) {
    color: #28a745 !important;
}

#quickViewModal .text-warning {
    color: #ffc107 !important;
}

#quickViewModal .text-danger {
    color: #dc3545 !important;
}

#quickViewModal .text-muted:not(.btn):not(.btn .text-muted) {
    color: #555555 !important;
}

/* Pastikan button tetap menggunakan warna aslinya */
#quickViewModal .btn {
    color: inherit;
}

#quickViewModal .btn-success {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: #ffffff !important;
}

#quickViewModal .btn-success * {
    color: #ffffff !important;
}
    color: #28a745 !important;
}

#quickViewModal .text-warning {
    color: #ffc107 !important;
}

#quickViewModal .text-danger {
    color: #dc3545 !important;
}

#quickViewModal .text-muted {
    color: #555555 !important;
}

/* Modern Product Gallery Styles */
.product-gallery {
    padding: 1rem;
}

.main-image-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    background: #f8f9fa;
}

.main-product-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: all 0.3s ease;
    cursor: zoom-in;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.main-image-wrapper:hover .image-overlay {
    opacity: 1;
}

.thumbnails-wrapper {
    margin-top: 1rem;
}

.thumbnail-item {
    position: relative;
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
}

.thumbnail-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    border-radius: 8px;
}

.thumbnail-image:hover {
    border-color: #28a745;
    transform: scale(1.05);
}

.thumbnail-image.active {
    border-color: #28a745;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
}

.more-images {
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
}

.more-count {
    font-weight: bold;
    color: #6c757d;
}

/* Product Details Styles */
.product-details {
    padding: 1rem;
    background: #ffffff;
}

/* Category Badge */
.badge.bg-success.bg-opacity-10 {
    background-color: rgba(40, 167, 69, 0.1) !important;
    color: #28a745 !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
}

/* Rating text */
.text-muted {
    color: #333333 !important;
    font-weight: 500 !important;
}

.product-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #000000 !important;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.rating i {
    font-size: 1.1rem;
}

.price-section {
    position: relative;
    margin-bottom: 1rem;
}

.current-price {
    font-size: 2rem;
    font-weight: 700;
    color: #28a745 !important;
}

.original-price {
    font-size: 1.1rem;
    color: #6c757d !important;
    text-decoration: line-through;
    margin-top: 0.25rem;
}

.discount-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: #dc3545;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
}

.stock-status {
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #28a745;
}

.stock-status .text-success,
.stock-status .text-danger {
    font-weight: 600 !important;
    font-size: 1rem !important;
}

.description-section {
    padding: 1rem 0;
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
}

.description-section h6 {
    color: #000000 !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
}

.description-section p {
    color: #333333 !important;
    font-size: 0.95rem !important;
    line-height: 1.5;
}

.specifications {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

.specifications h6 {
    color: #000000 !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
}

.spec-grid {
    display: grid;
    gap: 0.75rem;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #dee2e6;
}

.spec-item:last-child {
    border-bottom: none;
}

.spec-label {
    font-weight: 600;
    color: #000000 !important;
    font-size: 0.95rem;
}

.spec-value {
    color: #333333 !important;
    font-size: 0.95rem;
    font-weight: 500;
}

.action-buttons {
    margin-top: 1.5rem;
}

.action-buttons .btn {
    padding: 0.75rem 1rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Khusus untuk button Hubungi Penjual */
.action-buttons .btn-success {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: #ffffff !important;
}

.action-buttons .btn-success:hover {
    background-color: #218838 !important;
    border-color: #218838 !important;
    color: #ffffff !important;
}

.action-buttons .btn-success i {
    color: #ffffff !important;
}

.trust-badges {
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.trust-item {
    padding: 0.5rem;
}

.trust-item i {
    font-size: 1.25rem;
    margin-bottom: 0.25rem;
}

.trust-item small {
    color: #000000 !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-product-image {
        height: 300px;
    }

    .product-title {
        font-size: 1.5rem;
    }

    .current-price {
        font-size: 1.5rem;
    }

    .thumbnail-item {
        width: 60px;
        height: 60px;
    }
}

/* Animation Classes */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.product-details > * {
    animation: fadeIn 0.6s ease forwards;
}

.product-details > *:nth-child(1) { animation-delay: 0.1s; }
.product-details > *:nth-child(2) { animation-delay: 0.2s; }
.product-details > *:nth-child(3) { animation-delay: 0.3s; }
.product-details > *:nth-child(4) { animation-delay: 0.4s; }
</style>
