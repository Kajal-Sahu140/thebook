<?php
use Illuminate\Support\Facades\Route;
$routeName = Route::currentRouteName();
$adminName = session('admin.name');
$adminImage = session('admin.image');
?>
<style>
.profile-imgs {
    width: 35px;          /* Adjust size as needed */
    height: 35px;         /* Ensure the height and width are the same */
    object-fit: cover;    /* Ensures the image fits without distortion */
    border-radius: 50%;   /* Makes the image circular */
    border: 2px solid #ddd; /* Optional: Add a border around the image */
}


@media (max-width: 768px) {
    .profile-imgs {
        width: 30px;
        height: 30px;
    }
}

@media (max-width: 480px) {
    .profile-imgs {
        width: 25px;
        height: 25px;
    }
}

</style>
<div class="main">
    <nav class="navbar navbar-expand-lg navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ms-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="indicator">4</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown">
                        <li><h6 class="dropdown-header">4 New Notifications</h6></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="text-danger me-2" data-feather="alert-circle"></i> Update completed
                                <small class="text-muted d-block">30m ago - Restart server 12 to complete update.</small>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="text-primary me-2" data-feather="home"></i> Login from 192.186.1.8
                                <small class="text-muted d-block">5h ago</small>
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#"><small>Show all notifications</small></a></li>
                    </ul>
                </li>
               <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <!-- Profile Image -->
    <img src="{{ asset('storage/app/public/assets/website/fav.svg')}}" 
        class="avatar profile-imgs rounded-circle me-1" 
        alt="The book door" />
    <!-- User Name -->
    <span class="text-dark">The book door</span>
</a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profiles') }}">
                            <i class="align-middle me-1" data-feather="user"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.signOut') }}">Log out</a>
                    </li>
    </ul>
</li>

            </ul>
        </div>
    </nav>

    <!-- Alerts -->
    
<!-- Scripts and Styles -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- -<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert-dismissible').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
