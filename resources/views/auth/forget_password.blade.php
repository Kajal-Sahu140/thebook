<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - My Babe eCommerce</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="{{ asset('storage/assets/website/fav.svg')}}" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #007bff 0%, #ff6f81 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .forgot-password-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
            color: black;
        }

        .forgot-password-container h2 {
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

        /* CSS to position error message box at the top right */
        .alert {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 9999;
            display: none; /* Hide initially */
        }

        @media (max-width: 576px) {
            .forgot-password-container {
                padding: 20px;
            }

            .forgot-password-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Error message container -->
    @if ($errors->any())
    <div class="alert alert-danger" id="error-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Or for custom messages like admin not found -->
    @if(session('error'))
        <div class="alert alert-danger" id="error-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="forgot-password-container">
        <div style="display: flex; justify-content: center; align-items: center; height: 100px;">
            <img src="{{ asset('storage/app/public/assets/website/fav.svg')}}" height="100px" />
        </div>
        <h2 class="text-center">Forgot Password</h2>
        <form id="forgot-password" action="{{ route('admin.access.forgetPasswordProcess') }}" method="POST">
            @csrf
            <div class="form-group">
        <label for="email">Email Address</label>
        <input 
            type="text" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            value="{{ old('email') }}"
            placeholder="Enter Your Email"
        >
        <span id="email-error" class="invalid-feedback d-block"></span>
    </div>

            <button type="submit" class="btn btn-primary btn-block">Send OTP</button>
            <div class="text-center mt-3">
                <a href="{{ route('admin.access.login') }}">Back to Login</a>
            </div>
        </form>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show the error message if it exists
            if($('#error-message').length > 0) {
                $('#error-message').fadeIn(); // Fade in error message
                setTimeout(function() {
                    $('#error-message').fadeOut(); // Fade out after 5 seconds
                }, 5000);
            }

            $("#forgot-password").validate({
                rules: {
                    email: {
                        required: true,
                email: true,  
                maxlength: 70,
                regex: /^[^@]+@[^@]+\.[a-zA-Z]{2,6}$/
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                        maxlength: "Email must be less than 70 characters.",
                        regex: "Please enter a valid email address."
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
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>
