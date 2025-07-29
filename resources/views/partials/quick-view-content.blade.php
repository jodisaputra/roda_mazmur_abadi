<div class="col-lg-6">
    <!-- Product Images -->
    <div class="product-image-container">
        <!-- Main Image Display -->
        <div class="main-image-container mb-3">
            @if($product->images->isNotEmpty())
                <img id="mainProductImage"
                     src="{{ asset('storage/' . $product->images->first()->image) }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded border"
                     style="width: 100%; height: 400px; object-fit: cover;" />
            @else
                <img id="mainProductImage"
                     src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded border"
                     style="width: 100%; height: 400px; object-fit: cover;" />
            @endif
        </div>

        <!-- Product Thumbnails -->
        @if($product->images->count() > 1)
        <div class="product-thumbnails">
            <div class="row g-2">
                @foreach($product->images as $index => $image)
                <div class="col-3">
                    <div class="thumbnail-container">
                        <img src="{{ asset('storage/' . $image->image) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid rounded border thumbnail-image {{ $index === 0 ? 'active' : '' }}"
                             style="width: 100%; height: 80px; object-fit: cover; cursor: pointer;"
                             data-image-src="{{ asset('storage/' . $image->image) }}"
                             data-image-index="{{ $index }}"
                             onclick="
                                console.log('Inline click handler called');
                                const mainImg = document.getElementById('mainProductImage');
                                const allThumbs = document.querySelectorAll('.thumbnail-image');
                                if (mainImg) {
                                    mainImg.style.opacity = '0.5';
                                    setTimeout(() => {
                                        mainImg.src = this.getAttribute('data-image-src');
                                        mainImg.style.opacity = '1';
                                    }, 150);
                                    allThumbs.forEach(t => t.classList.remove('active'));
                                    this.classList.add('active');
                                    console.log('Image changed via inline handler');
                                }
                             " />
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<div class="col-lg-6">
    <div class="ps-lg-8 mt-6 mt-lg-0">
        <a href="#" class="mb-4 d-block">{{ $product->category->name ?? 'Uncategorized' }}</a>
        <h2 class="mb-1 h1">{{ $product->name }}</h2>

        <div class="fs-4 mb-4">
            <span class="fw-bold text-dark">{{ $product->formatted_price }}</span>
        </div>

        <hr class="my-6" />

        <!-- Product Description -->
        @if($product->description)
        <div class="mb-4">
            <h5 class="mb-3">Description</h5>
            <div class="text-muted">
                {{ $product->description }}
            </div>
        </div>
        @endif

        <hr class="my-6" />

        <!-- Product Details -->
        <div>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>Product Code:</td>
                        <td>{{ $product->sku ?? $product->product_code ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Availability:</td>
                        <td>
                            @if($product->in_stock && $product->stock_quantity > 0)
                                <span class="text-success">In Stock ({{ $product->stock_quantity }} available)</span>
                            @else
                                <span class="text-danger">Out of Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    </tr>
                    @if($product->weight)
                    <tr>
                        <td>Weight:</td>
                        <td>{{ $product->weight }}</td>
                    </tr>
                    @endif
                    @if($product->dimensions)
                    <tr>
                        <td>Dimensions:</td>
                        <td>{{ $product->dimensions }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Immediate execution for dynamic content
(function() {
    console.log('Quick view script executing');

    // Wait a bit for DOM to be ready, then setup listeners
    setTimeout(function() {
        console.log('Setting up thumbnail listeners');

        const thumbnails = document.querySelectorAll('.thumbnail-image');
        const mainImage = document.getElementById('mainProductImage');

        console.log('Found', thumbnails.length, 'thumbnails');
        console.log('Main image found:', mainImage ? 'Yes' : 'No');

        thumbnails.forEach(function(thumbnail, index) {
            thumbnail.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Thumbnail', index, 'clicked');

                const imageSrc = this.getAttribute('data-image-src');
                console.log('Image source:', imageSrc);

                if (mainImage && imageSrc) {
                    // Fade effect
                    mainImage.style.opacity = '0.5';

                    setTimeout(() => {
                        mainImage.src = imageSrc;
                        mainImage.style.opacity = '1';
                        console.log('Image changed to:', imageSrc);
                    }, 150);

                    // Update active state
                    thumbnails.forEach(thumb => thumb.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

    }, 200); // Delay to ensure DOM is ready
})();
</script><style>
.thumbnail-image {
    transition: all 0.3s ease;
    cursor: pointer !important;
    border: 2px solid transparent !important;
}

.thumbnail-image:hover {
    opacity: 0.8;
    transform: scale(1.05);
    border: 2px solid #6c757d !important;
}

.thumbnail-image.active {
    border: 3px solid #007bff !important;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    transform: scale(1.02);
}

.main-image-container {
    position: relative;
    overflow: hidden;
}

#mainProductImage {
    transition: all 0.3s ease;
}

#mainProductImage:hover {
    transform: scale(1.02);
}

.thumbnail-container {
    position: relative;
}

.thumbnail-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.thumbnail-container:hover::after {
    opacity: 1;
}

.product-thumbnails {
    margin-top: 15px;
}
</style>
