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
            <li class="breadcrumb-item"><a href="{{ route('admin.warehouse') }}">Warehouse</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Warehouse</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Warehouse</h1>
        <div class="card">
            <div class="card-body">
               <form id="addCategoryForm" action="{{route('admin.warehouse.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- User Name -->
    <div class="mb-3">
        <label for="name" class="form-label">User Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your username">
        @error('name') 
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email address"/> 
        @error('email') 
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <!-- Image -->
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
        @error('image') 
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-height: 150px;">
    </div>
    <!-- Status -->
    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" {{ old('status') === 'active' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_active">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="de-active" {{ old('status') === 'de-active' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_inactive">Inactive</label>
        </div>
        @error('status') 
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
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
@section('validationJs')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(function () {
            $('#description').summernote({
                height: 150,
            });
            $("#addCategoryForm").validate({
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
                        required: true,
                        
                        accept: "image/*",
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
                        required: "Please upload an image.",
                       
                        accept: "Only JPG, JPEG, and PNG formats are allowed.",
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
@endsection
