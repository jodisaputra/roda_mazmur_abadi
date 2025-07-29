@extends('layouts.backend')

@section('title', 'Edit Category')

@section('content')
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <!-- pageheader -->
                    <div>
                        <h2>Edit Category</h2>
                        <!-- breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-inherit">Categories</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Category Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Slug -->
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                               id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="auto-generated from name">
                                        <div class="form-text">Auto-generated from name if left empty. Will be made unique automatically.</div>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Parent Category -->
                                    <div class="mb-3">
                                        <label for="parent_id" class="form-label">Parent Category</label>
                                        <select class="form-select @error('parent_id') is-invalid @enderror"
                                                id="parent_id" name="parent_id">
                                            <option value="">Select Parent Category (Optional)</option>
                                            @foreach($parentCategories as $parent)
                                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                    {{ $parent->name }}
                                                </option>
                                                @foreach($parent->children as $child)
                                                    @if($child->id != $category->id)
                                                        <option value="{{ $child->id }}" {{ old('parent_id', $category->parent_id) == $child->id ? 'selected' : '' }}>
                                                            &nbsp;&nbsp;{{ $child->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Category Image -->
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Category Image</label>

                                        @if($category->image)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                                     class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                                <small class="d-block text-muted">Current image</small>
                                            </div>
                                        @endif

                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*">
                                        <div class="form-text">
                                            Upload new category image (JPG, PNG, GIF, SVG, WebP - Max: 2MB)<br>
                                            Leave empty to keep current image
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="disabled" {{ old('status', $category->status) == 'disabled' ? 'selected' : '' }}>Disabled</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-generate slug from name using AJAX
        $(document).ready(function() {
            let slugTimeout;
            let originalSlug = '{{ $category->slug }}';

            $('#name').on('input', function() {
                let name = $(this).val().trim();

                // Clear previous timeout
                clearTimeout(slugTimeout);

                if (name === '') {
                    $('#slug').val('');
                    return;
                }

                // Debounce the AJAX call
                slugTimeout = setTimeout(function() {
                    generateSlug(name, {{ $category->id }});
                }, 300);
            });

            // Allow manual editing of slug with validation
            $('#slug').on('input', function() {
                let slug = $(this).val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '') // Remove special characters except spaces and hyphens
                    .replace(/\s+/g, '-')     // Replace spaces with hyphens
                    .replace(/-+/g, '-')      // Replace multiple hyphens with single hyphen
                    .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
                $(this).val(slug);
            });

            function generateSlug(name, categoryId) {
                $.ajax({
                    url: '{{ route("admin.categories.generate-slug") }}',
                    method: 'POST',
                    data: {
                        name: name,
                        category_id: categoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#slug').val(response.slug);
                    },
                    error: function() {
                        console.error('Failed to generate slug');
                    }
                });
            }
        });
    </script>
@endpush
