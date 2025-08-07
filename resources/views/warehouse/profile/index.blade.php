@extends('warehouse.master')
@section('content') 
<div class="container">
    <h1 class="h3 mt-5"><strong>Warehouse Profile</strong></h1>
    <div class="row">
        <!-- Sidebar for Profile Picture & Basic Info -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ $user->image ? asset('public/storage/' . $user->image) : 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg' }}" 
                         alt="Profile Picture" 
                         class="img-fluid rounded-circle mb-3" 
                         style="width: 128px; height: 128px;">
                    <h5 class="card-title text-dark">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        
        <!-- Main Content: Edit Profile and Change Password Forms -->
        <div class="col-md-6 col-lg-8">
            <!-- Edit Profile Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Edit Personal Information</h5>
                    <form action="{{ route('warehouse.profiles.updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
                        @csrf
                        @method('PUT')
                       <div class="mb-3">
    <label for="name" class="form-label">Full Name</label>
    <input type="text" 
           class="form-control @error('name') is-invalid @enderror" 
           placeholder="Enter Full Name" 
           id="name" name="name" 
           value="{{ old('name', $user->name) }}" 
           required>
    <div id="name-error" class="invalid-feedback" style="display: none;"></div>
     @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
</div>
                        <script>
document.getElementById('name').addEventListener('input', function () {
    let nameInput = this.value.trim();
    let nameError = document.getElementById('name-error');
    let submitButton = document.getElementById('update-profile-btn');

    if (nameInput.length < 2) {
        this.classList.add('is-invalid');
        nameError.style.display = 'block';
        nameError.innerText = 'Full Name must be at least 2 characters.';
        submitButton.disabled = true; // Disable submit button if invalid
    } else {
        this.classList.remove('is-invalid');
        nameError.style.display = 'none';
        submitButton.disabled = false; // Enable submit button if valid
    }
});


                        </script>
                        <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            placeholder="Enter Email" 
                            id="email" name="email" 
                            value="{{ old('email', $user->email) }}" 
                            required>
                        <div class="invalid-feedback" id="email-error" style="display: none;">
                            Please enter a valid email address.
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

<!-- JavaScript for Real-time Validation -->
<script>
    document.getElementById('email').addEventListener('input', function () {
    let emailInput = this.value.trim();
    let emailError = document.getElementById('email-error');
    let submitButton = document.getElementById('update-profile-btn');
    
    let emailPattern = /^[a-zA-Z0-9][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(emailInput)) {
        this.classList.add('is-invalid');
        emailError.style.display = 'block';
        emailError.innerText = 'Please enter a valid email address.';
        submitButton.disabled = true;  // Disable submit button if invalid
    } else {
        this.classList.remove('is-invalid');
        emailError.style.display = 'none';
        submitButton.disabled = false;  // Enable submit button if valid
    }
});

</script>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Picture</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="update-profile-btn">Update Profile</button>
                    </form>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form id="passwordChangeForm" action="{{ route('warehouse.profiles.updatePassword') }}" method="POST">
                        @csrf

                        <div class="mb-3">
    <label for="current_password" class="form-label">Current Password</label>
    <div class="input-group">
        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
               id="current_password" name="current_password" value="{{ old('current_password') }}"
               placeholder="Enter Current Password">
        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
            <i class="fas fa-eye"></i>
        </button>
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="new_password" class="form-label">New Password</label>
    <div class="input-group">
        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
               id="new_password" name="new_password" value="{{ old('new_password') }}"
               placeholder="Enter New Password">
        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
            <i class="fas fa-eye"></i>
        </button>
        @error('new_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="confirm_password" class="form-label">Confirm Password</label>
    <div class="input-group">
        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" 
               id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}"
               placeholder="Enter Confirm Password">
        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
            <i class="fas fa-eye"></i>
        </button>
        @error('confirm_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Include FontAwesome for Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            let input = document.getElementById(this.getAttribute('data-target'));
            let icon = this.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });
</script>
 <button type="submit" class="btn btn-primary w-100">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        // Profile Update Form Validation
        $("#profileUpdateForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 20
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
                    minlength: "Name must be at least 2 characters.",
                    maxlength: "Name cannot exceed 20 characters."
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
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        // Password Change Form Validation
        $.validator.addMethod("notEqualToCurrent", function (value, element) {
            return value !== $("#current_password").val();
        }, "New password cannot be the same as the current password.");

        $("#passwordChangeForm").validate({
            rules: {
                current_password: {
                    required: true,
                    minlength: 8
                },
                new_password: {
                    required: true,
                    minlength: 8,
                    notEqualToCurrent: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
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
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        // Custom Method for File Size Validation
        $.validator.addMethod("filesize", function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1024);
        }, "File size must not exceed {0} KB.");

    });
</script>

@endsection
