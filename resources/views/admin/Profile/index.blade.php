@extends('admin.master')

@section('content')
<style>
    .profile-img {
        width: 265px;
        height: 265px;
        object-fit: cover;
        border: 5px solid #ddd;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .error{
        color: red;
    }
</style>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>User Profile</strong></h1>

        <div class="row">
            <!-- Profile Picture & Basic Info -->
            <div class="col-xl-6 col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $user->image ? asset('/storage/app/public/' . $user->image) : 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg' }}" 
                            alt="Profile Picture" 
                            class="profile-img mb-2">

                        <h5 class="card-title text-dark mb-0">{{ $user->name }}</h5>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div class="col-xl-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Personal Information</h5>
                        <form id="profileUpdateForm" action="{{ route('admin.profiles.updateProfile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" 
                                    value="{{ old('name', $user->name) }}" 
                                    >
                                @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" 
                                    value="{{ old('email', $user->email) }}" 
                                   >
                                @error('email')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Picture</label>
                                <input type="file" 
                                    class="form-control @error('image') is-invalid @enderror" 
                                    id="image" name="image">
                                @error('image')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="col-xl-12 col-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Change Password</h5>
                        <form id="passwordChangeForm" action="{{ route('admin.profiles.updatePassword') }}" method="POST">
    @csrf

    <!-- Current Password -->
    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" 
            class="form-control @error('current_password') is-invalid @enderror" 
            id="current_password" name="current_password" 
        >
        @error('current_password')
            <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- New Password -->
    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" 
            class="form-control @error('new_password') is-invalid @enderror" 
            id="new_password" name="new_password" 
        >
        @error('new_password')
            <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm New Password -->
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" 
            class="form-control @error('confirm_password') is-invalid @enderror" 
            id="confirm_password" name="confirm_password" 
        >
        @error('confirm_password')
            <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Change Password</button>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
     $(function () {
        // Profile Update Form Validation
        $("#profileUpdateForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255,
                    pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
                },
                image: {
                    extension: "jpg|jpeg|png|gif",
                    filesize: 2048 // File size in KB
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                    maxlength: "Name cannot exceed 50 characters."
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email address.",
                    maxlength: "Email cannot exceed 255 characters.",
                    pattern: "Please enter a valid email address."
                },
                image: {
                    extension: "Please upload a valid image file.",
                    filesize: "Image size must not exceed 2 MB."
                }
            }
        });

        $(document).ready(function() {
    // Custom validation to ensure the new password is not the same as the current password
    $.validator.addMethod("notEqualToCurrent", function(value, element) {
        return value !== $("#current_password").val();
    }, "New password cannot be the same as the current password.");

    // jQuery validation setup
    $("#passwordChangeForm").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 8
            },
            new_password: {
                required: true,
                minlength: 8,
                notEqualToCurrent: true // Custom rule to ensure new password is different from current password
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password" // Ensures confirm password matches new password
            }
        },
        messages: {
            current_password: {
                required: "Please enter your current password.",
                minlength: "Password must be at least 8 characters."
            },
            new_password: {
                required: "Please enter a new password.",
                minlength: "Password must be at least 8 characters.",
                notEqualToCurrent: "New password cannot be the same as the current password."
            },
            confirm_password: {
                required: "Please confirm your new password.",
                equalTo: "Passwords do not match."
            }
        }
    });
});

        // Custom File Size Validation
        $.validator.addMethod("filesize", function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1024);
        }, "File size must not exceed {0} KB.");

        // Ensure new password differs from current password
    //     $.validator.addMethod("notEqualToCurrent", function (value, element, param) {
    //         return value !== $(param).val();
    //     }, "New password cannot be the same as the current password.");
    });
</script>
@endsection




