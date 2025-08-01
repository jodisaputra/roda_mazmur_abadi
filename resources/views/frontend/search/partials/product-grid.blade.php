@foreach($products as $product)
    <div class="col">
        <div class="card card-product h-100">
            <div class="card-body">
                <!-- Product Image -->
                <div class="text-center position-relative">
                    <a href="{{ route('products.show', $product->slug) }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ Storage::url($product->images->first()->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid product-img"
                                 style="height: 200px; object-fit: cover; width: 100%;">
                        @else
                            <div class="no-image-placeholder d-flex flex-column align-items-center justify-content-center"
                                 style="height: 200px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px;">
                                <i class="bi bi-image" style="font-size: 2.5rem; color: #6c757d;"></i>
                                <small class="text-muted mt-2">No Image</small>
                            </div>
                        @endif
                    </a>
                </div>

                <!-- Product Info -->
                <div class="mt-3">
                    <div class="text-small mb-1">
                        <a href="{{ route('categories.show', $product->category->slug) }}"
                           class="text-decoration-none text-muted">
                            <small>{{ $product->category->name }}</small>
                        </a>
                    </div>

                    <h5 class="fs-6 mb-2">
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="text-inherit text-decoration-none">
                            {{ Str::limit($product->name, 50) }}
                        </a>
                    </h5>

                    <!-- Price and Stock -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-dark fw-bold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <div>
                            @if($product->stock_quantity > 0)
                                <span class="badge bg-success text-white">
                                    In Stock
                                </span>
                            @else
                                <span class="badge bg-danger text-white">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
