@extends('layouts.backend')

@section('title', 'Manage Shelf Products')

@section('content')
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-md-flex justify-content-between align-items-center">
                    <!-- page header -->
                    <div>
                        <h2>Manage Products</h2>
                        <!-- breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.shelves.index') }}" class="text-inherit">Shelves</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.shelves.show', $shelf) }}" class="text-inherit">{{ $shelf->name }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Products</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.shelves.show', $shelf) }}" class="btn btn-light">Back to Shelf</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-lg">
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <h4 class="h5 mb-2">Shelf: {{ $shelf->name }}</h4>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($shelf->capacity)
                                    <span class="badge bg-info">
                                        Capacity: {{ $shelfProducts->count() }}/{{ $shelf->capacity }} products
                                        @if($shelfProducts->count() >= $shelf->capacity)
                                            <i class="bi bi-exclamation-triangle ms-1"></i> FULL
                                        @endif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Unlimited capacity</span>
                                @endif

                                <span class="badge bg-primary">
                                    Available Products: {{ $products->count() }}
                                </span>

                                @if($shelf->capacity && $shelfProducts->count() >= $shelf->capacity)
                                    <span class="badge bg-warning">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Shelf is full. Remove products to add new ones.
                                    </span>
                                @endif
                            </div>

                            @if($products->count() == 0 && $shelfProducts->count() < ($shelf->capacity ?? PHP_INT_MAX))
                                <div class="alert alert-info mt-2">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No available products. All active products are either out of stock or already assigned to other shelves.
                                </div>
                            @endif
                        </div>                        <form action="{{ route('admin.shelves.update-products', $shelf) }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <input type="text" id="searchProducts" class="form-control"
                                           placeholder="Search products...">
                                </div>
                                <div class="col-md-6">
                                    <select id="categoryFilter" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach($products->pluck('category')->unique('id')->filter() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Available Products</h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <div id="availableProducts" class="border rounded p-3" style="height: 500px; overflow-y: auto;">
                                                @foreach($products as $product)
                                                    @if(!$shelfProducts->contains('id', $product->id))
                                                    <div class="product-item mb-2 p-2 border rounded"
                                                         data-product-id="{{ $product->id }}"
                                                         data-category-id="{{ $product->category_id }}"
                                                         data-product-name="{{ strtolower($product->name) }}">
                                                        <div class="d-flex align-items-center">
                                                            @if($product->primaryImage)
                                                                <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                                                                     alt="{{ $product->name }}"
                                                                     class="img-thumbnail me-2"
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light d-flex align-items-center justify-content-center me-2"
                                                                     style="width: 50px; height: 50px;">
                                                                    <i class="bi bi-image text-muted"></i>
                                                                </div>
                                                            @endif

                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                                <small class="text-muted">{{ $product->category->name ?? 'No Category' }}</small>
                                                                <br>
                                                                <small class="text-primary">{{ $product->formatted_price }}</small>
                                                            </div>

                                                            <button type="button"
                                                                    class="btn btn-sm btn-success add-product"
                                                                    data-product-id="{{ $product->id }}">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">
                                                Selected Products
                                                @if($shelf->capacity)
                                                    (<span id="selectedCount">{{ $shelfProducts->count() }}</span>/{{ $shelf->capacity }})
                                                @else
                                                    (<span id="selectedCount">{{ $shelfProducts->count() }}</span>)
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="card-body p-2">
                                            <div id="selectedProducts" class="border rounded p-3" style="height: 500px; overflow-y: auto;">
                                                @foreach($shelfProducts as $index => $product)
                                                <div class="selected-product-item mb-2 p-2 border rounded"
                                                     data-product-id="{{ $product->id }}">
                                                    <input type="hidden" name="products[]" value="{{ $product->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="drag-handle me-2" style="cursor: move;">
                                                            <i class="bi bi-grip-vertical text-muted"></i>
                                                        </div>

                                                        @if($product->primaryImage)
                                                            <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                                                                 alt="{{ $product->name }}"
                                                                 class="img-thumbnail me-2"
                                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center me-2"
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="bi bi-image text-muted"></i>
                                                            </div>
                                                        @endif

                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">{{ $product->name }}</h6>
                                                            <small class="text-muted">{{ $product->category->name ?? 'No Category' }}</small>
                                                            <br>
                                                            <small class="text-primary">{{ $product->formatted_price }}</small>
                                                        </div>

                                                        <button type="button"
                                                                class="btn btn-sm btn-danger remove-product"
                                                                data-product-id="{{ $product->id }}">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.shelves.show', $shelf) }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Products</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(count($unavailableProducts ?? []) > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-lg">
                        <div class="card-body p-6">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 h5 text-muted">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Unavailable Products ({{ count($unavailableProducts) }})
                                </h4>
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#unavailableProductsCollapse">
                                    <i class="bi bi-eye"></i> Show/Hide
                                </button>
                            </div>

                            <div class="collapse" id="unavailableProductsCollapse">
                                <div class="row">
                                    @foreach($unavailableProducts as $item)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                        <div class="card h-100 border-secondary opacity-75">
                                            <div class="card-body p-3 text-center">
                                                @if($item['product']->primaryImage)
                                                    <img src="{{ asset('storage/' . $item['product']->primaryImage->image) }}"
                                                         alt="{{ $item['product']->name }}"
                                                         class="img-fluid rounded mb-2"
                                                         style="height: 60px; width: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded mb-2 mx-auto"
                                                         style="height: 60px; width: 60px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif

                                                <h6 class="card-title text-truncate mb-1" title="{{ $item['product']->name }}">
                                                    {{ $item['product']->name }}
                                                </h6>

                                                <p class="text-muted small mb-1">
                                                    {{ $item['product']->category->name ?? 'No Category' }}
                                                </p>

                                                <p class="text-primary fw-bold mb-2">
                                                    {{ $item['product']->formatted_price }}
                                                </p>

                                                <span class="badge
                                                    @if($item['type'] === 'in_other_shelf') bg-warning
                                                    @elseif($item['type'] === 'out_of_stock') bg-danger
                                                    @else bg-secondary
                                                    @endif
                                                ">
                                                    {{ $item['reason'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const maxCapacity = {{ $shelf->capacity ?? 'null' }};

    // Make selected products sortable
    new Sortable(document.getElementById('selectedProducts'), {
        animation: 150,
        handle: '.drag-handle',
        onEnd: function () {
            updateProductInputs();
        }
    });

    // Search functionality
    $('#searchProducts').on('keyup', function() {
        filterProducts();
    });

    // Category filter
    $('#categoryFilter').on('change', function() {
        filterProducts();
    });

    // Add product to shelf
    $(document).on('click', '.add-product', function() {
        const productId = $(this).data('product-id');
        const productElement = $(this).closest('.product-item');
        const productName = productElement.find('h6').text().trim();

        // Check capacity
        const currentCount = $('#selectedProducts .selected-product-item').length;
        if (maxCapacity && currentCount >= maxCapacity) {
            Swal.fire({
                icon: 'warning',
                title: 'Shelf Full!',
                text: `This shelf can only hold ${maxCapacity} products. Please remove some products first.`,
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Show loading state
        $(this).prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

        // Move to selected with animation
        setTimeout(() => {
            const selectedHtml = productElement.clone();
            selectedHtml.removeClass('product-item').addClass('selected-product-item');
            selectedHtml.find('.add-product').removeClass('btn-success add-product').addClass('btn-danger remove-product').html('<i class="bi bi-x"></i>');
            selectedHtml.prepend('<div class="drag-handle me-2" style="cursor: move;"><i class="bi bi-grip-vertical text-muted"></i></div>');
            selectedHtml.find('.d-flex').prepend('<input type="hidden" name="products[]" value="' + productId + '">');

            $('#selectedProducts').append(selectedHtml);
            productElement.fadeOut(300, function() {
                $(this).remove();
            });

            updateSelectedCount();

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: `${productName} has been added to the shelf.`,
                timer: 1500,
                showConfirmButton: false
            });
        }, 300);
    });

    // Remove product from shelf
    $(document).on('click', '.remove-product', function() {
        const productId = $(this).data('product-id');
        const productElement = $(this).closest('.selected-product-item');
        const productName = productElement.find('h6').text().trim();

        // Move back to available with animation
        const availableHtml = productElement.clone();
        availableHtml.removeClass('selected-product-item').addClass('product-item');
        availableHtml.find('.remove-product').removeClass('btn-danger remove-product').addClass('btn-success add-product').html('<i class="bi bi-plus"></i>');
        availableHtml.find('.drag-handle').remove();
        availableHtml.find('input[type="hidden"]').remove();

        $('#availableProducts').prepend(availableHtml);

        productElement.fadeOut(300, function() {
            $(this).remove();
            updateSelectedCount();
        });

        // Show success message
        Swal.fire({
            icon: 'info',
            title: 'Removed!',
            text: `${productName} has been removed from the shelf.`,
            timer: 1500,
            showConfirmButton: false
        });
    });

    function filterProducts() {
        const searchTerm = $('#searchProducts').val().toLowerCase();
        const categoryId = $('#categoryFilter').val();

        $('#availableProducts .product-item').each(function() {
            const productName = $(this).data('product-name');
            const productCategoryId = $(this).data('category-id');

            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !categoryId || productCategoryId == categoryId;

            if (matchesSearch && matchesCategory) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    function updateProductInputs() {
        $('#selectedProducts .selected-product-item').each(function(index) {
            $(this).find('input[name="products[]"]').val($(this).data('product-id'));
        });
    }

    function updateSelectedCount() {
        const count = $('#selectedProducts .selected-product-item').length;
        $('#selectedCount').text(count);
    }
});
</script>
@endpush
