@extends('layouts.backend')

@section('title', 'Shelf Details')

@section('content')
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-md-flex justify-content-between align-items-center">
                    <!-- page header -->
                    <div>
                        <h2>Shelf Details</h2>
                        <!-- breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.shelves.index') }}" class="text-inherit">Shelves</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $shelf->name }}</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.shelves.manage-products', $shelf) }}" class="btn btn-info">Manage Products</a>
                        <a href="{{ route('admin.shelves.edit', $shelf) }}" class="btn btn-primary">Edit Shelf</a>
                        <a href="{{ route('admin.shelves.index') }}" class="btn btn-light">Back to Shelves</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-12">
                <!-- Shelf Information -->
                <div class="card mb-6 card-lg">
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Shelf Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Shelf Name</label>
                                <p class="mb-0">{{ $shelf->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Slug</label>
                                <p class="mb-0"><code>{{ $shelf->slug }}</code></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="mb-0">
                                    @if($shelf->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Capacity</label>
                                <p class="mb-0">
                                    @if($shelf->capacity)
                                        {{ $shelf->capacity }} products
                                    @else
                                        <span class="text-muted">Unlimited</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Products Count</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $shelf->products->count() > 0 ? 'primary' : 'secondary' }}">
                                        {{ $shelf->products->count() }}{{ $shelf->capacity ? '/' . $shelf->capacity : '' }} products
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Created</label>
                                <p class="mb-0">{{ $shelf->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($shelf->products->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card card-lg">
                        <div class="card-body p-6">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 h5">Products in this Shelf</h4>
                                <a href="{{ route('admin.shelves.manage-products', $shelf) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-gear"></i> Manage Products
                                </a>
                            </div>

                            <div class="row">
                                @foreach($shelf->products as $product)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 border">
                                        <div class="card-body p-3 text-center">
                                            @if($product->primaryImage)
                                                <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="img-fluid rounded mb-2"
                                                     style="height: 80px; width: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded mb-2 mx-auto"
                                                     style="height: 80px; width: 80px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif

                                            <h6 class="card-title text-truncate mb-1" title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </h6>

                                            <p class="text-muted small mb-1">
                                                {{ $product->category->name ?? 'No Category' }}
                                            </p>

                                            <p class="text-primary fw-bold mb-2">
                                                {{ $product->formatted_price }}
                                            </p>

                                            <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($product->status) }}
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
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card card-lg">
                        <div class="card-body p-6 text-center">
                            <div class="mb-3">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                            </div>
                            <h5 class="mb-2">No Products Yet</h5>
                            <p class="text-muted mb-3">This shelf doesn't have any products assigned yet.</p>
                            <a href="{{ route('admin.shelves.manage-products', $shelf) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add Products Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
