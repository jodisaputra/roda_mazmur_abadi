@extends('layouts.backend')

@section('title', 'Product Details')

@section('content')
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-md-flex justify-content-between align-items-center">
                    <!-- page header -->
                    <div>
                        <h2>Product Details</h2>
                        <!-- breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" class="text-inherit">Products</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">Edit Product</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Back to Products</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-12">
                <!-- Product Information -->
                <div class="card mb-6 card-lg">
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Product Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Product Name</label>
                                <p class="mb-0">{{ $product->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <p class="mb-0">
                                    @if($product->category)
                                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                                    @else
                                        <span class="text-muted">No category assigned</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Shelves</label>
                                <p class="mb-0">
                                    @if($product->shelves->count() > 0)
                                        @foreach($product->shelves as $shelf)
                                            <span class="badge bg-info me-1">{{ $shelf->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No shelves assigned</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">SKU</label>
                                <p class="mb-0">{{ $product->sku ?: 'Not set' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Product Code</label>
                                <p class="mb-0">{{ $product->product_code ?: 'Not set' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <p class="mb-0 h5 text-success">{{ $product->formatted_price }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stock Quantity</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                        {{ $product->stock_quantity }} units
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stock Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $product->in_stock ? 'success' : 'danger' }}">
                                        {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $product->status === 'active' ? 'success' : ($product->status === 'draft' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Slug</label>
                                <p class="mb-0"><code>{{ $product->slug }}</code></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                @if($product->description)
                <div class="card mb-6 card-lg">
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Product Description</h4>
                        <div class="content">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Product Images -->
                @if($product->images->count() > 0)
                <div class="card mb-6 card-lg">
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Product Images ({{ $product->images->count() }})</h4>
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ $image->image_url }}" class="card-img-top"
                                             style="height: 200px; object-fit: cover;" alt="{{ $image->alt_text }}">
                                        <div class="card-body p-2 text-center">
                                            @if($image->is_primary)
                                                <span class="badge bg-success">Primary Image</span>
                                            @endif
                                            <p class="mb-0 small text-muted">Sort Order: {{ $image->sort_order }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4 col-12">
                <!-- Product Summary -->
                <div class="card mb-6 card-lg">
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Product Summary</h4>

                        <!-- Primary Image -->
                        <div class="text-center mb-4">
                            <img src="{{ $product->primary_image_url }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid rounded"
                                 style="max-height: 200px; object-fit: cover;">
                        </div>

                        <!-- Quick Stats -->
                        <div class="row text-center">
                            <div class="col-6">
                                <h5 class="mb-0">{{ $product->formatted_price }}</h5>
                                <small class="text-muted">Price</small>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-0">{{ $product->stock_quantity }}</h5>
                                <small class="text-muted">Stock</small>
                            </div>
                        </div>

                        <hr>

                        <!-- Timestamps -->
                        <div class="small">
                            <p class="mb-1"><strong>Created:</strong> {{ $product->created_at->format('M d, Y h:i A') }}</p>
                            <p class="mb-0"><strong>Updated:</strong> {{ $product->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card card-lg">
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Actions</h4>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Product
                            </a>
                            <button type="button" class="btn btn-outline-{{ $product->status === 'active' ? 'warning' : 'success' }}"
                                    onclick="toggleStatus({{ $product->id }})">
                                <i class="bi bi-toggle-{{ $product->status === 'active' ? 'off' : 'on' }} me-2"></i>
                                {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                            <button type="button" class="btn btn-outline-{{ $product->in_stock ? 'warning' : 'success' }}"
                                    onclick="toggleStock({{ $product->id }})">
                                <i class="bi bi-box me-2"></i>
                                {{ $product->in_stock ? 'Mark Out of Stock' : 'Mark In Stock' }}
                            </button>
                            <hr>
                            <button type="button" class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">
                                <i class="bi bi-trash me-2"></i>Delete Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Delete product function
    function deleteProduct(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/products/' + productId,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.href = '{{ route("admin.products.index") }}';
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        let message = 'An error occurred while deleting the product.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire(
                            'Error!',
                            message,
                            'error'
                        );
                    }
                });
            }
        });
    }

    // Toggle status function
    function toggleStatus(productId) {
        $.ajax({
            url: '/admin/products/' + productId + '/toggle-status',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        response.message,
                        'error'
                    );
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while updating the product status.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire(
                    'Error!',
                    message,
                    'error'
                );
            }
        });
    }

    // Toggle stock function
    function toggleStock(productId) {
        $.ajax({
            url: '/admin/products/' + productId + '/toggle-stock',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        response.message,
                        'error'
                    );
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while updating the product stock status.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire(
                    'Error!',
                    message,
                    'error'
                );
            }
        });
    }
</script>
@endpush
