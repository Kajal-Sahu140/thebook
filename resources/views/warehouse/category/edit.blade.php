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

    <div class="container">
         <div aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
             @if($category->category_id!=Null)
            <li class="breadcrumb-item">
           <a href="{{ route('warehouse.category.subcategory', base64_encode($category->category_id)) }}">Sub Categories</a>
</li>

            @else
            <li class="breadcrumb-item"><a href="{{ route('warehouse.category') }}">Categories</a></li>

            @endif
            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
        </ol>
</div>
         @if($category->category_id!=Null)
        <h1 class="h3 mb-3">Edit Sub Category</h1>
        @else
        <h1 class="h3 mb-3">Edit Category</h1>
        @endif
        <div class="card">
            <div class="card-body">
               <form id="editCategoryForm" action="{{ route('warehouse.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
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
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
            placeholder="Enter a description for the category">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
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
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
    }
</script>
<!-- Validation Script -->

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(function () {
            $('#description').summernote({
                height: 150,
            });
            $("#editCategoryForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    description: {
                        required: true,
                        maxlength: 150,
                    },
                    image: {
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    name: {
                        required: "Please enter the category name.",
                        maxlength: "Name can't exceed 30 characters.",
                    },
                    description: {
                        required: "Please provide a description.",
                        maxlength: "Description can't exceed 150 characters.",
                    },
                    image: {
                        extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    },
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
                }
            });
        });
    </script>
@endsection

