@extends('warehouse.master')
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


    <div class="col-sm-10" style="margin-left:300px;margin-top:50px">
        <h1 class="h3 mb-3">Add Category</h1>
        <div class="card">
            <div class="card-body">
                <form id="addCategoryForm" action="{{route('warehouse.category.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
            value="{{ old('name') }}" placeholder="Enter Category Name">
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
            placeholder="Enter a description for the category">{{ old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Parent Category</label>
        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">None (Main Category)</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Category Image</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
        @error('image')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-height: 150px;">
    </div>
   <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_active" value="1" 
                {{ old('status') === '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_active">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" 
                {{ old('status') === '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_inactive">Inactive</label>
        </div>
        @error('status')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Add Category</button>
</form>
            </div>
        </div>
    </div>
  <script>
   function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
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
    
       $(document).ready(function () {
    // Custom file extension validation for image
    $.validator.addMethod("extension", function (value, element, param) {
        if (this.optional(element)) {
            return true;
        }
        var file = element.files[0];
        if (file) {
            var ext = file.name.split('.').pop().toLowerCase();
            return param.split('|').indexOf(ext) > -1;
        }
        return false;
    }, "Only image files (jpg, jpeg, png) are allowed");

    // Initialize form validation
    $("#addCategoryForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 30,
            },
            description: {
                required: true,
                maxlength: 1000,
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png",
            },
            status: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "Please enter the category name.",
                maxlength: "Name can't exceed 30 characters.",
            },
            description: {
                required: "Please provide a description.",
                maxlength: "Description can't exceed 1000 characters.",
            },
            image: {
                required: "Please upload an image.",
                extension: "Only JPG, JPEG, and PNG formats are allowed.",
            },
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
        submitHandler: function (form) {
            form.submit(); // Only submit the form after validation passes
        }
    });
    
    // Image preview functionality
    $("#image").change(function (event) {
        previewImage(event);
    });

    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
        }
    }
});

    </script>
    @endsection


