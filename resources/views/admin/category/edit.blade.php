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
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @if($category->category_id!=Null)
            <li class="breadcrumb-item">
           <a href="{{ route('admin.subcategory', base64_encode($category->category_id)) }}">Sub Categories</a>
</li>

            @else
            <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Categories</a></li>

            @endif
            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        @if($category->category_id!=Null)
        <h1 class="h3 mb-3">Edit Sub Category</h1>
        @else
        <h1 class="h3 mb-3">Edit Category</h1>
        @endif
        <div class="card">
            <div class="card-body">
               <form id="editCategoryForm" action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH') <!-- Specify PATCH request for updating -->

    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
            value="{{ old('name', $category->name) }}" placeholder="Enter Category Name">
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
   <div class="mb-3">
        <label for="name_ar" class="form-label">Category Name (AR)</label>
        <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" 
            value="{{ old('name_ar', $category->name_ar) }}" placeholder="Enter Category Name (AR)">
        @error('name_ar')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
       <div class="mb-3">
        <label for="name_cku" class="form-label">Category Name (CKU)</label>
        <input type="text" name="name_cku" id="name_cku" class="form-control @error('name_cku') is-invalid @enderror" 
            value="{{ old('name_cku', $category->name_cku) }}" placeholder="Enter Category Name (CKU)">
        @error('name_cku')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>



    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
            placeholder="Enter a description for the category">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description_ar" class="form-label">Description(AR)</label>
        <textarea name="description_ar" id="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror" 
            placeholder="Enter a description for the category">{{ old('description_ar', $category->description_ar) }}</textarea>
        @error('description_ar')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description_cku" class="form-label">Description(CKU)</label>
        <textarea name="description_cku" id="description_cku" rows="4" class="form-control @error('description_cku') is-invalid @enderror"  
            placeholder="Enter a description for the category">{{ old('description_cku', $category->description_cku) }}</textarea>
        @error('description_cku')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Parent Category Selection (commented out) -->
    <!-- <div class="mb-3">
        <label for="category_id" class="form-label">Parent Category</label>
        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">None (Main Category)</option>
            @foreach ($categories as $parentCategory)
                <option value="{{ $parentCategory->id }}" {{ old('category_id', $category->category_id) == $parentCategory->id ? 'selected' : '' }}>{{ $parentCategory->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div> -->

    <div class="mb-3">
        <label for="image" class="form-label">Category Image</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
        <img id="imagePreview" src="{{ $category->image }}" alt="Image Preview" 
            style="{{ $category->image ? '' : 'display: none;' }} margin-top: 10px; max-height: 150px;">
        @error('image')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

     <div class="mb-3">
        <label for="image_ar" class="form-label">Category Image (Ar)</label>
        <input type="file" name="image_ar" id="image_ar" class="form-control @error('image_ar') is-invalid @enderror" onchange="previewImagear(event)">
        <img id="imagePreviewar" src="{{ $category->image_ar }}" alt="Image Preview" 
            style="{{ $category->image ? '' : 'display: none;' }} margin-top: 10px; max-height: 150px;">
        @error('image_ar')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

     <div class="mb-3">
        <label for="image_cku" class="form-label">Category Image (CKU)</label>
        <input type="file" name="image_cku" id="image_cku" class="form-control @error('image_cku') is-invalid @enderror" onchange="previewImagecku(event)">
        <img id="imagePreviewcku" src="{{ $category->image_cku }}" alt="Image Preview" 
            style="{{ $category->image ? '' : 'display: none;' }} margin-top: 10px; max-height: 150px;">
        @error('image_cku')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>


    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_active" value="1" 
                {{ old('status', $category->status) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_active">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" 
                {{ old('status', $category->status) == '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_inactive">Inactive</label>
        </div>
        @error('status')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Category</button>
</form>

            </div>
        </div>
    </div>
</main>
<!-- Preview Image Script -->
<script>
   function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    if (file) {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    }
}
function previewImagear(event) {
    const imagePreview = document.getElementById('imagePreviewar');
    const file = event.target.files[0];
    if (file) {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    }
}
function previewImagecku(event) {
    const imagePreview = document.getElementById('imagePreviewcku');
    const file = event.target.files[0];
    if (file) {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    }
}
</script>
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
        $("#addCategoryForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    name_ar: {  
                        required: true,
                        maxlength: 30,  
                    },
                    name_cku: {
                        required: true,
                        maxlength: 30,
                    },
                    description: {
                        required: true,
                        maxlength: 1000,
                    },
                    description_ar: {
                        required: true,
                        maxlength: 1000,
                    },
                    description_cku: {
                        required: true,
                        maxlength: 1000,
                    },
                    // image: {
                    //     required: true,
                    //     extension: "jpg|jpeg|png",
                    // },  
                    // image_ar: {
                    //     required: "Please upload an image (AR).",
                    //     extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    // },
                    // image_cku: {
                    //     required: "Please upload an image (CKU).",
                    //     extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    // },
                    status: {
                        required: true,
                    }  
                },
                messages: {
                    name: {
                        required: "Please enter the category name.",
                        maxlength: "Name can't exceed 30 characters.",
                    },
                    name_ar: {
                        required: "Please enter the category name (AR).",
                        maxlength: "Name can't exceed 30 characters.",
                    },
                    name_cku: {
                        required: "Please enter the category name (CKU).",
                        maxlength: "Name can't exceed 30 characters.",
                        },
                       
                    description: {
                        required: "Please provide a description.",
                        maxlength: "Description can't exceed 1000 characters.",
                    },
                    description_ar: {
                        required: "Please provide a description (AR).",
                        maxlength: "Description can't exceed 1000 characters.",
                    },
                    description_cku: {
                        required: "Please provide a description (CKU).",
                        maxlength: "Description can't exceed 1000 characters.",
                        },
                    // image: {
                    //     required: "Please upload an image.",
                    //     extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    // },
                    // image_ar: {
                    //     required: "Please upload an image (AR).",
                    //     extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    // },
                    // image_cku: {
                    //     required: "Please upload an image (CKU).",
                    //     extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    // },
                    status: {
                        required: "Please select a status.",
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
     });

    // Image preview function
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
        }
    }

    // Attach previewImage function to the image input change event
    $("#image").change(previewImage);
    </script>
@endsection
