@foreach($shelves as $shelf)
    @if($shelf->activeProducts->isNotEmpty())
    <section class="py-4 {{ $loop->even ? 'bg-light' : '' }}">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h3 class="mb-0 fw-bold">{{ $shelf->name }}</h3>
                    <p class="text-muted mb-0">{{ $shelf->activeProducts->count() }} dari {{ $shelf->totalProducts ?? $shelf->activeProducts->count() }} produk</p>
                </div>
            </div>

            <div class="row g-4 row-cols-lg-4 row-cols-md-3 row-cols-2">
                @foreach($shelf->activeProducts as $product)
                <div class="col">
                    <div class="card card-product h-100 shadow-sm border-0">
                        <div class="card-body p-3">
                            <div class="text-center position-relative mb-3">
                                <!-- Discount badge if any -->
                                @if($product->discount_percentage > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ $product->discount_percentage }}%</span>
                                @endif

                                <a href="{{ route('products.show', $product->slug) }}" class="d-block">
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
                                <a href="{{ route('categories.show', $product->category->slug ?? '#') }}" class="text-decoration-none text-success">
                                    <small>{{ $product->category->name ?? 'Uncategorized' }}</small>
                                </a>
                            </div>

                            <h6 class="card-title mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-inherit text-decoration-none">{{ $product->name }}</a>
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
                                    @if($product->discount_percentage > 0)
                                        <span class="text-muted text-decoration-line-through me-2">{{ $product->formatted_original_price }}</span>
                                    @endif
                                    <span class="text-dark fw-bold">{{ $product->formatted_price }}</span>
                                </div>

                                @if($product->stock_status === 'in_stock')
                                    <small class="text-success">
                                        <i class="bi bi-check-circle"></i> Tersedia
                                    </small>
                                @elseif($product->stock_status === 'low_stock')
                                    <small class="text-warning">
                                        <i class="bi bi-exclamation-circle"></i> Stok Terbatas
                                    </small>
                                @else
                                    <small class="text-danger">
                                        <i class="bi bi-x-circle"></i> Stok Habis
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach
