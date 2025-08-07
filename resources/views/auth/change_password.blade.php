<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - My Babe eCommerce</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <link rel="icon" href="{{ asset('storage/assets/website/fav.svg')}}" type="image/x-icon">
    <style>
        body {
            background:linear-gradient(135deg, #007bff 0%, #ff6f81 100%); /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0;
        }

        .change-password-container {
            max-width: 400px;
            width: 100%; /* Full width on smaller screens */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background:#fff; /* Blue to Pink Gradient */
            color: black;
        }

        .change-password-container h2 {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #ff6f81; /* Pink button */
            border-color: #ff6f81;
        }

        .btn-primary:hover {
            background-color: #e63946; /* Darker pink on hover */
            border-color: #e63946;
        }

        .text-danger {
            color: #dc3545 !important; /* Bootstrap danger color */
        }

        @media (max-width: 576px) {
            .change-password-container {
                padding: 20px;
            }

            .change-password-container h2 {
                font-size: 1.5rem; /* Adjust heading size for smaller screens */
            }
        }
    </style>
</head>

<body>

<div class="change-password-container">
     <div style="display: flex; justify-content: center; align-items: center; height: 100px;">
    <img src="{{ asset('storage/app/public/assets/website/fav.svg')}}" height="100px" />
</div>
    <h2 class="text-center">Change Password</h2>
    <form id="change-password" action="{{ route('admin.access.changePasswordProcess') }}" method="POST">
    @csrf <!-- CSRF token for security -->
    
    <!-- OTP Input -->
    <div class="form-group">
        <label for="otp">Enter OTP</label>
        <input type="text" 
               class="form-control" 
               id="otp" 
               name="otp" 
               value="{{old('otp')}}" 
               placeholder="Enter the OTP sent to your email" 
               required autofocus>
        @error('otp')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- New Password Input -->
    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" 
               class="form-control" 
               id="password" 
               name="password" 
               placeholder="Enter a strong password" 
               required>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Confirm Password Input -->
    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" 
               class="form-control" 
               id="confirm_password" 
               name="confirm_password" 
               placeholder="Re-enter your new password" 
               required>
        @error('confirm_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Change Password Button -->
    <button type="submit" class="btn btn-primary btn-block">Change Password</button>
    
    <!-- Resend OTP Button -->
    <div class="text-center mt-3">
        <button type="button" class="btn btn-link" id="resend-otp">Resend OTP</button>
    </div>
    
    <!-- Back to Login Link -->
    <div class="text-center mt-3">
        <a href="{{ route('admin.access.login') }}">Back to Login</a>
    </div>
</form>

</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(function () {
        // Form validation
        $("#change-password").validate({
            rules: {
                otp: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                otp: {
                    required: "Please enter the OTP.",
                    digits: "Please enter a valid OTP.",
                    minlength: "OTP must be exactly 4 digits.",
                    maxlength: "OTP must be exactly 4 digits."
                },
                password: {
                    required: "Please enter a new password.",
                    minlength: "Your password must be at least 6 characters long.",
                    maxlength: "Password must be less than 20 characters."
                },
                confirm_password: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                }
            },
            errorClass: 'text-danger', // Error message color
            validClass: 'text-success', // Success message color
        });

        // Resend OTP functionality
        $("#resend-otp").click(function () {
            $.ajax({
                url: "", // Update with your route for resending OTP
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    email: $("#email").val() // Pass the email if required
                },
                success: function (response) {
                    alert("OTP has been resent to your email.");
                },
                error: function (response) {
                    alert("Failed to resend OTP. Please try again.");
                }
            });
        });
    });
</script>
</body>

</html>
