<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - My Babe eCommerce</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="{{ asset('storage/app/public/assets/website/fav.svg')}}" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #007bff 0%, #ff6f81 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
            color: black;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #ff6f81;
            border-color: #ff6f81;
        }

        .btn-primary:hover {
            background-color: #e63946;
            border-color: #e63946;
        }

        .text-danger {
            font-size: 0.9rem;
        }

        .password-wrapper {
            position: relative;
        }

        .input-group-append {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .invalid-feedback {
            display: block;
        }

        /* Media query for smaller screens */
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }

            .login-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
     @include('Flash') 
<div class="login-container">
    <div style="display: flex; justify-content: center; align-items: center; height: 100px;">
        <img src="{{ asset('storage/app/public/assets/website/fav.svg')}}" height="50px" width="150px" />
    </div>
    <h2 class="text-center">Admin Login</h2>
    <form id="login" action="{{ route('admin.signIn') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Enter Your Email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" class="form-control" id="password" name="password" placeholder="***************"required>
                <div class="input-group-append" id="toggle-password">
                    <span class="input-group-text"><i class="far fa-eye" id="eye-icon"></i></span>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
        <div class="text-center mt-3">
            <a href="{{ route('admin.access.forgetPassword') }}">Forgot your password?</a>
        </div>
    </form>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(function () {
        // Toggle password visibility
        $('#toggle-password').on('click', function () {
            const passwordField = $('#password');
            const eyeIcon = $('#eye-icon');
            const isPasswordVisible = passwordField.attr('type') === 'text';
            passwordField.attr('type', isPasswordVisible ? 'password' : 'text');
            eyeIcon.toggleClass('fa-eye fa-eye-slash');
        });

        // Prevent the eye icon from being hidden
        $("#login").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 70
                },
                password: {
                    required: true,
                    minlength: 6,
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address.",
                    maxlength: "Email must be less than 70 characters."
                },
                password: {
                    required: "Please enter your password.",
                    minlength: "Your password must be at least 6 characters long."
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

</body>

</html>
