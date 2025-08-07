<!doctype html>

<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Book door</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="title" content="The Book Door - Your Gateway to Knowledge">
<meta name="description" content="Explore a wide range of books, plans, and subscriptions at The Book Door. Discover your next great read today!">
<meta name="keywords" content="books, online library, book subscription, reading plans, The Book Door, ebooks">

    <link rel="icon" href="{{ asset('storage/app/public/assets/website/fav.svg')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/assets/website/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/assets/website/css/animation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/assets/website/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/assets/website/css/responsive.css')}}">
    
<style>
.profile-image {
    width: 36px;               /* Width for the image */
    height: 36px;              /* Height for the image */
    border-radius: 50%;        /* Makes the image round */
    object-fit: cover;         /* Ensures the image covers the area */
    margin-right: 8px;         /* Space between image and username */
}
.nav-link.dropdown-toggle {
    /* display:flex; */
    align-items: center;
}
.login-margin {
    margin-left:5px; /* or whatever space looks right */
}



/* Optional: Hover effect for the dropdown toggle */
.nav-link.dropdown-toggle:hover {
    background-color: rgba(0, 0, 0, 0.05);  /* Light gray background on hover */
    border-radius: 4px;
}
/* Dropdown menu styling for the items */
.dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
}
.dropdown-menu .dropdown-item i {
    margin-right: 6px;  /* Adds space between the icon and the text */
}
/* Base button style */
.btn-login-custom {
    display: flex;
    align-items: center;     /* Vertical center */
    justify-content: center; /* Horizontal center */

    height: 44px;
    padding: 0 25px;
    font-size: 15px;
    font-weight: 500;
    border: none;
    border-radius: 10px;
    color: var(--white);
    background: var(--blue);
    text-align: center;
    white-space: nowrap;
}

/* Small screens (phones) */
@media (max-width: 576px) {
    .btn-login-custom {
        width: 100%;
        padding: 12px 20px;
        font-size: 14px;
        line-height: 20px;
        display: block;
    }
}

/* Medium devices (tablets) */
@media (min-width: 577px) and (max-width: 768px) {
    .btn-login-custom {
        width: auto;
        padding: 10px 22px;
        font-size: 15px;
    }
}

/* Large devices (laptops/desktops) */
@media (min-width: 769px) {
    .btn-login-custom {
        width: auto;
        padding: 10px 25px;
    }
}


.head-search-box  form{
    display: flex;
    align-items: center;
}
.nav-link.active {
    font-weight: bold;
    color: #fff !important;
    background-color: #0d6efd !important;
    border-radius: 5px;
    padding: 5px 10px;
}
.wishlist-container {
    position: relative; /* Allows proper positioning of the badge relative to the heart icon */
    display: inline-block; /* Keeps the icon and badge inline */
}

.wishlist-container .wishlist-count {
    position: absolute; /* Positions the badge relative to the container */
    bottom: -5px; /* Adjusts the position below the heart icon */
    left: 50%; /* Centers horizontally below the icon */
    transform: translateX(-50%); /* Centers the badge horizontally */
    background-color: #62c6bf; /* Red background */
    color: white; /* White text */
    padding: 5px; /* Space around the text */
    border-radius: 50%; /* Makes the badge circular */
    font-size: 12px; /* Adjusts the text size */
    line-height: 1; /* Ensures proper text alignment */
    width: 20px; /* Fixed width for the badge */
    height: 20px; /* Fixed height for the badge */
    display: flex; /* Makes the badge a flexbox container */
    justify-content: center; /* Centers the text horizontally */
    align-items: center; /* Centers the text vertically */
    border: 2px solid white; /* Optional border */
}
/* Style for the shopping cart link */
.shopping-cart-link {
    display: inline-flex; /* Align items horizontally */
    align-items: center; /* Vertically align the icon, cart count, and text */
    text-decoration: none; /* Remove underline from the link */
    color: #333; /* Default text color */
    font-size: 16px; /* Font size for the text */
    font-weight: 500; /* Slightly bold text for better visibility */
    gap: 8px; /* Add space between the elements */
    position: relative; /* To position the cart count badge */
}

/* Shopping cart icon style */
.shopping-cart-link i {
    font-size: 20px; /* Adjust the size of the icon */
    color: #333; /* Icon color */
}

