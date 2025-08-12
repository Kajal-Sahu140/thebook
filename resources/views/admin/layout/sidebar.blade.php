<?php
use Illuminate\Support\Facades\Route;

// Helper function to check if the current route is active
function isActive($slug) {
   
    // Get the current route name
    $currentRoute = Route::currentRouteName();

    // Check if the route name is dynamic (e.g. admin.pages.edit) and if it's the same as the passed slug
    if ($currentRoute == 'admin.pages.edit') {
        // For dynamic routes like admin.pages.edit, check if the slug matches
        $currentSlug = request()->segment(3); // Get the 3rd segment of the URL (the page slug)
        return ($currentSlug == $slug) ? 'active' : '';
    }

    // For other static routes (like admin.users), check if the route matches
    return $currentRoute == $slug ? 'active' : '';
}
?>

<style>
    .sidebar-brand {
        text-decoration: none;
    }

    .sidebar-brand:hover {
        text-decoration: none;
    }

    .admin-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .sidebar-item.active > .sidebar-link {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
    }

    .sidebar-item.active.dashboard-active > .sidebar-link {
        background-color: #28a745;
        color: white;
        border-radius: 5px;
    }

    .sidebar-item > .sidebar-link:hover {
        background-color: #0056b3;
        color: white;
        border-radius: 5px;
    }
</style>

<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <!-- Admin Info -->
            <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('storage/app/public/assets/website/fav.svg')}}" class="admin-image" alt="Admin Image"/>
                <span class="align-middle">The book door</span>
            </a>
            
            <ul class="sidebar-nav">
                <li class="sidebar-header">Dashboard</li>

                <li class="sidebar-item {{ isActive('admin.dashboard') }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.profiles') }}">
                    <a class="sidebar-link" href="{{ route('admin.profiles') }}">
                        <i class="align-middle" data-feather="user"></i>
                        <span class="align-middle">Profile</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.users') }}">
                    <a class="sidebar-link" href="{{ route('admin.users') }}">
                        <i class="align-middle" data-feather="users"></i>
                        <span class="align-middle">Customer Management</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.sendMultipleWhatsget') }}">
                    <a class="sidebar-link" href="{{ route('admin.sendMultipleWhatsget') }}">
                        <i class="align-middle" data-feather="users"></i>
                        <span class="align-middle">Whatsup message</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.brand') }}">
                    <a class="sidebar-link" href="{{ route('admin.brand') }}">
                        <i class="align-middle" data-feather="briefcase"></i>
                        <span class="align-middle">Brand Management</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.warehouse') }}">
                    <a class="sidebar-link" href="{{ route('admin.warehouse') }}">
                        <i class="align-middle" data-feather="box"></i>
                        <span class="align-middle">Warehouse Management</span>
                    </a>
                </li>

              <li class="sidebar-item {{ isActive('admin.category') }} {{ isActive('admin.subcategory') }} {{isActive('admin.category.edit')}}">
    <a class="sidebar-link" href="{{ route('admin.category') }}">
        <i class="align-middle" data-feather="list"></i>
        <span class="align-middle">Category Management</span>
    </a>
</li>

<li class="sidebar-item {{ isActive('admin.library.index') }}  {{isActive('admin.library.edit')}}">
    <a class="sidebar-link" href="{{ route('admin.library.index') }}">
        <i class="align-middle" data-feather="list"></i>
        <span class="align-middle">library Management</span>
    </a>
</li>



<li class="sidebar-item {{ isActive('admin.plan.index') || isActive('admin.plan.edit') || isActive('admin.plan.userplanindex') ? 'active' : '' }}">
    <a data-toggle="collapse" href="#planDropdownitem"
       class="sidebar-link {{ isActive('admin.plan.index') || isActive('admin.plan.edit') || isActive('admin.plan.userplanindex') ? '' : 'collapsed' }}"
       aria-expanded="{{ isActive('admin.plan.index') || isActive('admin.plan.edit') || isActive('admin.plan.userplanindex') ? 'true' : 'false' }}">
        <i class="align-middle" data-feather="layers"></i>
        <span class="align-middle">Plan</span>
    </a>
    <ul id="planDropdownitem" class="sidebar-dropdown list-unstyled collapse {{ isActive('admin.plan.index') || isActive('admin.plan.edit') || isActive('admin.plan.userplanindex') ? 'show' : '' }}">
        <li class="sidebar-item {{ isActive('admin.plan.index') }}">
            <a class="sidebar-link" href="{{ route('admin.plan.index') }}">
                <i class="align-middle" data-feather="list"></i>
                <span class="align-middle">Plan Module</span>
            </a>
        </li>
        <li class="sidebar-item {{ isActive('admin.plan.userplanindex') }}">
            <a class="sidebar-link" href="{{ route('admin.plan.userplanindex') }}">
                <i class="align-middle" data-feather="edit"></i>
                <span class="align-middle">Plan User</span>
            </a>
        </li>
    </ul>
