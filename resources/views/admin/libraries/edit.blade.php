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
       
            <li class="breadcrumb-item active" aria-current="page">Edit Libraris</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Libraris</h1>
        <div class="card">
            <div class="card-body">
                <form id="addCategoryForm" action="{{ route('admin.library.update',['id'=> $library->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
        @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label"> Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
            value="{{  $library->name ?? ''}}" placeholder="Enter  Name">
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    

     <div class="mb-3">
        <label for="name" class="form-label"> Address</label>
        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
            value="{{  $library->address ?? ''}}" placeholder="Enter  addressName">
        @error('address')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

     <div class="mb-3">
        <label for="name" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
            value="{{  $library->email ?? ''}}" placeholder="Enter  email">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

     <div class="mb-3">
        <label for="name" class="form-label">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
            value="{{  $library->phone ?? ''}}" placeholder="Enter  addressName">
        @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
            placeholder="Enter a description for the category">{{  $library->description ?? ''}}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
   

    
   

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
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
                {{ old('status', $library->status) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_active">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" 
                {{ old('status', $library->status) == '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="status_inactive">Inactive</label>
        </div>
        @error('status')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>



    <button type="submit" class="btn btn-primary">edit Library</button>
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
function previewImageAr(event) {
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
                  
                    description: {
                        required: true,
                        maxlength: 1000,
                    },
                   email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    }

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
                    email: {
                        required: "Please enter an email address.",
                        email: "Please enter a valid email address."
                    },
                    phone: {
                        required: "Please enter a phone number.",
                        digits: "Only digits are allowed.",
                        minlength: "Phone number must be at least 10 digits.",
                        maxlength: "Phone number can't be more than 15 digits."
                    }
                   
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

