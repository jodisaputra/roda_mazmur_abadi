@foreach($products as $product)
    <div class="col">
        <div class="card card-product h-100 shadow-sm border-0">
            <div class="card-body">
                <!-- Product image -->
                <div class="text-center position-relative">
                    <a href="{{ route('products.show', $product) }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ Storage::url($product->images->first()->image) }}"
                                 alt="{{ $product->name }}"
                                 class="mb-3 img-fluid product-image"
                                 style="height: 200px; width: 100%; object-fit: cover;"
                                 onerror="this.src='{{ asset('template/assets/images/default-product.svg') }}'">
                        @else
                            <img src="{{ asset('template/assets/images/default-product.svg') }}"
                                 alt="Default Product"
                                 class="mb-3 img-fluid product-image"
                                 style="height: 200px; width: 100%; object-fit: cover;">
                        @endif
                    </a>
                    <!-- Action buttons -->
                    <div class="card-product-action">
                        <a href="{{ route('products.show', $product) }}" class="btn-action"
                            data-bs-toggle="tooltip" data-bs-html="true" title="Quick View">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </div>
                <!-- Product details -->
                <div class="product-details">
                    <div class="text-small mb-1">
                        <a href="{{ route('categories.show', $product->category->slug) }}"
                           class="text-decoration-none text-muted">
                            <small>{{ $product->category->name }}</small>
                        </a>
                    </div>
                    <h2 class="fs-6">
                        <a href="{{ route('products.show', $product) }}"
                           class="text-inherit text-decoration-none">
                            {{ Str::limit($product->name, 50) }}
                        </a>
                    </h2>
                    <!-- Price -->
                    <div class="mt-3">
                        <span class="text-dark fw-bold fs-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
