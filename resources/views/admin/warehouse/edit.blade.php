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
            <li class="breadcrumb-item active" aria-current="page">Edit Warehouse</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Warehouse</h1>
        <div class="card">
            <div class="card-body">
                <!-- Display the password -->
                <div class="text-end">
                    <span>Show Password: {{ $warehouse->dummy_password ?? 'N/A' }}</span>
                </div>
                <!-- Form starts here -->
               <form id="editWarehouseForm" action="{{ route('admin.warehouse.update', $warehouse->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
        <!-- User Name -->
        <div class="col-md-12 mb-3">
            <label for="name" class="form-label">User Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $warehouse->name) }}" placeholder="Enter warehouse name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="col-md-12 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $warehouse->email) }}" placeholder="Enter email address">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- Image -->
        <div class="col-md-12 mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
            @if ($warehouse->image)
                <img id="imagePreview" src="{{ url('/storage/' . $warehouse->image) }}" alt="Image Preview" class="img-fluid mt-2" style="max-height: 150px;">
            @else
                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-height: 150px;">
            @endif
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status -->
        <div class="col-md-12 mb-3">
            <label class="form-label">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status_active" value="active" {{ old('status', $warehouse->status) == 'active' ? 'checked' : '' }}>
                <label class="form-check-label" for="status_active">Active</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status_inactive" value="de-active" {{ old('status', $warehouse->status) == 'de-active' ? 'checked' : '' }}>
                <label class="form-check-label" for="status_inactive">Inactive</label>
            </div>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <!-- Submit Button -->
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        // Custom validation method for file extension
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

        // Apply validation to the form
        $("#editWarehouseForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 30
                },
                email: {
                    required: true,
                    email: true
                },
                image: {
                    required: false, // Make image optional for edit scenario
                    extension: "jpg|jpeg|png|gif"
                },
                status: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter the warehouse name.",
                    maxlength: "Name can't exceed 30 characters."
                },
                email: {
                    required: "Please enter an email address.",
                    email: "Please enter a valid email address."
                },
                image: {
                    extension: "Only JPG, JPEG, PNG, and GIF formats are allowed."
                },
                status: {
                    required: "Please select a status."
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                if (element.attr("name") === "image") {
                    error.insertAfter("#imagePreview"); // Place error after image preview
                } else {
                    error.insertAfter(element); // Default placement
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                form.submit(); // Submit the form if validation is successful
            }
        });
    });
</script>


@endsection
