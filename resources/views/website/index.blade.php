
@include('website.header')
<?php $currentLang = app()->getLocale(); ?>
<!--------------------------------------------------------->
<style>
   .sold-out-overlay {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent overlay */
   color: #fff;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 18px;
   font-weight: bold;
   z-index: 10;
   text-transform: uppercase;
   }
   .owl-carousel .item {
  margin: 5px;
}
   .product-like-heart {
   position: absolute;
   top: 10px;
   right: 10px;
   z-index: 15; /* Ensure it stays above the overlay */
   cursor: pointer;
   }
   
   /*.brand-img {*/
   width: 150px;        /* or whatever fixed width you want */
   height: 100px;       /* fixed height */
   object-fit: contain; /* keep full image inside the box */
   /*    display: block;*/
   /*    margin: 0 auto;*/
   /*}*/
   
   
   .amazing-deals-section .btn-primary {
    padding: 10px 25px;
    font-size: 16px;
    border-radius: 6px;
    display: inline-block;
    margin-top: 20px;
}

.amazing-deals-section .text-center {
    width: 100%;
    text-align: center;
}

.amazing-deals-section .mt-4 {
    margin-top: 2rem !important;
}




</style>
<style>
.categories-list ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between; /* Space between items */
    padding: 0;
    margin: 0;
    list-style: none;
}

.categories-list ul li {
    background: #fff;
    border-radius: 10px;
    padding: 20px 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: 0.3s;
    flex: 0 0 calc(25% - 10px); /* 4 cards per row with gaps */
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 300px;
}

