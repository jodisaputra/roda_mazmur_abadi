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