/* Cart count badge */
.cartcount {
    display: inline-block;
    background-color: #62c6bf; /* Badge color */
    color: white; /* Text color inside the badge */
    font-size: 12px; /* Text size */
    font-weight: bold; /* Bold text */
    padding: 2px 6px; /* Space inside the badge */
    border-radius: 50%; /* Circular badge */
    min-width: 18px; /* Ensure it's round, even with single digits */
    text-align: center; /* Center the number in the badge */
    position: absolute; /* Position the badge */
    top: -5px; /* Adjust vertically */
    left: 20px; /* Adjust horizontally relative to the icon */
    line-height: 1; /* Prevent vertical stretching */
}

/* On hover */
.shopping-cart-link:hover {
    color: #007bff; /* Change text and icon color on hover */
}

.shopping-cart-link:hover i {
    color: #007bff; /* Change icon color on hover */
}
#globalLoader {
    display: none; /* Hide initially */
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
    z-index: 9999;
}

.loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db; /* Blue color */
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


</style>  
</head>
  <body>
 <div id="globalLoader" style="display:none;">
    <div class="loader"></div>
</div>



    <?php
use Illuminate\Support\Facades\Auth;

$userId = Auth::id(); // Get the authenticated user's ID

$wishlistCount = DB::table('wishlists')
    ->join('products', 'wishlists.product_id', '=', 'products.product_id')  // Join with products table
    ->where('wishlists.user_id', $userId)  // Filter by user ID
    ->where('products.status', 1)  // Only count products with status 1 (active)
    ->count();
 // Get the count of wishlists for the user
$cartcount = DB::table('cart')
    ->join('products', 'cart.product_sku', '=', 'products.sku')
    ->where('cart.user_id', $userId)
    ->where('products.quantity', '>', 0)
    ->whereNull('cart.order_id')
    ->where('products.status', 1)  // Ensure product status is 1
    ->count();
?> 
      @include('Flash')
<header>
  <section class="top-header">
   <div class="container-fluid">
    <div class="top-header-inner">
     <div class="email-phone-box">
      <ul>
       <li>
        <a href="tel:+91 8386992953">
         <i class="ti ti-phone-call"></i> 
         <span>+91 8386992953</span>
        </a>
       </li>  
       <!--<li>-->
       <!-- <a href="mailto:Contact@moralizer.com">-->
       <!--  <i class="ti ti-mail"></i>-->
       <!--  <span>Contact@moralizer.com</span>-->
       <!-- </a>-->
       <!--</li>  -->
      </ul>
     </div>  
     <div class="shipping-payment-support-box">
      <ul>
       <li>
        <a href="javascript:;">
         <i><img src="{{ asset('/storage/app/public/assets/website/images/icon01.png')}}" alt="icon"/></i> 
         <span>{{ __('messages.shipping') }}</span>
        </a> 
       </li>  
       <li>
        <a href="javascript:;">
         <i><img src="{{ asset('/storage/app/public/assets/website/images/icon02.png')}}" alt="icon"/></i> 
         <span>{{ __('messages.payment') }}</span>
        </a> 
       </li>  
       <li>
        <a href="javascript:>">
         <i><img src="{{ asset('/storage/app/public/assets/website/images/icon03.png')}}" alt="icon"/></i> 
         <span>{{ __('messages.support') }}</span>
        </a> 
       </li>  
      </ul>
     </div>
    </div>  
   </div> 
  </section>
  <section class="mid-header">
   <div class="container-fluid">
    <div class="mid-header-inner">
     <div class="logo">
      <a href="{{route('website.index')}}"><img src="https://thebookdoor.in/storage/app/public/banners/web/2qt5RJJyhVp4ZJcd7lq4Z5DOT1nkuwO7DKYpWItz.png" alt="logo"/></a> 
     </div> 
      <div class="header-search-box">
       <div class="head-search-box">
         <form action="/search" method="get">
        <input type="text" class="form-control" name="query" placeholder="{{__('messages.search_placeholder')}}" oninput="this.value = this.value.trimStart()" maxlength="256"/>
        <button class="search-btn"><i class="ti ti-search"></i></button>
        </form>
       </div>
      </div> 
     <div class="mid-head-right">
      <div class="wishlist-cart-box">
       <a href="{{route('website.wishlist')}}">
       @if($wishlistCount > 0)
    <div class="wishlist-container">
        <i class="ti ti-heart"style="background-color: #62c6bf;color:white;"></i>
        <span class="wishlist-count mt-6">{{$wishlistCount}}</span>
    </div>
@else
    <i class="ti ti-heart"></i>
@endif

            <span>{{ __('messages.wishlist') }}</span>
       </a> 
       <a href="{{route('website.mycart')}}" class="shopping-cart-link">
    <i class="ti ti-shopping-cart"></i>
    @if($cartcount > 0)
    <span class="cartcount">{{$cartcount}}</span>
    
    @endif
    <span>{{__('messages.shopping_cart')}}</span>