/* Card Hover */
.categories-list ul li:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Figure and Image */
.categories-list ul li figure {
    width: 100%;
    height: 180px;
    margin: 0 0 10px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.categories-list ul li figure img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Figcaption */
.categories-list ul li figcaption {
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    margin-top: auto;
}

/* Responsive Settings */
@media (max-width: 992px) {
    .categories-list ul li {
        flex: 0 0 calc(33.333% - 15px); /* 3 per row in tablets */
    }
}
@media (max-width: 768px) {
    .categories-list ul li {
        flex: 0 0 calc(50% - 15px); /* 2 per row in mobile */
    }
}
@media (max-width: 576px) {
    .categories-list ul li {
        flex: 0 0 100%; /* 1 per row on very small screens */
    }
}
.stationary-grid {
   display: flex;
   flex-wrap: wrap;
   justify-content: center;
   gap: 15px;
}

.stationary-item {
   padding: 12px 20px;
   border: 1px solid #ccc;
   border-radius: 10px;
   font-weight: bold; /* <-- makes text bold */
   font-size: 14px;
   background-color: #e0e0e0; /* <-- light grey background */
   color: #000; /* darker text for contrast */
   text-decoration: none;
   min-width: 180px;
   text-align: center;
   transition: all 0.3s ease;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.stationary-item:hover {
   background-color: #d5d5d5; /* slightly darker on hover */
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.stationary-section {
   background-color: #f0f0f0;
   padding: 40px 0;
}

@media (max-width: 600px) {
   .stationary-item {
      min-width: 130px;
      font-size: 13px;
   }
}


</style>


<style>
    .brand-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 20px;
        padding: 0;
        list-style: none;
        margin: 0 auto;
        max-width: 1200px;
    }

    .brand-card {
        background: #fff;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .brand-card:hover {
        transform: translateY(-4px);
    }
     .brand-card p {
            font-size: 20px;
        }

    .brand-img {
        width: 100%;
        height: 350px;
        object-fit: contain;
    }

    @media (max-width: 576px) {
        .brand-img {
            height: 80px;
        }
          
    }

    /* Prevent horizontal scroll on the whole page */
body {
    overflow-x: hidden;
}

/* Container Fluid should not exceed viewport width */
.container-fluid {
    padding-left: 0;
    padding-right: 0;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    overflow: hidden;
}

/* Ensure banner section doesn't exceed width */
.banner-add-section {
    padding: 0 !important;
    overflow: hidden;
}

/* Make image fully responsive */
.banner-add-section img {
    width: 100%;
    max-width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
    margin: 0 auto;
}

</style>


<div class="site-bg">
   <!-- <section class="banner-section">-->
   <!--<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">-->
   <!--   <div class="carousel-indicators">-->
   <!--      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>-->
   <!--      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>-->
   <!--      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>-->
   <!--   </div>-->
   <!--   <div class="carousel-inner">-->
   <!--      <div class="carousel-item active" data-bs-interval="10000">-->
   <!--         <img src="https://thebookdoor.in/storage/app/public/banners/web/kKNfQ4Tnkh4MskZWqXz3HMn16Uz7FdrRug3RCwzF.jpg" class="d-block w-100" alt="...">-->
   <!--         <div class="carousel-caption d-none d-md-block">-->
   <!--            {{--<h5>First slide label</h5>-->
   <!--            <p>Some representative placeholder content for the first slide.</p>--}}-->
   <!--         </div>-->
   <!--      </div>-->
   <!--      <div class="carousel-item" data-bs-interval="2000">-->
   <!--         <img src="https://thebookdoor.in/storage/app/public/banners/web/kKNfQ4Tnkh4MskZWqXz3HMn16Uz7FdrRug3RCwzF.jpg" class="d-block w-100" alt="...">-->
   <!--         <div class="carousel-caption d-none d-md-block">-->
   <!--            {{--<h5>Second slide label</h5>-->
   <!--            <p>Some representative placeholder content for the second slide.</p>--}}-->
   <!--         </div>-->
   <!--      </div>-->
   <!--      <div class="carousel-item">-->
   <!--         <img src="https://thebookdoor.in/storage/app/public/banners/web/kKNfQ4Tnkh4MskZWqXz3HMn16Uz7FdrRug3RCwzF.jpg" class="d-block w-100" alt="...">-->
   <!--         <div class="carousel-caption d-none d-md-block">-->
   <!--            {{--<h5>Third slide label</h5>-->
   <!--            <p>Some representative placeholder content for the third slide.</p>--}}-->
   <!--         </div>-->
   <!--      </div>-->
   <!--   </div>-->
   <!--   <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">-->
   <!--   <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
   <!--   <span class="visually-hidden">Previous</span>-->
   <!--   </button>-->
   <!--   <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">-->
   <!--   <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
   <!--   <span class="visually-hidden">Next</span>-->
   <!--   </button>-->
   <!--</div>-->
   <!--</section>-->
   
   
   <section class="banner-section">
  <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      
      <!-- First slide (video) -->
      <div class="carousel-item active" data-bs-interval="2000">
        <video class="d-block w-100" autoplay muted loop playsinline>
          <source src="https://thebookdoor.in/storage/app/public/banners/web/qTtTZvBhqpWX0DtufIc1sDAyJX1Cw8ryPTlnAWAI.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
        <div class="carousel-caption d-none d-md-block">
          <!-- Optional caption -->
        </div>
      </div>

      <!-- Second slide (image) -->
      <div class="carousel-item" data-bs-interval="2000">
        <img src="https://thebookdoor.in/storage/app/public/banners/web/1QUgexT0M2P8X50upOCerdCCSkCK3Zmuqpmymg3p.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <!-- Optional caption -->
        </div>
      </div>

      <!-- Third slide (image) -->
      <div class="carousel-item">
        <img src="https://thebookdoor.in/storage/app/public/banners/web/GwuVNKjH9lGAb7oi7q9gg32Ofea5P99yVVzWWg7d.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <!-- Optional caption -->
        </div>
      </div>

    </div>
    <!--<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">-->
    <!--  <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
    <!--  <span class="visually-hidden">Previous</span>-->
    <!--</button>-->
    <!--<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">-->
    <!--  <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
    <!--  <span class="visually-hidden">Next</span>-->
    <!--</button>-->
  </div>
</section>

   
   {{--<section class="banner-section">
      <div class="owl-carousel owl-theme home-banner">
         @if($banner)
         @foreach($banner as $banner)
         <div class="item">
            @if($banner->click_status=='yes')
            <a href="{{$banner->banner_link }}">
               <img src="{{$banner->web_banner_image}}" alt="banner"/>
               <div class="slide-des-box">
                  <div class="container">
                     <div class="slide-des">
    <h2>{{$banner->title}}</h2>
                              <p>{{$banner->description}}</p>
                           @if($banner->banner_link)
                           <a href="{{$banner->banner_link}}" class="btn">Shop Now</a>
                           @endif -->
                     </div>
                  </div>
               </div>
            </a>
            @else
            <img src="{{$banner->web_banner_image}}" alt="banner"/>
            <div class="slide-des-box">
               <div class="container">
                  <div class="slide-des">
    <h2>{{$banner->title}}</h2>
                           <p>{{$banner->description}}</p>
                        @if($banner->banner_link)
                        <a href="{{$banner->banner_link}}" class="btn">Shop Now</a>
                        @endif -->
                  </div>
               </div>
            </div>
            @endif
         </div>
         @endforeach
         @else
         <div class="item">
            <img src="https://srv1742-files.hstgr.io/bc234e6a337549fd/files/public_html/public/storage/banner/tLohTvqyBjg6P9JJ0O2VgAfY416yXK6WNfYrbKIH.png" alt="banner"/>
            <div class="slide-des-box">
               <div class="container">
                  <div class="slide-des">
                     <h2>Exclusive Baby Deals: Shop & Save Today!</h2>
                     <p>Our exclusive deals make it easier than ever to stock up on everything your baby needs without breaking the bank. Shop now and enjoy big savings while supplies last!</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="item">
            <img src="https://srv1742-files.hstgr.io/bc234e6a337549fd/files/public_html/public/storage/banner/tLohTvqyBjg6P9JJ0O2VgAfY416yXK6WNfYrbKIH.png" alt="banner"/>
            <div class="slide-des-box">
               <div class="container">
                  <div class="slide-des">
                     <h2>Exclusive Baby Deals: Shop & Save Today!</h2>
                     <p>Our exclusive deals make it easier than ever to stock up on everything your baby needs without breaking the bank. Shop now and enjoy big savings while supplies last!</p>
                  </div>
               </div>
            </div>
         </div>
         @endif
      </div>
   </section>--}}
   
      <section class="amazing-deals-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>Popular books of this week</h2>
         </div>
         <div class="owl-carousel owl-theme amazing-deals-list">
            @if(!empty($letestproduct))
            @foreach($letestproduct as $prod)
            <div class="item">
               <div class="product-box">
                  @php
                  $isSoldOut = $prod->quantity <= 0; // Check if the product is sold out
                  $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100)); // Calculate discounted price
                  @endphp
                  <figure>
                     <a href="{{route('website.productdetail',['id'=>$prod->sku]) }}" 
                        class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                        <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />
                        @if($isSoldOut)
                        <div class="sold-out-overlay">Sold Out</div>
                        <!-- Overlay for sold out -->
                        @endif
                     </a>
                     <!-- Wishlist button remains clickable -->
                     <div class="product-like-heart" 
                        style="background-color: {{ $prod->is_wishlisted ? '#62c6bf' : '' }};" 
                        data-product-id="{{ $prod->product_id }}">
                        <i class="ti ti-heart"></i>
                     </div>
                  </figure>
                  <figcaption>
                     @if($currentLang == 'en')
                     <h4>{{ $prod->product_name }}</h4>
                     @elseif($currentLang == 'ar')
                     <h4>{{ $prod->product_name_ar }}</h4>
                     @elseif($currentLang == 'cku')
                     <h4>{{ $prod->product_name_cku }}</h4>
                     @else
                     <h4>{{ $prod->product_name }}</h4>
                     @endif
                     <span>{{ number_format($discountedPrice, 2) }}  RS.</span>
                  </figcaption>
               </div>
            </div>
            @endforeach
            @else
            <div class="item">
               <div class="product-box">
                  <a href="#">
                     <figure>
                        <img src="{{$newproduct->web_banner_image}}" alt="product"/>
                        <div class="product-like-heart"><i class="ti ti-heart"></i></div>
                     </figure>
                     <figcaption>
                        <h4>Explore Our Products</h4>
                        <span>$100</span>
                     </figcaption>
                  </a>
               </div>
            </div>
            @endif
         </div>
      </div>
   </section>
   
   
    {{--<section class="amazing-deals-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>Combo Box</h2>
         </div>
         <div class="owl-carousel owl-theme amazing-deals-list">
            @if(!empty($combo))
            @foreach($combo as $prod)
            <div class="item">
               <div class="product-box">
                  @php
                  $isSoldOut = $prod->quantity <= 0; // Check if the product is sold out
                  $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100)); // Calculate discounted price
                  @endphp
                  <figure>
                     <a href="{{route('website.productdetail',['id'=>$prod->sku]) }}" 
                        class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                        <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />
                        @if($isSoldOut)
                        <div class="sold-out-overlay">Sold Out</div>
                        <!-- Overlay for sold out -->
                        @endif
                     </a>
                     <!-- Wishlist button remains clickable -->
                     <div class="product-like-heart" 
                        style="background-color: {{ $prod->is_wishlisted ? '#62c6bf' : '' }};" 
                        data-product-id="{{ $prod->product_id }}">
                        <i class="ti ti-heart"></i>
                     </div>
                  </figure>
                  <figcaption>
                     @if($currentLang == 'en')
                     <h4>{{ $prod->product_name }}</h4>
                     @elseif($currentLang == 'ar')
                     <h4>{{ $prod->product_name_ar }}</h4>
                     @elseif($currentLang == 'cku')
                     <h4>{{ $prod->product_name_cku }}</h4>
                     @else
                     <h4>{{ $prod->product_name }}</h4>
                     @endif
                     <span>{{ number_format($discountedPrice, 2) }}  RS.</span>
                  </figcaption>
               </div>
            </div>
            @endforeach
           
            @endif
         </div>
      </div>
   </section>--}}
   
   
   
   <section class="stationary-section py-4">
   <div class="container text-center">
        <div class="section-head">
            <h2>Combo Box</h2>
         </div>
       
      
      
      <div class="stationary-grid">
         <a href="https://thebookdoor.in/branddetail/MzI=" class="stationary-item">Stationary Combo</a>
         <a href="https://thebookdoor.in/branddetail/MzI=" class="stationary-item">Stationary & Books Combo</a>
         <a href="https://thebookdoor.in/branddetail/MzI=" class="stationary-item">Similar Books Combo</a>
         <a href="https://thebookdoor.in/branddetail/MzI=" class="stationary-item">Hindi Combo</a>
         <a href="https://thebookdoor.in/branddetail/MzI=" class="stationary-item">English Combo</a>

      </div>
  
   </div>
