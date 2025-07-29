<div class="row">
    <div class="col-lg-8 col-12">
        <!-- card -->
        <div class="card mb-6 card-lg">
            <!-- card body -->
            <div class="card-body p-6">
                <h4 class="mb-4 h5">Product Information</h4>
                <div class="row">
                    <!-- Product Name -->
                    <div class="mb-3 col-lg-6">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" id="productName"
                               placeholder="Enter product name"
                               value="{{ old('name', $product->name ?? '') }}" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Category -->
                    <div class="mb-3 col-lg-6">
                        <label class="form-label">Product Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div class="mb-3 col-lg-6">
                        <label class="form-label">SKU</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                   name="sku" id="productSku"
                                   placeholder="Product SKU"
                                   value="{{ old('sku', $product->sku ?? '') }}" />
                            <button class="btn btn-outline-secondary" type="button" id="generateSkuBtn">Generate</button>
                        </div>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Code -->
                    <div class="mb-3 col-lg-6">
                        <label class="form-label">Product Code</label>
                        <input type="text" class="form-control @error('product_code') is-invalid @enderror"
                               name="product_code"
                               placeholder="Product Code"
                               value="{{ old('product_code', $product->product_code ?? '') }}" />
                        @error('product_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-3 col-lg-6">
                        <label class="form-label">Price (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                               name="price" step="0.01" min="0"
                               placeholder="0.00"
                               value="{{ old('price', $product->price ?? '') }}" required />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock Quantity -->
                    <div class="mb-3 col-lg-6">
                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                               name="stock_quantity" min="0"
                               placeholder="0"
                               value="{{ old('stock_quantity', $product->stock_quantity ?? '0') }}" required />
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug (Hidden, will be auto-generated) -->
                    <input type="hidden" name="slug" id="productSlug" value="{{ old('slug', $product->slug ?? '') }}">

                    <!-- Product Description -->
                    <div class="mb-3 col-lg-12 mt-5">
                        <h4 class="mb-3 h5">Product Description</h4>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" rows="8"
                                  placeholder="Enter product description">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Images -->
        <div class="card mb-6 card-lg">
            <div class="card-body p-6">
                <h4 class="mb-4 h5">Product Images</h4>

                @if(isset($product) && $product->images->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Current Images</label>
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img src="{{ $image->image_url }}" class="card-img-top"
                                             style="height: 150px; object-fit: cover;" alt="{{ $image->alt_text }}">
                                        <div class="card-body p-2">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                       name="keep_images[]" value="{{ $image->id }}" checked>
                                                <label class="form-check-label small">Keep Image</label>
                                            </div>
                                            @if($image->is_primary)
                                                <span class="badge bg-success">Primary</span>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="setPrimaryImage({{ $image->id }})">
                                                    Set Primary
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Simple File Upload -->
                <div class="mb-3">
                    <label class="form-label">Upload New Images</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror"
                           name="images[]" id="imageUpload" multiple accept="image/*">
                    <div class="form-text">Select up to 5 images (JPEG, PNG, JPG, GIF, SVG, WebP). Maximum file size: 2MB each.</div>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Preview area -->
                    <div id="imagePreview" class="mt-3"></div>

                    <!-- Primary Image Selection (Hidden input for create form) -->
                    <input type="hidden" name="primary_image_index" id="primaryImageIndex" value="0">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <!-- Product Status -->
        <div class="card mb-6 card-lg">
            <div class="card-body p-6">
                <h4 class="mb-4 h5">Product Status</h4>

                <!-- In Stock Toggle -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="flexSwitchStock" name="in_stock" value="1"
                           {{ old('in_stock', $product->in_stock ?? true) ? 'checked' : '' }} />
                    <label class="form-check-label" for="flexSwitchStock">In Stock</label>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Publication Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="draft" {{ old('status', $product->status ?? 'draft') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                        <option value="active" {{ old('status', $product->status ?? '') === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive" {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
                {{ isset($product) ? 'Update Product' : 'Create Product' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Product form loaded successfully');

    // Check required elements
    const productNameInput = document.getElementById('productName');
    const productSkuInput = document.getElementById('productSku');
    const generateSkuBtn = document.getElementById('generateSkuBtn');
    const imageUpload = document.getElementById('imageUpload');

    console.log('Elements status:', {
        productName: productNameInput ? '✅ Found' : '❌ Not found',
        productSku: productSkuInput ? '✅ Found' : '❌ Not found',
        generateBtn: generateSkuBtn ? '✅ Found' : '❌ Not found',
        imageUpload: imageUpload ? '✅ Found' : '❌ Not found'
    });

    // Generate slug from product name
    if (productNameInput) {
        productNameInput.addEventListener('input', function() {
            const name = this.value;
            if (name) {
                fetch('/admin/products/generate-slug', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: name,
                        @if(isset($product))
                        product_id: {{ $product->id }}
                        @endif
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('productSlug').value = data.slug;
                    console.log('✅ Slug generated:', data.slug);
                })
                .catch(error => console.error('Slug generation error:', error));
            }
        });
    }

    // Generate SKU - Simple and reliable
    if (generateSkuBtn) {
        generateSkuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🔄 Generating SKU...');

            // Visual feedback
            this.disabled = true;
            this.textContent = 'Loading...';

            fetch('/admin/products/generate-sku', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok (Status: ' + response.status + ')');
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ SKU generated successfully:', data.sku);
                productSkuInput.value = data.sku;

                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'SKU Generated: ' + data.sku,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('SKU Generated: ' + data.sku);
                }
            })
            .catch(error => {
                console.error('❌ SKU generation error:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to generate SKU. Please try again.\n\nError: ' + error.message
                    });
                } else {
                    alert('Failed to generate SKU. Please try again.\n\nError: ' + error.message);
                }
            })
            .finally(() => {
                // Reset button
                this.disabled = false;
                this.textContent = 'Generate';
            });
        });
    }

    // Simple image preview with validation
    if (imageUpload) {
        imageUpload.addEventListener('change', function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';

            console.log('📁 Files selected:', files.length);

            // Validate file count
            if (files.length > 5) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Too Many Files',
                        text: 'Maximum 5 images allowed. Please select fewer files.'
                    });
                } else {
                    alert('Maximum 5 images allowed. Please select fewer files.');
                }
                this.value = '';
                return;
            }

            // Process each file
            Array.from(files).forEach((file, index) => {
                // Validate file size
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'File Too Large',
                            text: `File "${file.name}" is too large. Maximum 2MB allowed per file.`
                        });
                    } else {
                        alert(`File "${file.name}" is too large. Maximum 2MB allowed per file.`);
                    }
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Invalid File Type',
                            text: `File "${file.name}" is not a valid image type.`
                        });
                    } else {
                        alert(`File "${file.name}" is not a valid image type.`);
                    }
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item d-inline-block m-2';
                    div.style.position = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}"
                             style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                        <div class="mt-1 text-center">
                            <small class="text-muted" title="${file.name}">${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}</small>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary-image-radio" type="radio"
                                       name="primary_image_radio" value="${index}"
                                       ${index === 0 ? 'checked' : ''}
                                       onchange="setPrimaryImageIndex(${index})">
                                <label class="form-check-label">
                                    <small>${index === 0 ? 'Primary' : 'Set Primary'}</small>
                                </label>
                            </div>
                        </div>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);

                console.log(`📷 Preview created for: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)`);
            });

            // Show success message for multiple files
            if (files.length > 1) {
                console.log(`✅ ${files.length} images ready for upload`);
            }
        });
    }
});

// Function to set primary image index for create form
function setPrimaryImageIndex(index) {
    document.getElementById('primaryImageIndex').value = index;
    console.log('✅ Primary image index set to:', index);
}

@if(isset($product))
function setPrimaryImage(imageId) {
    console.log('Setting primary image:', imageId);

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Setting Primary Image...',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    }

    fetch(`/admin/products/{{ $product->id }}/set-primary-image`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            image_id: imageId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Primary image updated successfully.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                alert('Primary image updated successfully.');
                location.reload();
            }
        } else {
            throw new Error(data.message || 'Unknown error');
        }
    })
    .catch(error => {
        console.error('Set primary image error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to set primary image: ' + error.message
            });
        } else {
            alert('Failed to set primary image: ' + error.message);
        }
    });
}
@endif
</script>
@endpush