</a>

      </div> 
     @php
    $currentLang = app()->getLocale();

    $currentLang = substr($currentLang, 0, 2); // Extract first 2 characters for 'en' and 'ar', 'cku' remains unchanged

    // Special case for Kurdish (cku) since it's 3 letters
    if (strpos(app()->getLocale(), 'cku') === 0) {
        $currentLang = 'cku';
    }

    $languages = [
        'en' => 'English',
       
    ];

    
@endphp


      {{--<div class="lang-box">
        <div class="dropdown">
         <button class="dropdown-toggle" type="button" aria-expanded="false">
          <i>
            @if($currentLang=='cku')    
          <img src="{{ asset('/storage/app/public/assets/website/images/flag_cku.png')}}" alt="flag"/>
          @elseif($currentLang=='en')
          <img src="https://thebookdoor.in/storage/app/public/banners/web/I74keQI0Zo9PnbV2KwbcZYQXe32scVVpy4SyYrmw.jpg" alt="flag"/>
          @else
          <img src="{{ asset('/storage/app/public/assets/website/images/flag_ar.png')}}" alt="flag"/>
          @endif
        
        </i>  
          <span>{{ $languages[$currentLang] }}</span> 
         </button>
       

<ul class="dropdown-menu">
    <!-- Show Current Language at the Top -->
    <li><a class="dropdown-item active" href="#">{{ $languages[$currentLang] }}</a></li>
    <li><hr class="dropdown-divider"></li>
    
    <!-- List Other Languages -->
    @foreach ($languages as $lang => $language)
        @if ($lang !== $currentLang)
            <li><a class="dropdown-item" href="{{ route('changeLang', $lang) }}">{{ $language }}</a></li>
        @endif
    @endforeach
</ul>



        </div>
      </div>--}}
  @if(Auth::check())
    <div class="profile mt-2">
            <li class="nav-item dropdown" style="list-style-type: none; text-decoration: none;">
    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg" 
             class="avatar img-fluid rounded-circle me-1 profile-image" alt="Profile Image" />
        <span class="text-dark">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
        <li><a class="dropdown-item" href="{{ route('website.myprofile') }}"><i class="align-middle me-1" data-feather="user"></i> Profile</a></li>
       <a class="dropdown-item" href="#" id="logout-btn">{{ __('messages.logout') }}</a>

<form id="logout-form" action="{{ route('website.signOut') }}" method="GET" style="display: none;">
    @csrf
</form>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('logout-btn').addEventListener('click', function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, log me out!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
});
</script>

    </ul>
</li>     
@else
    <div class="text-center">
        <a href="{{ route('website.signin') }}" class="btn-login-custom mt-1 login-margin">{{ __('messages.login') }}</a>  
    </div>
@endif
  </div>
    </div>
   </div> 
  </section>
  <section class="bottom-header">
   <div class="navbar navbar-expand-lg">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
   <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('website.brand') ? 'active' : '' }}" 
           href="{{route('website.index')}}">
           Home
        </a>
    </li>
   
    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('website.blog') ? 'active' : '' }}" 
           href="{{ route('website.blog') }}">
           Blogs
        </a>
    </li>
  
    {{--<li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('website.librarylist') ? 'active' : '' }}" 
           href="{{ route('website.librarylist') }}">
         Find Me
        </a>
    </li>--}}
  
    
<!--  <li class="nav-item dropdown">-->
<!--    <a style="color:blue;" class="nav-link {{ Request::is('librarylist') ? 'active' : '' }}" -->
<!--       href="{{ route('website.librarylist') }}">-->
<!--        Find Me-->
<!--    </a>-->
<!--</li>-->

  <li class="nav-item dropdown">
    <a style="color:blue;" class="nav-link {{ Request::is('tbdclub') ? 'active' : '' }}" 
       href="{{ route('website.tbdclub') }}">
         TBD CLUB
    </a>
</li>



    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('website.aboutus') ? 'active' : '' }}" 
           href="{{ route('website.aboutus') }}">
            About us
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('categoryproductlist/3') ? 'active' : '' }}" 
           href="{{ route('website.privacypolicy')}}">
        Privacy policy
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('website.faq') ? 'active' : '' }}" 
           href="{{ route('website.faq') }}">
            FAQ
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('website.contactus') ? 'active' : '' }}" 
           href="{{ route('website.contactus') }}">
           Contactus
        </a>
    </li>
</ul>

</div>
   </div> 
  </section>
</header>
