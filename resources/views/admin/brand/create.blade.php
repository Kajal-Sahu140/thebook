

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
        #imagePreview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.brand') }}">Brand</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Brand</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Brand</h1>
        <div class="card">
            <div class="card-body">




                                   <form id="addBrandForm_add" enctype="multipart/form-data" action="{{ route('admin.brand.store') }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Brand Name</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                                value="{{ old('name') }}" placeholder="Enter Brand Name">
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Brand Name (AR)</label>
                                            <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" 
                                                value="{{ old('name_ar') }}" placeholder="Enter Brand Name">
                                            @error('name_ar')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Brand Name (cku)</label>
                                            <input type="text" name="name_cku" id="name_cku" class="form-control @error('name_cku') is-invalid @enderror" 
                                                value="{{ old('name_cku') }}" placeholder="Enter Brand Name">
                                            @error('name_cku')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                                placeholder="Enter Brand Description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (Ar)</label>
                                            <textarea name="description_ar" id="description_ar" rows="4" class="form-control @error('description_ar') is-invalid @enderror" 
                                                placeholder="Enter Brand Description">{{ old('description_ar') }}</textarea>
                                            @error('description_ar')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (CKU)</label>
                                            <textarea name="description_cku" id="description" rows="4" class="form-control @error('description_cku') is-invalid @enderror" 
                                                placeholder="Enter Brand Description">{{ old('description_cku') }}</textarea>
                                            @error('description_cku')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Brand Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                                            onchange="previewImage(event)">
                                        @error('image')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror

                                         <br>

                                        <img id="imagePreview" src="" alt="Image Preview" style="display:none;">
                                        <br>

                                        <!-- Show previously uploaded image if available -->
                                        {{--@if(session('temp_image') || old('old_image'))
                                            <img id="imagePreview" 
                                                src="{{ session('temp_image') ? asset('storage/' . session('temp_image')) : asset('storage/' . old('old_image')) }}" 
                                                alt="Image Preview" 
                                                style="display: block; margin-top: 10px; max-height: 150px;">
                                            <input type="hidden" name="old_image" value="{{ session('temp_image') ?? old('old_image') }}">
                                        @else
                                            <img id="imagePreview" src="#" style="display: none; margin-top: 10px; max-height: 150px;">
                                        @endif--}}
                                    </div>
                                     <div class="mb-3">
                                        <label for="image" class="form-label">Brand Image (AR)</label>
                                        <input type="file" name="image_ar" id="image_ar" class="form-control @error('image_ar') is-invalid @enderror" 
                                            onchange="previewImageAr(event)">
                                        @error('image_ar')                                                                                  
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror

                                         <br>

                                        <img id="imagePreview_ar" src="" alt="Image Preview" style="display:none;">
                                        <br>

                                        <!-- Show previously uploaded image if available -->
                                        {{--@if(session('temp_image') || old('old_image'))
                                            <img id="imagePreview" 
                                                src="{{ session('temp_image') ? asset('storage/' . session('temp_image')) : asset('storage/' . old('old_image')) }}" 
                                                alt="Image Preview" 
                                                style="display: block; margin-top: 10px; max-height: 150px;">
                                            <input type="hidden" name="old_image" value="{{ session('temp_image') ?? old('old_image') }}">
                                        @else
                                            <img id="imagePreview" src="#" style="display: none; margin-top: 10px; max-height: 150px;">
                                        @endif--}}
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Brand Image (CKU)</label>
                                        <input type="file" name="image_cku" id="image_cku" class="form-control @error('image_cku') is-invalid @enderror" 
                                            onchange="previewImageCku(event)">
                                        @error('image_cku')                                                                                  
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror

                                         <br>

                                        <img id="imagePreview_cku" src="" alt="Image Preview" style="display:none;">
                                        <br>

                                        <!-- Show previously uploaded image if available -->
                                        {{--@if(session('temp_image') || old('old_image'))
                                            <img id="imagePreview" 
                                                src="{{ session('temp_image') ? asset('storage/' . session('temp_image')) : asset('storage/' . old('old_image')) }}" 
                                                alt="Image Preview" 
                                                style="display: block; margin-top: 10px; max-height: 150px;">
                                            <input type="hidden" name="old_image" value="{{ session('temp_image') ?? old('old_image') }}">
                                        @else
                                            <img id="imagePreview" src="#" style="display: none; margin-top: 10px; max-height: 150px;">
                                        @endif--}}
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
                                        <button type="submit" class="btn btn-primary">Add Brand</button>
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
function previewImageAr(event){
    const imagePreview = document.getElementById('imagePreviewAr');
    const file = event.target.files[0];
    if (file) {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    }
}
function previewImageCku(event){
    const imagePreview = document.getElementById('imagePreviewCku');
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
        $("#addBrandForm_add").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 30,
                },
                name_ar:{
                    required: true,
                    maxlength: 30,
                },
                name_cku:{
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
                image: {
                    required: true,
                    extension: "jpg|jpeg|png|gif"
                },
                image_ar: {
                    required: true,
                    extension: "jpg|jpeg|png|gif"
                },
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
                    required: "Please enter the brand name.",
                    maxlength: "Name can't exceed 30 characters.",
                },
                name_cku: {
                    required: "Please enter the brand name.",
                    maxlength: "Name can't exceed 30 characters.",
                },
                description: {
                    required: "Please provide a description.",
                    maxlength: "Description can't exceed 1000 characters.",
                },
                description_ar: {
                    required: "Please provide a description.",
                    maxlength: "Description can't exceed 1000 characters.",
                },
                description_cku: {
                    required: "Please provide a description.",
                    maxlength: "Description can't exceed 1000 characters.",
                },
                image: {
                    required: "Please upload an image.",
                    extension: "Only JPG, JPEG, PNG, and GIF formats are allowed.",
                },
                image_ar: {
                    required: "Please upload an image.",
                    extension: "Only JPG, JPEG, PNG, and GIF formats are allowed.",
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
