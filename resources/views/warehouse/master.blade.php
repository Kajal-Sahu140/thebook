<!DOCTYPE html>
<html lang="en">
<?php
use Illuminate\Support\Facades\Route;
$routeName = Route::currentRouteName();
$adminName = session('admin.name');
$adminImage = session('admin.image');
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Theme Meta -->
    <meta name="theme-name" content="quixlab" />
    <title>Warehouse Dashboard</title>
    <!-- Favicon icon -->
     <link rel="icon" href="{{ asset('storage/assets/website/fav.svg')}}" type="image/x-icon">
  
   
    <link href="{{ asset('public/storage/assets/warehouse/css/style.css')}}" rel="stylesheet">
    
    <style>
        /* Wave animation */
        @keyframes wave {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }
        /* Wave effect on image */
        .wave-image {
            animation: wave 1.5s ease-in-out infinite;
        }
        /* Wave effect on text */
        .wave-text {
            animation: wave 1.5s ease-in-out infinite;
        }
        /* Loader styles */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Optional: You can adjust the size of the loader GIF if needed */
        #loader img {
            width: 100px;
            height: 100px;
        }
        .nav-header .logo-abbr {
    display: block;
}
        /* Responsive adjustments */
        @media (max-width: 768px) {
           
            .nav-header .brand-logo {
                text-align: center;
            }
            .nav-header .brand-logo .logo-abbr,
            .nav-header .brand-logo .logo-compact {
                display: block;
                margin: 0 auto;
            }
        }
        main.content {
    min-height: 86vh;
}
    </style>
</head>
<body>
    @include('Flash') 
    <div id="loader">
        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif?20170503175831" alt="Loading...">
    </div>
    <div id="main-wrapper">
        <div class="nav-header"style="background-color: #2b2928;">
            <div class="brand-logo ">
                <a href="{{route('warehouse.dashboard')}}">
                   <b class="logo-abbr">
    

<span class="brand-title">
    <img src="{{ url('public/storage/' . Auth::guard('warehouse')->user()->image) }}" 
         alt="Admin Image" 
         style="width: 40px; height: 40px; border-radius: 50%;max-width:none;"> <!-- Rounded Image with Wave Animation -->
    <span class="text-white">{{ Auth::guard('warehouse')->user()->name }}</span>
</span>
 </a>
            </div>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            @include('warehouse.layout.sidebar')
            @include('warehouse.layout.header')
            <main class="content">
                @yield('content')
            </main>
            @include('warehouse.layout.footer')
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loader').style.display = 'none'; // Hide the loader after the page has loaded
        });
    </script>
    <script>
    // Automatically close the alert after 5 seconds
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
</script>

</body>
</html>
