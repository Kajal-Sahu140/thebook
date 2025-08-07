@extends('admin.master')
@section('content')
<style>
    .breadcrumb {
        background-color: #e9eef2;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
    }
    .breadcrumb li a {
        text-decoration: none;
    }
    /* Custom responsive styles */
    @media (max-width: 768px) {
        .breadcrumb {
            font-size: 0.9rem;
        }
        .h3.mb-3 {
            font-size: 1.5rem;
        }
        .btn-primary {
            width: 100%;
            margin-top: 0.5rem;
        }
        .form-control {
            font-size: 0.875rem;
        }
        .form-label {
            font-size: 0.875rem;
        }
        .col-auto {
            padding-left: 0;
            padding-right: 0;
        }
        .variant-row {
            flex-wrap: wrap;
        }
        .variant-row .col {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        .variant-row .col-auto {
            width: 100%;
        }
        .variant-row .col select,
        .variant-row .col input {
            width: 100%;
        }
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Product</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.product.update', base64_encode($product->product_id)) }}" id="addProductUpdateForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" min="2" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Enter product name">
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="product_name_ar" class="form-label">Product Name (AR)</label>
                        <input type="text" class="form-control @error('product_name_ar') is-invalid @enderror" min="2" id="product_name_ar" name="product_name_ar" value="{{ old('product_name_ar', $product->product_name_ar) }}" placeholder="Enter product name (AR)">
                        @error('product_name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="product_name_cku" class="form-label">Product Name (CKU)</label>
                        <input type="text" class="form-control @error('product_name_cku') is-invalid @enderror" min="2" id="product_name_cku" name="product_name_cku" value="{{ old('product_name_cku', $product->product_name_cku) }}" placeholder="Enter product name (CKU)">
                        @error('product_name_cku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" min="2" name="description" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="mb-3">
                        <label for="description_ar" class="form-label">Description (AR)</label>
                        <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" min="2" name="description_ar" placeholder="Enter product description">{{ old('description_ar', $product->description_ar) }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description_cku" class="form-label">Description (CKU)</label>
                        <textarea class="form-control @error('description_cku') is-invalid @enderror" id="description_cku" min="2" name="description_cku" placeholder="Enter product description">{{ old('description_cku', $product->description_cku) }}</textarea>
                        @error('description_cku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Base Price -->
                    <div class="mb-3">
    <!-- Base Price -->
    <label for="base_price" class="form-label">Base Price (IQD)</label>
    <input 
        type="text" 
        class="form-control @error('base_price') is-invalid @enderror" 
        id="base_price" 
        name="base_price" 
        value="{{ old('base_price', $product->base_price) }}" 
        placeholder="Enter base price" 
        max="999999.99" 
        maxlength="9" 
        oninput="validateBasePrice(this)">
    @error('base_price')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <!-- Quantity -->
    <label for="quantity" class="form-label">Quantity</label>
    <input 
        type="text" 
        class="form-control @error('quantity') is-invalid @enderror" 
        id="quantity" 
        name="quantity" 
        value="{{ old('quantity', $product->quantity) }}" 
        placeholder="Enter product quantity" 
        min="0" 
        max="999999" 
        maxlength="6" 
        oninput="validateQuantity(this)"
    >
    @error('quantity')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <!-- Discount -->
    <label for="discount" class="form-label">Discount (%)</label>
    <input 
        type="number" 
        step="1" 
        min="0" 
        max="100" 
        class="form-control @error('discount') is-invalid @enderror" 
        id="discount" 
        name="discount" 
        value="{{ old('discount', $product->discount) }}" 
        placeholder="Enter discount percentage"
    >
    @error('discount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                    <!-- Brand -->
                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Brand</label>
                        <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Image Upload (Product Image) -->
                 <div class="mb-3">
    <label for="images" class="form-label">Product Images</label>

    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image[]" multiple>
    <small>Leave empty if you don't want to update images.</small>

    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
   

    <div class="d-flex gap-3 product-images-list"> 
    <!-- Show existing images -->
    @if($product->images)
        <div id="existing-images" class="mt-2 d-flex flex-wrap gap-2">
            @foreach($product->images as $key => $image)
                <div class="image-container position-relative d-inline-block" data-image-id="{{ $image->image_id }}">
                    <img src="{{ $image->image_url }}" alt="Product Image" class="img-thumbnail" width="100">
                    <button type="button" class="btn btn-danger remove-image-btn position-absolute top-0 end-0" style="z-index: 1;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Preview new images -->
    <div id="imagePreviewContainer" class="mt-3 d-flex flex-wrap gap-2">
        <!-- New image previews will be shown here -->
    </div>
  </div>
</div>

 <div class="mb-3">
    <label for="variants" class="form-label">Variants</label>
    <div id="variants">
        @foreach($product->variants as $variant)
            <div class="variant-row row mb-2">
                <div class="col">
                    <select name="variant_colors[]" id="variant_colors" class="form-control">
                        <option value="" disabled>Select Color</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" 
                                {{ $variant->color == $color->id ? 'selected' : '' }}>
                                {{ $color->name }} <!-- Display color name -->
                            </option>
                        @endforeach
                    </select>
                    @error('variant_colors[]')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
                <div class="col">
                    <select name="variant_sizes[]" id="variant_sizes" class="form-control @error('variant_sizes') is-invalid @enderror">
                        <option value="" disabled>Select Size</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}" {{ $variant->size == $size->id ? 'selected' : '' }}>
                                {{ $size->name }}
                            </option>
                        @endforeach
                    </select>
                     @error('variant_sizes[]')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
                </div>
                <div class="col">
                    <input type="number"  min="0" max="999999.99" 
        maxlength="9"  id="variant_prices" name="variant_prices[]" class="form-control" placeholder="Price" value="{{ $variant->price }}"oninput="validateDecimalPlaces(this)">
       <script>
function validateDecimalPlaces(input) {
    let value = input.value;
    
    // Prevent more than two decimal places
    if (value.includes('.')) {
        let parts = value.split('.');
        if (parts[1].length > 2) {
            input.value = parts[0] + '.' + parts[1].slice(0, 2);
        }
    }
}
       </script>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-variant-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Add New Variant Button -->
    <button type="button" class="btn btn-info" id="add-variant-btn">
        Add Variant
    </button>
</div>
                    <!-- Categories -->
                    <div class="mb-3">
                        <label for="categories" class="form-label">Categories</label>
                        <select class="form-control @error('categories') is-invalid @enderror" id="categories" name="categories">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('categories')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Subcategories -->
                    <div class="mb-3">
                        <label for="subcategories" class="form-label">Subcategories</label>
                        <select class="form-control @error('subcategories') is-invalid @enderror" id="subcategories" name="subcategory_id">
                            <option value="">Select Subcategory</option>
                            
                        </select>
                        @error('subcategories')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        </div>
                        
                        
                         <div class="mb-3">
                        <label for="status" class="form-label">Language</label>
                        <select name="language" id="language" class="form-control">
                            <option value="english" {{ old('language', $product->language) == 'english' ? 'selected' : '' }}>English</option>
                            <option value="hindi" {{ old('language', $product->language) == 'hindi' ? 'selected' : '' }}>Hindi</option>
                        </select>

                        </div>
                        
                         <div class="mb-3">
                        
                         <label for="status" class="form-label">Product type</label>
                        <select name="product_type" id="product_type" class="form-control">
                            <option value="single" {{ old('product_type', $product->product_type) == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="combo" {{ old('product_type', $product->product_type) == 'combo' ? 'selected' : '' }}>Combo</option>
                        </select>
                         </div>
                        
                        
                           <div class="mb-3">
                        <label for="status" class="form-label">type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="upcoming" {{ old('type', $product->type) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="popular" {{ old('type', $product->type) == 'popular' ? 'selected' : '' }}>Popular</option>
                        </select>

                        </div>
                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
 $(document).ready(function() {
     $.validator.addMethod("extension", function(value, element, param) {
            if (this.optional(element)) {
                return true;
            }
            var file = element.files[0];
            if (file) {
                var ext = file.name.split('.').pop().toLowerCase();
                return param.split('|').indexOf(ext) > -1;
            }
            return false;
        }, "Only image files (jpg, jpeg, png, gif) are allowed");
       $.validator.addMethod("fileSize", function(value, element, param) {
        let isValid = true;
        $.each(element.files, function(index, file) {
            if (file.size > param) {
                isValid = false;
            }
        });
        return isValid;
    }, "Each image must be less than 3MB.");

    $.validator.addMethod("maxFiles", function(value, element, param) {
        let totalFiles = element.files.length + $('#existing-images .image-container').length;
        return totalFiles <= param;
    }, "You can upload a maximum of 5 images (including existing ones).");
    // Add validation rules
    $('#addProductUpdateForm').validate({
        rules: {
            product_name: {
                required: true,
                maxlength: 90,
            },
            product_name_ar: {
            //     required: true,
            //     maxlength: 50,
            // },
            // product_name_cku: {
            //     required: true,
            //     maxlength: 50,
            // },
            description: {
                required: true,
                maxlength: 500,
            },
            // description_ar: {
            //     required: true,
            //     maxlength: 500,
            // },
            // description_cku: {
            //     required: true,
            //     maxlength: 500,
            // },
           brand_id: {
                required: true,
            },
           base_price: {
            required: true,
            number: true,
            min: 0.01, // Minimum base price
            max: 999999.99, // Maximum base price (8 digits before decimal, 2 after)
        },
         categories: {
                required: true,
            },
        quantity: {
            required: true,
            digits: true,
            min: 0, // Minimum quantity
            max: 999999, // Maximum quantity (6 digits)
        },
        discount: {
            required: false,
            number: true,
            min: 0, // Minimum discount
            max: 100, // Maximum discount
        },
             'image[]': {
                extension: "jpg|jpeg|png|gif",
                fileSize: 3145728,  // 3MB in bytes
                maxFiles: 5
            },
           
           'variant_colors[]': {
                required: true,
           },
           'variant_sizes[]': {
                required: true,
           },
             'variant_prices[]': {
                required: true,
                number: true,
                min: 0,
             pattern: /^\d{0,6}(\.\d{1,2})?$/
            },
        },
        messages: {
            product_name:{
                required: "Please enter a product name.",
                maxlength: "Product name can't exceed 90 characters.",
            },
            // product_name_ar:{
            //     required: "Please enter a product name (AR).",
            //     maxlength: "Product name can't exceed 50 characters.",
            // },
            // product_name_cku:{
            //     required: "Please enter a product name (CKU).",
            //     maxlength: "Product name can't exceed 50 characters.",
            //     },
            description:{
                required: "Please provide a description.",
                maxlength: "Description can't exceed 500 characters.",
            },
            // description_ar:{
            //     required: "Please provide a description (AR).",
            //     maxlength: "Description can't exceed 500 characters.",
            // },
            // description_cku:{
            //     required: "Please provide a description (CKU).",
            //     maxlength: "Description can't exceed 500 characters.",
            // },
            brand_id:{
                required: "Please select a brand.",
            } ,
           base_price: {
                required: "Please enter a base price.",
                number: "Base price must be a valid number.",
                min: "Base price must be at least 0.01.",
                max: "Base price cannot exceed 999999.99.",
            },
            quantity: {
                required: "Please enter the product quantity.",
                digits: "Quantity must be a whole number.",
                min: "Quantity must be at least 0.",
                max: "Quantity cannot exceed 999,999.",
            },
            discount: {
                number: "Discount must be a valid number.",
                min: "Discount must be at least 0.",
                max: "Discount must be between 0 and 100.",
            },
            'image[]':{
                extension: "Please upload valid images (JPG, JPEG, PNG).",
                fileSize: "Each image must be less than 3MB.",
                maxFiles: "You can upload a maximum of 5 images.",
            },
            categories:{
                required: "Please select at least one category.",
            },
            'variant_prices[]':{
                required: "Please enter at least one variant price.",
                number: "Variant price must be a number.",
                min: "Variant price must be a positive number.",
                
            },
            'variant_colors[]': {
                required: "Please select at least one variant color.",
            },
            'variant_sizes[]': {
                required: "Please select at least one variant size.",
            }
        },
        errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            

            submitHandler: function(form) {
                form.submit();
            }
    });
// Handle dynamic image upload and removal
 $("#image").on("change", function() {
        let files = this.files;
        let previewContainer = $("#imagePreviewContainer");
        previewContainer.html(""); 
         // Clear previous previews
        

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                if (file.type.match("image.*")) {
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        let imageElement = `
                            <div class="position-relative">
                                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" width="100">
                                <button type="button" class="btn btn-danger btn-sm remove-preview position-absolute top-0 end-0" style="z-index: 1;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                        previewContainer.append(imageElement);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    });

    // Remove preview image
    $(document).on("click", ".remove-preview", function() {
        $(this).parent().remove();
    });

    // Remove existing image
    $(".remove-image-btn").on("click", function() {
        let imageId = $(this).parent().data("image-id");
        $(this).parent().remove();  // Remove the element
        $("<input>").attr({
            type: "hidden",
            name: "remove_images[]",
            value: imageId
        }).appendTo("form"); // Add to form to handle deletion on the backend
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const existingImagesContainer = document.getElementById('existing-images');

    existingImagesContainer.addEventListener('click', function (event) {
        if (event.target && event.target.closest('.remove-image-btn')) {
            const imageContainer = event.target.closest('.image-container');

            // Get all image containers (live collection)
            const remainingImages = existingImagesContainer.querySelectorAll('.image-container');
            
            console.log("Before removal - Remaining images:", remainingImages.length); // Debugging log

            if (remainingImages.length <= 1) {
                alert('At least one image is required.');
                window.location.reload();
                return;
            }

            if (imageId) {
                // Send AJAX request to remove the image
                fetch("{{ route('admin.product.removeImage') }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({ image_id: imageId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            imageContainer.remove(); // Remove from DOM
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                } else {
                    imageContainer.remove(); // Remove new images from DOM
                }
            // Small delay ensures accurate counting after removal
        }
    });
});
///////////////////////////////////////
$(document).ready(function () {
    const categorySelect = document.getElementById('categories');
    const subcategorySelect = document.getElementById('subcategories');
    const selectedSubcategoryId = '{{ old('subcategory_id', $product->sub_category_id) }}';
    const loadSubcategories = (categoryId) => {
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

        if (categoryId) {
            fetch("{{ route('admin.getSubcategories') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ category_id: categoryId }),
            })
                .then(response => response.json())
                .then(data => {
                    let selectedOption = null;
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;

                        if (subcategory.id == selectedSubcategoryId) {
                            option.selected = true;
                            selectedOption = option;
                        } else {
                            subcategorySelect.appendChild(option);
                        }
                    });

                    if (selectedOption) {
                        subcategorySelect.insertBefore(selectedOption, subcategorySelect.firstChild.nextSibling);
                    }
                })
                .catch(error => console.error("Error fetching subcategories:", error));
        }
    };

    const initialCategoryId = categorySelect.value;
    if (initialCategoryId) {
        loadSubcategories(initialCategoryId);
    }

    categorySelect.addEventListener('change', function () {
        const categoryId = categorySelect.value;
        loadSubcategories(categoryId);
    });
});

//////////////////////////////////

 
    // Handle adding and removing variants
    const addVariantButton = document.getElementById('add-variant-btn');
    const variantsContainer = document.getElementById('variants');

    addVariantButton.addEventListener('click', function () {
        
        const newVariant = document.createElement('div');
        newVariant.classList.add('variant-row', 'row', 'mb-2');
        newVariant.innerHTML = `
            <div class="col">
                <select name="variant_colors[]" class="form-control">
                    <option value="" disabled selected>Select Color</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" {{ old('variant_colors.0') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                    @endforeach
                </select>

                @error('variant_colors[]')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="col">
                <select name="variant_sizes[]" class="form-control">
                    <option value="" disabled selected>Select Size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}"  {{ old('variant_sizes.0') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                    @endforeach
                </select>
                        @error('variant_sizes[]')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="col">
                <input type="number" step="1" min="0"max="999999.99" 
        maxlength="9"  name="variant_prices[]" class="form-control" placeholder="Price" value="">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-variant-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        variantsContainer.appendChild(newVariant);

        // Revalidate after adding new variant
        $('#addProductUpdateForm').validate().element("input[name='variant_prices[]']");
    });

    // Handle removing variant row
    variantsContainer.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-variant-btn')) {
            const row = event.target.closest('.variant-row');
           if (variantsContainer.querySelectorAll('.variant-row').length > 1) {
            row.remove();
        } else {
            alert("You must have at least one variant.");
        }
        }
    });
    document.getElementById('add-variant-btn').addEventListener('click', function () {
    const variantsContainer = document.getElementById('variants');

    // Get all variant rows
    const lastVariantRow = variantsContainer.querySelector('.variant-row:last-child');

    // Check if the last row has empty fields
    const colorField = lastVariantRow.querySelector('select[name="variant_colors[]"]');
    const sizeField = lastVariantRow.querySelector('select[name="variant_sizes[]"]');
    const priceField = lastVariantRow.querySelector('input[name="variant_prices[]"]');

    let hasError = false;

    if (!colorField.value) {
        colorField.classList.add('is-invalid');
        showErrorMessage(colorField, 'Please select a color.');
        hasError = true;
    } else {
        colorField.classList.remove('is-invalid');
        removeErrorMessage(colorField);
    }

    if (!sizeField.value) {
        sizeField.classList.add('is-invalid');
        showErrorMessage(sizeField, 'Please select a size.');
        hasError = true;
    } else {
        sizeField.classList.remove('is-invalid');
        removeErrorMessage(sizeField);
    }

    if (!priceField.value || priceField.value <= 0) {
        priceField.classList.add('is-invalid');
        showErrorMessage(priceField, 'Please enter a valid price.');
        hasError = true;
    } else {
        priceField.classList.remove('is-invalid');
        removeErrorMessage(priceField);
    }

    // Prevent adding new variant if errors exist
    if (hasError) {
        return;
    }

    // Clone and append new variant row if all fields are filled
    const newVariantRow = lastVariantRow.cloneNode(true);
    newVariantRow.querySelector('select[name="variant_colors[]"]').value = "";
    newVariantRow.querySelector('select[name="variant_sizes[]"]').value = "";
    newVariantRow.querySelector('input[name="variant_prices[]"]').value = "";
    variantsContainer.appendChild(newVariantRow);
});

// Function to show error message
function showErrorMessage(element, message) {
    let errorDiv = element.parentNode.querySelector('.invalid-feedback');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.classList.add('invalid-feedback');
        element.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
}

// Function to remove error message
function removeErrorMessage(element) {
    let errorDiv = element.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

</script>
@endsection