</section>
   
   
   
   
   
   
   
   
<!--<section class="off-add-section section-padding">-->
<!--    <div class="container-fluid">-->
<!--          <div class="section-head">-->
<!--            <h2>Books & Stationary</h2>-->
<!--         </div>-->
<!--        <div class="off-add-list">-->
<!--            <ul class="brand-grid">-->
<!--                @foreach($brand as $brands)-->
<!--                <li class="brand-card">-->
<!--                    <a href="{{ route('website.branddetail', base64_encode($brands->id)) }}">-->
<!--                        <img src="{{ asset('storage/app/public/' . $brands->image) }}" class="brand-img" alt="{{ $brands->name }}">-->
<!--                    </a>-->
<!--                    <p><b>{{$brands->name}}</b></p>-->
<!--                </li>-->
<!--                @endforeach-->
<!--            </ul>-->

           
<!--        </div>-->
<!--    </div>-->
<!--</section>-->

   
      {{--<section class="amazing-deals-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>Books</h2>
         </div>
         <div class="owl-carousel owl-theme amazing-deals-list">
            @if(!empty($brand))
            @foreach($brand as $prod)
            <div class="item">
               <div class="product-box">
                  @php
                  $isSoldOut = $prod->quantity <= 0; // Check if the product is sold out
                  $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100)); // Calculate discounted price
                  @endphp
                  <figure>
                     <a href="{{ route('website.productdetail',['id'=>$prod->sku]) }}" 
                        class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                        <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />
                        @if($isSoldOut)
                        <div class="sold-out-overlay">Sold Out</div>
                        <!-- Overlay for sold out -->
                        @endif
                     </a>
                     <!-- Wishlist button remains clickable -->
                     <div class="product-like-heart" 
                        style="background-color: {{ $prod->is_wishlisted ? '#62c6bf' : '' }};" 
                        data-product-id="{{ $prod->product_id }}">
                        <i class="ti ti-heart"></i>
                     </div>
                  </figure>
                  <figcaption>
                     @if($currentLang == 'en')
                     <h4>{{ $prod->product_name }}</h4>
                     @elseif($currentLang == 'ar')
                     <h4>{{ $prod->product_name_ar }}</h4>
                     @elseif($currentLang == 'cku')
                     <h4>{{ $prod->product_name_cku }}</h4>
                     @else
                     <h4>{{ $prod->product_name }}</h4>
                     @endif
                     <span>{{ number_format($discountedPrice, 2) }} Rs. </span>
                  </figcaption>
               </div>
            </div>
            @endforeach
           
           
            @endif
         </div>
        
      </div>
       
   </section>
  <div class="text-center my-4">
   <a href="{{ route('website.branddetail', base64_encode($prod->brand->id)) }}" class="btn btn-primary view-all-btn">
      View All Books
   </a>
