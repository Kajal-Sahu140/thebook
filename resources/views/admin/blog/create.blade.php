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
            <li class="breadcrumb-item"><a href="{{ route('admin.blog') }}">Blogs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Blog</h1>
        <div class="card">
            <div class="card-body">
                <form id="addBlogForm" action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" 
                               value="{{ old('author') }}" placeholder="Enter Author Name">
                        @error('author')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" placeholder="Enter Blog Title">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title_ar" class="form-label">Title (AR)</label>
                        <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" 
                               value="{{ old('title_ar') }}" placeholder="Enter Blog Title (AR)">
                        @error('title_ar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                     <div class="mb-3">
                        <label for="title_cku" class="form-label">Title (CKU)</label>
                        <input type="text" name="title_cku" id="title_cku" class="form-control @error('title_cku') is-invalid @enderror" 
                               value="{{ old('title_cku') }}" placeholder="Enter Blog Title (CKU)">
                        @error('title_cku')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Enter Blog Description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description_ar" class="form-label">Description (AR)</label>
                        <textarea name="description_ar" id="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror" 
                                  placeholder="Enter Blog Description">{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description_cku" class="form-label">Description (CKU)</label>
                        <textarea name="description_cku" id="description_cku" rows="4" class="form-control @error('description_cku') is-invalid @enderror" 
                                  placeholder="Enter Blog Description">{{ old('description_cku') }}</textarea>
                        @error('description_cku')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Blog Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                               onchange="previewImage(event)">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-height: 150px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" 
                                   {{ old('status') === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" 
                                   {{ old('status') === 'inactive' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">Inactive</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Blog</button>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- Preview Image Script -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
 <script>
    CKEDITOR.replace('description');
    CKEDITOR.replace('description_ar');
    CKEDITOR.replace('description_cku');
    </script>
<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
    }
</script>
<!-- Validation Script -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(function () {
        $("#addBlogForm").validate({
            rules: {
                author: {
                    required: true,
                    maxlength: 50,
                },
                title: {
                    required: true,
                    maxlength: 400,
                },
                // title_ar: {
                //     required: true,
                //     maxlength: 50,
                // },
                // description_ar: {
                //     required: true,
                    
                // },
                // title_cku: {
                //     required: true,
                //     maxlength: 50,
                // },
                // description_cku: {
                //     required: true,
                    
                // },
                description: {
                    required: true,
                   
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
                author: {
                    required: "Please enter the author's name.",
                    maxlength: "Author's name can't exceed 50 characters.",
                },
                title: {
                    required: "Please enter the blog title.",
                    maxlength: "Title can't exceed 50 characters.",
                },
                title_ar: {
                    required: "Please enter the blog title (AR).",
                    maxlength: "Title (AR) can't exceed 50 characters.",
                },
                description_ar: {
                    required: "Please provide a description (AR).",
                  
                },
                title_cku: {
                    required: "Please enter the blog title (CKU).",
                    maxlength: "Title (CKU) can't exceed 50 characters.",
                },
                description_cku: {
                    required: "Please provide a description (CKU).",
                   
                },
                description: {
                    required: "Please provide a description.",
                    
                },
                image: {
                    required: "Please upload an image.",
                    extension: "Only JPG, JPEG, and PNG formats are allowed.",
                },
                status: {
                    required: "Please select the status.",
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
            }
        });
    });
</script>

@endsection
