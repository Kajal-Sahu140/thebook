@extends('admin.master')
@section('content')
<style>
    /* Image container styles */
    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 200px;
        height: 200px;
        margin: 0 auto;
    }
    .profile-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ddd;
    }
    /* Responsive form styling */
    .form-group {
        margin-bottom: 15px;
    }
    @media (max-width: 768px) {
        .profile-image {
            max-width: 150px;
            max-height: 150px;
        }
    }
    .breadcrumb {
    background-color: #e9eef2; /* Light gray background similar to bg-body-tertiary */
    margin-bottom: 1rem; /* Space below the breadcrumb */
    padding: 0.75rem 1rem; /* Add some padding for better spacing */
    border-radius: 0.25rem; /* Optional: adds rounded corners */
}
.breadcrumb li a{
    text-decoration:none;
}
</style>
 <div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end"> <!-- Changed class to float-end for Bootstrap 5 -->
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Users</li>
        </ol>
    </nav>
</div>
<div class="col-md-10 mx-auto mt-6">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">User Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" >
                @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
                </div>
                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ ($user->country_code && $user->phone) ? $user->country_code . '-' . $user->phone : '' }}" required readonly>
                </div>
                <!-- WhatsApp -->
                <div class="form-group">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control" id="whatsapp" value="{{ ($user->whatsapp_country_code && $user->whatsapp) ? $user->whatsapp_country_code . '-' . $user->whatsapp : 'N/A' }}" required readonly>
                </div>
                <!-- Email -->
               <div class="form-group">
    <label for="email">Email <sup>*</sup></label>
    <input type="email" 
           class="form-control @error('email') is-invalid @enderror" 
           id="email" 
           name="email" 
           placeholder="Enter email" 
           value="{{ old('email', $user->email) }}" />
           
    @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" {{ old('status', $user->status) == 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="de-active" {{ old('status', $user->status) == 'de-active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
<!-- Validation Script -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $("#editUserForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 15,
                    digits: true
                },
                whatsapp: {
                    required: true,
                    minlength: 10,
                    maxlength: 15,
                    digits: true
                },
                email: {
                    email: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter the user's name.",
                    minlength: "The name must be at least 3 characters long."
                },
                phone: {
                    required: "Please enter a phone number.",
                    minlength: "The phone number must be at least 10 digits.",
                    maxlength: "The phone number must not exceed 15 digits.",
                    digits: "Please enter a valid phone number."
                },
                whatsapp: {
                    required: "Please enter a WhatsApp number.",
                    minlength: "The WhatsApp number must be at least 10 digits.",
                    maxlength: "The WhatsApp number must not exceed 15 digits.",
                    digits: "Please enter a valid WhatsApp number."
                },
                email: {
                    email: "Please enter a valid email address."
                },
                status: {
                    required: "Please select a status."
                }
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            }
        });
    });

    $('#email').on('blur', function () {
    var email = $(this).val();
    $.ajax({
        url: '/check-email', // Your route for checking email uniqueness
        method: 'POST',
        data: {
            email: email,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.exists) {
                $('#email').addClass('is-invalid');
                $('#email').next('.invalid-feedback').text('The email has already been taken.');
            } else {
                $('#email').removeClass('is-invalid');
            }
        }
    });
});
</script>
@endsection