</div>--}}

{{--<section class="amazing-deals-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>Library</h2>
         </div>
         <div class="owl-carousel owl-theme amazing-deals-list">
            @if(!empty( $library))
            @foreach( $library as $prod)
            <div class="item">
               <div class="product-box">
                
                  <figure>
                     <a href="{{ route('website.librarydetail',['id'=>$prod->id]) }}" 
                        class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                        <img src="{{ $prod->image ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />
                       
                     </a>
                     <!-- Wishlist button remains clickable -->
                    
                  </figure>
                  <figcaption>
                    
                     <h4>{{ $prod->name }}</h4>
                    
                    
                  </figcaption>
               </div>
            </div>
            @endforeach
           
           
            @endif
         </div>
        
      </div>
       
   </section>--}}
   


   <section class="categories-section">
       
       
      <div class="container-fluid  mt-4">
         <div class="section-head">
            <h2>{{__('messages.categories')}}</h2>
         </div>
         <div class="categories-list">
            <ul>
               @if($category)
               @foreach($category as $cat)
               <li>
                  <a href="{{ route('website.categoryproductlist', ['id' => $cat->id]) }}">
                     <figure>
                        @if($currentLang == 'en')
                        <img src="{{ asset($cat->image) }}" alt="Categories"/>
                        @elseif($currentLang == 'ar')
                        <img src="{{ $cat->image_ar }}" alt="الفئات"/>
                        @elseif($currentLang == 'cku')
                        <img src="{{ $cat->image_cku}}" alt="پۆلەکان"/>
                        @else
                        <img src="{{ asset($cat->image) }}" alt="Categories"/>
                        @endif
                     </figure>
                     <figcaption>
                        @if($currentLang == 'en')
                        {{ $cat->name }}
                        @elseif($currentLang == 'ar')
                        {{ $cat->name_ar }}
                        @elseif($currentLang == 'cku')
                        {{ $cat->name_cku }}
                        @else
                        {{ $cat->name }}
                        @endif
                     </figcaption>
                  </a>
               </li>
               @endforeach
               @else
               <li>
                  <a href="javascript:;">
                     <figure><img src="{{ asset('/storage/assets/website/images/cat-img01.png')}}" alt="Categories"/></figure>
                     <figcaption>Clothing</figcaption>
                  </a>
               </li>
               <li>
                  <a href="javascript:;">
                     <figure><img src="{{ asset('/storage/assets/website/images/cat-img02.png')}}" alt="Categories"/></figure>
                     <figcaption>Toys</figcaption>
                  </a>
               </li>
               <li>
                  <a href="javascript:;">
                     <figure><img src="{{ asset('/storage/assets/website/images/cat-img03.png')}}" alt="Categories"/></figure>
                     <figcaption>Skincare</figcaption>
                  </a>
               </li>
               <li>
                  <a href="javascript:;">
                     <figure><img src="{{ asset('/storage/assets/website/images/cat-img04.png')}}" alt="Categories"/></figure>
                     <figcaption>Essentials</figcaption>
                  </a>
               </li>
               <li>
                  <a href="javascript:;">
                     <figure><img src="{{ asset('/storage/assets/website/images/cat-img05.png')}}" alt="Categories"/></figure>
                     <figcaption>Safety</figcaption>
                  </a>
               </li>
               @endif
            </ul>
         </div>
      </div>
   </section>
   <!--<section class="amazing-deals-section section-padding">-->
   <!--   <div class="container-fluid">-->
   <!--      <div class="section-head">-->
   <!--         <h2>{{__('messages.amazing_deals')}}</h2>-->
   <!--      </div>-->
   <!--      <div class="owl-carousel owl-theme amazing-deals-list">-->
   <!--         @if(!empty($letestproduct))-->
   <!--         @foreach($letestproduct as $prod)-->
   <!--         <div class="item">-->
   <!--            <div class="product-box">-->
   <!--               @php-->
   <!--               $isSoldOut = $prod->quantity <= 0; // Check if the product is sold out-->
   <!--               $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100)); // Calculate discounted price-->
   <!--               @endphp-->
   <!--               <figure>-->
   <!--                  <a href="{{route('website.productdetail',['id'=>$prod->sku]) }}" -->
   <!--                     class="{{ $isSoldOut ? 'disabled-link' : '' }}">-->
   <!--                     <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />-->
   <!--                     @if($isSoldOut)-->
   <!--                     <div class="sold-out-overlay">Sold Out</div>-->
                        <!-- Overlay for sold out -->
   <!--                     @endif-->
   <!--                  </a>-->
                     <!-- Wishlist button remains clickable -->
   <!--                  <div class="product-like-heart" -->
   <!--                     style="background-color: {{ $prod->is_wishlisted ? '#62c6bf' : '' }};" -->
   <!--                     data-product-id="{{ $prod->product_id }}">-->
   <!--                     <i class="ti ti-heart"></i>-->
   <!--                  </div>-->
   <!--               </figure>-->
   <!--               <figcaption>-->
   <!--                  @if($currentLang == 'en')-->
   <!--                  <h4>{{ $prod->product_name }}</h4>-->
   <!--                  @elseif($currentLang == 'ar')-->
   <!--                  <h4>{{ $prod->product_name_ar }}</h4>-->
   <!--                  @elseif($currentLang == 'cku')-->
   <!--                  <h4>{{ $prod->product_name_cku }}</h4>-->
   <!--                  @else-->
   <!--                  <h4>{{ $prod->product_name }}</h4>-->
   <!--                  @endif-->
   <!--                  <span>{{ number_format($discountedPrice, 2) }}  RS.</span>-->
   <!--               </figcaption>-->
   <!--            </div>-->
   <!--         </div>-->
   <!--         @endforeach-->
   <!--         @else-->
   <!--         <div class="item">-->
   <!--            <div class="product-box">-->
   <!--               <a href="#">-->
   <!--                  <figure>-->
   <!--                     <img src="{{$newproduct->web_banner_image}}" alt="product"/>-->
   <!--                     <div class="product-like-heart"><i class="ti ti-heart"></i></div>-->
   <!--                  </figure>-->
   <!--                  <figcaption>-->
   <!--                     <h4>Explore Our Products</h4>-->
   <!--                     <span>$100</span>-->
   <!--                  </figcaption>-->
   <!--               </a>-->
   <!--            </div>-->
   <!--         </div>-->
   <!--         @endif-->
   <!--      </div>-->
   <!--   </div>-->
   <!--</section>-->
   {{--<section class="banner-add-section section-padding paddBot0">
      <div class="container-fluid">
         @if(!empty($newarrival->banner_link)&&($newarrival->click_status=='yes'))
         <a href="{{$newarrival->banner_link}}"><img src="{{ $newarrival->web_banner_image}}" alt="banner"/></a>
         @else
         <img src="{{ $newarrival->web_banner_image}}" alt="banner"/>
         @endif
      </div>
   </section>--}}
   <section class="amazing-deals-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>Currently Reading</h2>
         </div>
         <div class="owl-carousel owl-theme amazing-deals-list">
            @if(!empty($currentreading))
            @foreach($currentreading as $prod)
            <div class="item">
               <div class="product-box">
                  @php
                  $isSoldOut = $prod->quantity <= 0; // Check if the product is sold out
                  $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100)); // Calculate discounted price
                  @endphp
                  <figure>
                     <a href="{{ route('website.productdetail',['id'=>$prod->sku]) }}" 
                        class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                        <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />
                        @if($isSoldOut)
                        <div class="sold-out-overlay">Sold Out</div>
                        <!-- Overlay for sold out -->
                        @endif
                     </a>
                     <!-- Wishlist button remains clickable -->
                     <div class="product-like-heart" 
                        style="background-color: {{ $prod->is_wishlisted ? '#62c6bf' : '' }};" 
                        data-product-id="{{ $prod->product_id }}">
                        <i class="ti ti-heart"></i>
                     </div>
                  </figure>
                  <figcaption>
                     @if($currentLang == 'en')
                     <h4>{{ $prod->product_name }}</h4>
                     @elseif($currentLang == 'ar')
                     <h4>{{ $prod->product_name_ar }}</h4>
                     @elseif($currentLang == 'cku')
                     <h4>{{ $prod->product_name_cku }}</h4>
                     @else
                     <h4>{{ $prod->product_name }}</h4>
                     @endif
                     <span>{{ number_format($discountedPrice, 2) }}  RS.</span>
                  </figcaption>
               </div>
            </div>
            @endforeach
            @else
            <div class="item">
               <div class="product-box">
                  <a href="#">
                     <figure>
                        <img src="{{ asset('/storage/assets/website/images/latest-pr01.png')}}" alt="product"/>
                        <div class="product-like-heart"><i class="ti ti-heart"></i></div>
                     </figure>
                     <figcaption>
                        <h4>Explore Our Products</h4>
                        <span>$100</span>
                     </figcaption>
                  </a>
               </div>
            </div>
            @endif
         </div>
      </div>
   </section>
   
   {{--<section class="banner-add-section">
      <div class="container-fluid">
         <div class="banner-add-list">
            <ul>
               <li>
                  @if(!empty($babe_care->banner_link) &&($babe_care->click_status=='yes'))
                  <a href="{{$babe_care->banner_link}}"><img src="{{$babe_care->web_banner_image}}" alt="banner"/></a>
                  @else   
                  <img src="{{$babe_care->web_banner_image}}" alt="banner"/>
                  @endif
               </li>
               <li>
                  @if(!empty($magical->banner_link) &&($magical->click_status=='yes'))
                  <a href="{{$magical->banner_link}}"><img src="{{$magical->web_banner_image}}" alt="banner"/></a>
                  @else   
                  <img src="{{$magical->web_banner_image}}" alt="banner"/>
                  @endif
               </li>
            </ul>
         </div>
      </div>
   </section>--}}
   <section class="banner-add-section section-padding paddBot0">
      <div class="container-fluid">
         @if(!empty($newarrival->banner_link)&&($newarrival->click_status=='yes'))
         <a href="{{$newarrival->banner_link}}"><img src="{{ $newarrival->web_banner_image}}" alt="banner"/></a>
         @else
         <img src="https://thebookdoor.in/storage/app/public/banners/web/5gwUoJNmyLykpAt56CEUNSdtifhEvhhaBQl79znY.jpg" alt="banner"/>
         @endif
      </div>
   </section>
   
   <section class="amazing-deals-section best-seller-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>{{__('messages.best_seller')}}</h2>
         </div>
         <div class="owl-carousel owl-theme amazing-deals-list">
            @if(!empty($bestseller))
            @foreach($bestseller as $prod)
            <div class="item">
               <div class="product-box">
                  @php
                  $isSoldOut = $prod->quantity <= 0; // Check if the product is sold out
                  $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100)); // Calculate discounted price
                  @endphp
                  <figure>
                     <a href="{{route('website.productdetail',['id'=>$prod->sku]) }}" 
                        class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                        <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product" />
                        @if($isSoldOut)
                        <div class="sold-out-overlay">Sold Out</div>
                        <!-- Overlay for sold out -->
                        @endif
                     </a>
                     <!-- Wishlist button remains clickable -->
                     <div class="product-like-heart" 
                        style="background-color: {{ $prod->is_wishlisted ? '#62c6bf' : '' }};" 
                        data-product-id="{{ $prod->product_id }}">
                        <i class="ti ti-heart"></i>
                     </div>
                  </figure>
                  <figcaption>
                     @if($currentLang == 'en')
                     <h4>{{ $prod->product_name }}</h4>
                     @elseif($currentLang == 'ar')
                     <h4>{{ $prod->product_name_ar }}</h4>
                     @elseif($currentLang == 'cku')
                     <h4>{{ $prod->product_name_cku }}</h4>
                     @else
                     <h4>{{ $prod->product_name }}</h4>
                     @endif
                     <span>{{ number_format($discountedPrice, 2) }} RS.</span>
                  </figcaption>
               </div>
            </div>
            @endforeach
            @else
            <div class="item">
               <div class="product-box">
                  <a href="#">
                     <figure>
                        <img src="{{ asset('/storage/assets/website/images/latest-pr01.png')}}" alt="product"/>
                        <div class="product-like-heart"><i class="ti ti-heart"></i></div>
                     </figure>
                     <figcaption>
                        <h4>Explore Our Products</h4>
                        <span>$100</span>
                     </figcaption>
                  </a>
               </div>
            </div>
            @endif
         </div>
      </div>
   </section>
   {{--<section class="maternity-essentials-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>{{__('messages.maternity_essentials')}}</h2>
         </div>
         <div class="maternity-essentials-banner">
            @if(!empty($mater->banner_link)  &&($mater->click_status=='yes'))
            <a href="{{$mater->banner_link}}"><img src="{{$mater->web_banner_image}}" alt="banner"/> </a>
            @else
            <img src="{{$mater->web_banner_image}}" alt="banner"/> 
            @endif
         </div>
         <div class="bath-skin-care-list section-padding">
            <ul>
               @if($maternity)
               @foreach($maternity as $prod)
               <li>
                  @if($currentLang == 'en') 
                  <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                     <figure><img src="{{$prod->image}}" alt="Maternity Clothing"/></figure>
                     <figcaption>{{$prod->name}}</figcaption>
                  </a>
                  @elseif($currentLang == 'ar')
                  <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                     <figure><img src="{{$prod->image_ar}}" alt="Maternity Clothing"/></figure>
                     <figcaption>{{$prod->name_ar}}</figcaption>
                  </a>
                  @elseif($currentLang == 'cku')
                  <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                     <figure><img src="{{$prod->image_cku}}" alt="Maternity Clothing"/></figure>
                     <figcaption>{{$prod->name_cku}}</figcaption>
                  </a>
                  @endif
               </li>
               @endforeach
               @endif
           
            </ul>
         </div>
         <div class="maternity-essentials-banner">
            @if(!empty($perfact->banner_link)&&($perfact->click_status=='yes'))
            <a href="{{$perfact->banner_link}}"><img src="{{$perfact->web_banner_image}}" alt="banner"/> </a>
            @else
            <img src="{{$perfact->web_banner_image}}" alt="banner"/> 
            @endif
         </div>
      </div>
   </section>--}}
   {{--<section class="gentle-care-section">
      <div class="container-fluid">
         <div class="gentle-care-inner">
            <div class="gentle-care-banner">
               @if(!empty($delic->banner_link) &&($delic->click_status=='yes'))   
               <a href="{{$delic->banner_link}}" ><img src="{{$delic->web_banner_image}}" alt="gentle care"/></a>
               @else
               <img src="{{$delic->web_banner_image}}" alt="gentle care"/>
               @endif
            </div>
            <div class="gentle-care-list">
               <ul>
                  @if($dalicate)
                  @foreach($dalicate as $prod)
                  <li>
                     @if($currentLang == 'en') 
                     <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                        <figure><img src="{{$prod->image}}" alt="gentle care"/></figure>
                        <figcaption>{{$prod->name}}</figcaption>
                     </a>
                     @elseif($currentLang == 'ar')
                     <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                        <figure><img src="{{$prod->image_ar}}" alt="gentle care"/></figure>
                        <figcaption>{{$prod->name_ar}}</figcaption>
                     </a>
                     @elseif($currentLang == 'cku')
                     <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                        <figure><img src="{{$prod->image_cku}}" alt="gentle care"/></figure>
                        <figcaption>{{$prod->name_cku}}</figcaption>
                     </a>
                     @else
                     <a href="{{ route('website.categoryproductlist', ['id' => $prod->id]) }}">
                        <figure><img src="{{$prod->image}}" alt="gentle care"/></figure>
                        <figcaption>{{$prod->name}}</figcaption>
                     </a>
                     @endif
                  </li>
                  @endforeach
                  @endif
                 
               </ul>
            </div>
         </div>
      </div>
   </section>--}}
   {{--<section class="our-featured-brands-section section-padding">
      <div class="container-fluid">
         <div class="section-head">
            <h2>{{__('messages.our_featured_brands')}}</h2>
         </div>
         <div class="our-featured-list">
            <div class="owl-carousel owl-theme featured-brands-list">
               @if($brand)
               @foreach($brand as $value)
               <div class="item">
                  <div class="brand-logo"><a href="{{route('website.branddetail', base64_encode($value->id))}}">
                     @if($currentLang == 'en')   
                     <img src="{{$value->image}}" alt="Brand Logo"/>
                     @elseif($currentLang == 'ar')
                     <img src="{{$value->image_ar}}" alt="Brand Logo"/>
                     @elseif($currentLang == 'cku')
                     <img src="{{$value->image_cku}}" alt="Brand Logo"/>
                     @else
                     <img src="{{$value->image}}" alt="Brand Logo"/>
                     @endif
                     </a>
                  </div>
               </div>
               @endforeach
               <!-- <div class="item">
                  <div class="brand-logo"><a href="javascript:;"><img src="{{ asset('/storage/assets/website/images/brand-logo01.png')}}" alt="Brand Logo"/></a></div>
                  </div> -->
               @else
               <div class="item">
                  <div class="brand-logo"><a href="javascript:;"><img src="{{ asset('/storage/app/public/assets/website/images/brand-logo01.png')}}" alt="Brand Logo"/></a></div>
               </div>
               @endif
            </div>
         </div>
      </div>
   </section>--}}
   <section class="shipping-payment-support-section">
      <div class="container">
         <div class="shipping-payment-list">
            <ul>
               <li>
                  <a href="javascript:;">
                  <i><img src="{{ asset('/storage/app/public/assets/website/images/shipping.png')}}" alt="shipping"/></i>   
                  <span>{{__('messages.shipping')}}</span>
                  </a>
               </li>
               <li>
                  <a href="javascript:;">
                  <i><img src="{{ asset('/storage/app/public/assets/website/images/payment.png')}}" alt="shipping"/></i>   
                  <span>{{ __('messages.payment') }}</span>
                  </a>
               </li>
               <li>
                  <a href="javascript:;">
                  <i><img src="{{ asset('/storage/app/public/assets/website/images/support.png')}}" alt="shipping"/></i>   
                  <span>{{ __('messages.support') }}</span>
                  </a>
               </li>
            </ul>
         </div>
      </div>
   </section>
