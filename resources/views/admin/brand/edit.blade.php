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
            <li class="breadcrumb-item"><a href="{{ route('admin.brand') }}">Brand</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Brand</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Brand</h1>
        <div class="card">
            <div class="card-body">
               <form id="editCategoryForm" action="{{ route('admin.brand.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH') <!-- Specify PATCH request for updating -->
    <div class="mb-3">
        <label for="name" class="form-label">Brand Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
            value="{{ old('name', $category->name) }}" placeholder="Enter Brand Name">
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
     <div class="mb-3">
        <label for="name_ar" class="form-label">Brand Name (AR)</label>
        <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" 
            value="{{ old('name_ar', $category->name_ar) }}" placeholder="Enter Brand Name">
        @error('name_ar')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
     <div class="mb-3">
        <label for="name" class="form-label">Brand Name (CKU)</label>
        <input type="text" name="name_cku" id="name_cku" class="form-control @error('name_cku') is-invalid @enderror" 
            value="{{ old('name_cku', $category->name_cku) }}" placeholder="Enter Brand Name">
        @error('name_cku')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
            placeholder="Enter a brief description about the brand">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description (AR)</label>
        <textarea name="description_ar" id="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror" 
            placeholder="Enter a brief description about the brand">{{ old('description_ar', $category->description_ar) }}</textarea>
        @error('description_ar')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description (CKU)</label>
        <textarea name="description_cku" id="description_cku" rows="4" class="form-control @error('description_cku') is-invalid @enderror" 
            placeholder="Enter a brief description about the brand">{{ old('description_cku', $category->description_cku) }}</textarea>
        @error('description_cku')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Brand Image</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
        <img id="imagePreview" 
            src="{{ $category->image}}" 
            alt="Image Preview" 
            style="{{ $category->image ? '' : 'display: none;' }} margin-top: 10px; max-height: 150px;">
        
        @error('image')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
      <div class="mb-3">
        <label for="image_ar" class="form-label">Brand Image (AR)</label>
        <input type="file" name="image_ar" id="image_ar" class="form-control @error('image_ar') is-invalid @enderror" onchange="previewImageAr(event)">
        <img id="imagePreviewAr" 
            src="{{ $category->image_ar}}" 
            alt="Image Preview" 
            style="{{ $category->image_ar ? '' : 'display: none;' }} margin-top: 10px; max-height: 150px;">
        
        @error('image_ar')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
      <div class="mb-3">
        <label for="image_cku" class="form-label">Brand Image (CKU)</label>
        <input type="file" name="image_cku" id="image_cku" class="form-control @error('image_cku') is-invalid @enderror" onchange="previewImageCku(event)">
        <img id="imagePreviewCku" 
            src="{{ $category->image_cku}}" 
            alt="Image Preview" 
            style="{{ $category->image_cku ? '' : 'display: none;' }} margin-top: 10px; max-height: 150px;">
        
        @error('image_cku')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_active" value="1" 
                {{ old('status', $category->status) == 'active' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_active">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" 
                {{ old('status', $category->status) == '' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_inactive">Inactive</label>
        </div>
        @error('status')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update Brand</button>
</form>
            </div>
        </div>
    </div>
</main>
<!-- Preview Image Script -->
<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
    }
    function previewImageAr(event){
        const imagePreviewAr = document.getElementById('imagePreviewAr');
        imagePreviewAr.src = URL.createObjectURL(event.target.files[0]);
        imagePreviewAr.style.display = 'block';
    }
    function previewImageCku(event){
        const imagePreviewCku = document.getElementById('imagePreviewCku');
        imagePreviewCku.src = URL.createObjectURL(event.target.files[0]);
        imagePreviewCku.style.display = 'block';
    }
</script>
<!-- Validation Script -->
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
        $("#editCategoryForm").validate({
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
                //     extension: "jpg|jpeg|png|gif"
                // },
                status: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter the brand name.",
                    maxlength: "Name can't exceed 30 characters.",
                },
                name_ar: {
                    required: "Please enter the brand name (AR).",
                    maxlength: "Name can't exceed 30 characters.",
                },
                name_cku: {
                    required: "Please enter the brand name (CKU).",
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
                //     extension: "Only JPG, JPEG, PNG, and GIF formats are allowed.",
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

    </script>
@endsection

