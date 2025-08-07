<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Warehouse Forgot Password</title>
    <link rel="icon" href="{{ asset('storage/assets/website/fav.svg')}}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('public/storage/assets/warehouse/css/style.css')}}" rel="stylesheet">
    <style>
        /* Style for alert message positioning */
        .alert-dismissible.position-fixed {
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        /* Center the login card */
        .login-form-bg {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn-primary {
                font-size: 1rem;
            }

            .form-group label {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="h-100">
    <!-- Preloader start -->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!-- Preloader end -->

    <div class="login-form-bg">
        <div class="container">
            <!-- Display error, success, warning, and info messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show position-fixed" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-fixed" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show position-fixed" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show position-fixed" role="alert">
                    {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-9">
                    <div class="form-input-content">
                        <div class="card login-form mb-0 shadow">
                            <div class="card-body pt-5">
                                <div class="text-center mb-3">
                                    <img src="{{ asset('storage/app/public/assets/website/fav.svg')}}" height="100" alt="Logo">
                                </div>
                                <h4 class="text-center">Warehouse Change Password</h4>

                                <!-- Change Password Form -->
                                <form id="change-password" action="{{route('warehouse.access.changePasswordProcess')}}" method="POST" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="otp">Enter OTP</label>
                                        <input type="text" class="form-control" id="otp" name="otp" value="{{ session('otpValue') ?? '' }}" required>
                                        <div class="invalid-feedback">Please enter a valid OTP.</div>
                                        @error('otp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                        <div class="invalid-feedback">Password must be at least 6 characters.</div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="8">
                                        <div class="invalid-feedback">Passwords must match.</div>
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                                </form>

                                <div class="text-center mt-3">
                                    <a href="{{ route('warehouse.access.login') }}">Back to Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/common/common.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/custom.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/settings.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/gleek.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/styleSwitcher.js')}}"></script>

    <!-- Custom Form Validation Script -->
    <script>
        (function () {
            'use strict';
            var form = document.getElementById('change-password');
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
        
        // Automatically close alerts after 5 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    </script>
</body>
</html>
