@extends('layouts.backend')

@section('title', 'Category Details')

@section('content')
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <!-- pageheader -->
                    <div>
                        <h2>Category Details</h2>
                        <!-- breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-inherit">Categories</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- button -->
                    <div>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit Category</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Category Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Category Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name:</label>
                                    <p class="mb-0">{{ $category->name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Slug:</label>
                                    <p class="mb-0"><code>{{ $category->slug }}</code></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Parent Category:</label>
                                    <p class="mb-0">
                                        @if($category->parent)
                                            <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-decoration-none">
                                                {{ $category->parent->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">None (Root Category)</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Image:</label>
                                    <p class="mb-0">
                                        @if($category->image)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $category->image) }}"
                                                     alt="{{ $category->name }}"
                                                     class="img-thumbnail"
                                                     style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                            </div>
                                            <small class="text-muted">{{ $category->image }}</small>
                                        @else
                                            <span class="text-muted">No image uploaded</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status:</label>
                                    <p class="mb-0">
                                        <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($category->status) }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created:</label>
                                    <p class="mb-0">{{ $category->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Updated:</label>
                                    <p class="mb-0">{{ $category->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($category->description)
                            <div class="mt-4">
                                <label class="form-label fw-bold">Description:</label>
                                <p class="mb-0">{{ $category->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Child Categories -->
                @if($category->children->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Child Categories ({{ $category->children->count() }})</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($category->children as $child)
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            @if($child->icon)
                                                <i class="{{ $child->icon }} fs-4 me-3"></i>
                                            @else
                                                <i class="bi bi-folder fs-4 me-3"></i>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('admin.categories.show', $child) }}" class="text-decoration-none">
                                                        {{ $child->name }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    <span class="badge {{ $child->status === 'active' ? 'bg-success' : 'bg-danger' }} badge-sm">
                                                        {{ ucfirst($child->status) }}
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Category
                            </a>

                            <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" class="btn btn-outline-success">
                                <i class="bi bi-plus me-2"></i>Add Child Category
                            </a>

                            <button type="button" class="btn btn-outline-danger" onclick="deleteCategory({{ $category->id }})">
                                <i class="bi bi-trash me-2"></i>Delete Category
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="mb-1">{{ $category->children->count() }}</h4>
                                    <small class="text-muted">Child Categories</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-1">0</h4>
                                <small class="text-muted">Products</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Delete category function
        function deleteCategory(categoryId) {
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
                        url: '/admin/categories/' + categoryId,
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
                                    window.location.href = '{{ route("admin.categories.index") }}';
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
                            let message = 'An error occurred while deleting the category.';
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
    </script>
@endpush
