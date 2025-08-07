<?php
use Illuminate\Support\Facades\Route;
$routeName = Route::currentRouteName();
$adminName = session('warehouse.name');
$adminImage = session('warehouse.image');
?>

<!-- jQuery (already included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS & Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="header">    
    <div class="header-content clearfix">
        <!-- Navigation Control (Hamburger menu for mobile) -->
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>

        <!-- Right Section (User Profile) -->
        <div class="header-right">
            <ul class="clearfix">
                <!-- User Profile Dropdown -->
                <li class="icons dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                       role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ url('public/storage/' . Auth::guard('warehouse')->user()->image) }}" 
                             class="avatar img-fluid rounded-circle me-2" 
                             alt="{{ Auth::guard('warehouse')->user()->name }}" width="40" height="40" />
                        <span class="text-dark fw-bold">{{ Auth::guard('warehouse')->user()->name }}</span>
                    </a>
                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end shadow fade" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('warehouse.profiles') }}">
                                <i class="icon-user me-2"></i> <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" 
                               onclick="confirmLogout(event, '{{ route('warehouse.signOut') }}')">
                                <i class="icon-key me-2"></i> <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- SweetAlert2 for Logout Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout(event, logoutUrl) {
    event.preventDefault(); // Prevent default navigation

    Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out of your account.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, log me out"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = logoutUrl;
        }
    });
}

// Ensure Bootstrap dropdowns work correctly
document.addEventListener("DOMContentLoaded", function() {
    let dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(dropdown => {
        new bootstrap.Dropdown(dropdown);
    });
});
</script>