</div>
<script>
jQuery(document).ready(function($){
  $('.amazing-deals-list').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsive:{
      0:{ items:1 },
      600:{ items:2 },
      1000:{ items:4 }
    }
  });
});
</script>

</script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-like-heart').forEach(function (heart) {
        heart.addEventListener('click', function (event) {
            // Prevent click from navigating
            event.stopPropagation();
            event.preventDefault();
   
            const productId = this.getAttribute('data-product-id');
            // alert(productId);
            const heartIcon = this.querySelector('i'); // Get the heart icon
   
            // Perform the AJAX request
            fetch('/productwishlist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ product_id: productId }),
            })
                .then(async (response) => {
                    // Check if response is not OK (e.g., 401 for unauthenticated)
                    if (!response.ok) {
                        const errorData = await response.json(); // Parse error response
                        throw new Error(errorData.message); // Throw an error with the message
                    }
                    return response.json(); // Parse success response
                })
                .then(data => {
                    // Show success message
                    window.location.reload();      
                    //alert(data.message);
   
                    // Toggle heart color
                    if (data.status === 'added') {
                        heartIcon.style.color = '#62c6bf'; // Heart becomes red
                    } else if (data.status === 'removed') {
                        heartIcon.style.color = ''; // Revert to default
                    }
                })
                .catch(error => {
                    // Show error message
                    alert(error.message);
                });
        });
    });
   });
   
   
</script>
@include('website.footer')