</li>



                <li class="sidebar-item {{ isActive('admin.banner') }}">
                    <a class="sidebar-link" href="{{ route('admin.banner') }}">
                        <i class="align-middle" data-feather="image"></i>
                        <span class="align-middle">Banner Management</span>
                    </a>
                </li>

               <li class="sidebar-item {{ isActive('admin.product') }}">
    <a class="sidebar-link" href="{{ route('admin.product') }}">
       <i class="align-middle" data-feather="shopping-bag"></i>
        <span class="align-middle">Inventory Management</span>
    </a>
</li>


                <li class="sidebar-item {{ isActive('admin.coupon') }}">
                    <a class="sidebar-link" href="{{ route('admin.coupon') }}">
                        <i class="align-middle" data-feather="tag"></i>
                        <span class="align-middle">Coupon Management</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.order') }}">
                    <a class="sidebar-link" href="{{ route('admin.order') }}">
                        <i class="align-middle" data-feather="shopping-cart"></i>
                        <span class="align-middle">Order Management</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.rating') }}">
                    <a class="sidebar-link" href="{{ route('admin.rating') }}">
                        <i class="align-middle" data-feather="star"></i>
                        <span class="align-middle">Rating and Review</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.return') }}">
                    <a class="sidebar-link" href="{{ route('admin.return') }}">
                        <i class="align-middle" data-feather="repeat"></i>
                        <span class="align-middle">Return and Refund</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.productoffer') }}">
                    <a class="sidebar-link" href="{{ route('admin.productoffer') }}">
                        <i class="align-middle" data-feather="gift"></i>
                        <span class="align-middle">Product Offer Management</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.blog') }}">
                    <a class="sidebar-link" href="{{ route('admin.blog') }}">
                        <i class="align-middle" data-feather="book-open"></i>
                        <span class="align-middle">Blog Management</span>
                    </a>
                </li>

                
               <li class="sidebar-item {{ isActive('admin.transaction') }}">
    <a class="sidebar-link" href="{{ route('admin.transaction') }}">
        <i class="align-middle" data-feather="credit-card"></i>
        <span class="align-middle">Transaction</span>
    </a>
</li>


                <li class="sidebar-header">Pages</li>

                <li class="sidebar-item {{ request()->routeIs('admin.pages.edit') && request()->route('slug') == 'about-us-home-page' ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('admin.pages.edit', 'about-us-home-page') }}">
        <i class="align-middle" data-feather="file-text"></i>
        <span class="align-middle">About Us</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('admin.pages.edit') && request()->route('slug') == 'privacy_policy' ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('admin.pages.edit', 'privacy_policy') }}">
        <i class="align-middle" data-feather="lock"></i>
        <span class="align-middle">Privacy Policy</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('admin.pages.edit') && request()->route('slug') == 'terms-and-conditions' ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('admin.pages.edit', 'terms-and-conditions') }}">
        <i class="align-middle" data-feather="clipboard"></i>
        <span class="align-middle">Terms & Conditions</span>
    </a>
</li>


                <li class="sidebar-item {{ isActive('admin.contactus') }}">
                    <a class="sidebar-link" href="{{ route('admin.contactus') }}">
                        <i class="align-middle" data-feather="mail"></i>
                        <span class="align-middle">Contact Us</span>
                    </a>
                </li>

                <li class="sidebar-item {{ isActive('admin.faq') }}">
                    <a class="sidebar-link" href="{{ route('admin.faq') }}">
                        <i class="align-middle" data-feather="help-circle"></i>
                        <span class="align-middle">FAQs</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
