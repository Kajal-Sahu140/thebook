@include('website.header')
<?php $currentLang = app()->getLocale(); ?>
<style>
/* Product Details Styles */
.product-detail-content h3, 
.product-detail-content h5 {
    margin: 10px 0;
}
/* Ensure consistent size for images inside the .item container */
.image-container {
    position: relative;
    width: 100%;
    padding-top: 100%; /* 1:1 Aspect Ratio */
    overflow: hidden;
    border: 1px solid #ddd; /* Optional: Add border for visual consistency */
}
.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* This ensures the image covers the container while maintaining aspect ratio */
}
.product-box {
    margin-bottom: 20px; /* Add some margin for spacing between product boxes */
}
.detail-size ul, 
.color-list ul {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 0;
    list-style: none;
}
.detail-size li, 
.color-list li {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
}
/* Social Sharing Styles */
.social-share ul {
    display: flex;
    gap: 10px;
    list-style: none;
    padding: 0;
}
.social-share a {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s ease;
}
.social-share a:hover {
    background-color: #ddd;
}

.color-option:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3); /* Add shadow effect on hover */
    cursor: pointer;
}

.color-option.selected {
    box-shadow: 0 0 10px 3px rgba(0, 123, 255, 0.6); /* Add glow to selected option */
    transform: scale(1.1); /* Slightly scale up the selected color */
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-detail-content {
        margin-top: 20px;
    }
    .product-detail-slider img {
        width: 100%;
        height: auto;
    }
}
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
    text-transform: uppercase;
    z-index: 10;
}
.sold-out-overlay{
    pointer-events: none;
    cursor: default;
    opacity: 0.6;
}
.product-like-heart {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 15; /* Ensure it stays above the overlay */
    cursor: pointer;
}


</style>
<div class="site-bg">
   <div class="product-detail-bg section-padding">
      <div class="container">
         <div class="prodcut-detail-top">
            <div class="row">
               <div class="col-md-6">
    <div class="product-detail-slider">
        <div id="sync1" class="">
            @php $isSoldOut = $products->quantity <= 0; @endphp
            @foreach($products->images as $image)
            <div class="item position-relative">
                <img src="{{ $image->image_url }}" alt="Product" />
                @if($isSoldOut)
                <!-- Sold Out Overlay -->
                <div class="sold-out-overlay notclickable" style="pointer-events: none;">Sold Out</div>
                @endif

                <!-- Heart Button -->
                <div class="product-like-heart" 
                     style="background-color: {{ $products->is_wishlisted ? '#62c6bf' : '' }};" 
                     data-product-id="{{ $products->product_id }}">
                    <i class="ti ti-heart"></i>
                </div>
            </div>
            @endforeach
        </div>
        <div id="sync2" class="owl-carousel owl-theme">
            @foreach($products->images as $image)
            <div class="item">
                <img src="{{ $image->image_url }}" alt="Product" />
            </div>
            @endforeach
        </div>
    </div>
</div>

               <div class="col-md-6">
                  <div class="product-detail-content">
                    @if($currentLang == 'en')
                     <h5>{{$products->brand->name}}</h5>
                     <h3>{{$products->product_name}}</h3>
                     @elseif($currentLang == 'ar')
                     <h5>{{$products->brand->name_ar}}</h5>
                     <h3>{{$products->product_name_ar}}</h3>
                     @elseif($currentLang == 'cku')
                     <h5>{{$products->brand->name_cku}}</h5>
                     <h3>{{$products->product_name_cku}}</h3>
                     @else
                     <h5>{{$products->brand->name}}</h5>
                     <h3>{{$products->product_name}}</h3>
                     @endif
                     <div class="star-rating-box">
                        <div class="detail-rating">
                           <i class="ti ti-star"></i>
                           <span>{{$products->rating}}</span>
                        </div>
                     </div>
                    <div class="detail-price">
    <span class="price-text" id="price-text">
        {{ number_format($products->base_price - ($products->base_price * ($products->discount / 100)), 2) }} Rs.
    </span>
    <span class="cross-price" id="cross-price">
        @if($products->discount > 0)
            {{ number_format($products->base_price, 2) }} Rs.
        @endif
    </span>
</div>

{{--<div class="detail-size class="hidden">
    <h5>{{ __('messages.size') }}</h5>
    <div class="size-box">
        <ul>
            @foreach($productvariant as $variant)
                <li>
                    <input type="radio" name="variant" class="variant-select" 
                           value="{{ $variant->id }}"  
                           id="sizeid"
                           data-price="{{ $variant->price }}" 
                           data-discount="{{ $variant->discount }}" 
                           data-size_id="{{ $variant->size_id }}" 
                           {{ request('size_id') == $variant->size_id ? 'checked' : ($loop->first && !request('size_id') ? 'checked' : '') }}> 
                          
                    
                    @if($currentLang == 'en')
                        {{ $variant->size_name }}
                    @elseif($currentLang == 'ar')
                        {{ $variant->size_name_ar }}
                    @elseif($currentLang == 'cku')
                        {{ $variant->size_name_cku }}
                    @else
                        {{ $variant->size_name }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>--}}

{{--<div class="color-list">
    <h5>{{ __('messages.color') }}</h5>
    <ul>
        @foreach($productvariant as $variant)
            <li class="color-option {{ request('color_id') == $variant->color_id ? 'selected' : ($loop->first && !request('color_id') ? 'selected' : '') }}" 
                style="background-color: {{ $variant->color_code }};"
                data-color-id="{{ $variant->color_id }}">
                
                @if(request('color_id') == $variant->color_id || ($loop->first && !request('color_id')))
                    <i class="fa fa-check" style="color: white;"></i>
                @endif
            </li>
        @endforeach
    </ul>
</div>--}}


   <div class="offers-coupons-box">
    @if(!empty($products->offers) && $products->offers->isNotEmpty())
        <h5>Offers & Coupons</h5>
        <div class="offers-coupons-list">
            <ul>
                @foreach($products->offers->filter(function($offer) {
                    return \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($offer->end_date));
                }) as $offer)
                    <li>
                        <i class="ti ti-tag"></i>
                        @if($offer->offer_type == "percentage")
                            <span>Get {{ $offer->discount_value }}% off on credit card</span>
                        @else
                            <span>Get {{ $offer->discount_value }} Flat off on credit card</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
                        <div class="wishlist-cart-btn">
                        <ul>
                        @if($products->is_wishlisted)
                            <li class="border-btn" data-product-id="{{ $products->product_id }}" id="product-like-heart" style="background-color: #62c6bf; color: white;">
                                <i class="ti ti-heart"></i> {{__('messages.wishlist') }}
                            </li>
                        @else
                            <li class="border-btn" data-product-id="{{ $products->product_id }}" id="product-like-heart">
                                <i class="ti ti-heart"></i> {{__('messages.wishlist') }}
                            </li>
                        @endif
                          <li>
                       @php $isSoldOut = $products->quantity <= 0; @endphp
                           @if($is_already_cart==1 )
                         <a href="{{ route('website.mycart') }}" class="border-btn">
                           <i class="ti ti-shopping-cart"></i> {{__('messages.go_to_cart') }}
                        </a>
                     @else
                        @if($is_already_cart!=1 && !$isSoldOut)
                         <!-- <a href="{{ route('website.productcart', $products->sku) }}" class="btn">
                           <i class="ti ti-shopping-cart"></i> Add to Cart 
                        </a> -->
                        <a href="#" id="addToCartBtn" class="btn">
                                <i class="ti ti-shopping-cart"></i>  
                                {{ __('messages.add_to_cart') }} 
                            </a>
                        @endif
                     @endif
                     </li>
                     </div>
                     <div class="social-share">
                        <h5>{{__('messages.share_this_product') }}:</h5>
                        <ul class="social-links">
                           <!-- Facebook -->
                           <li>
                              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('website.productdetail', $products->sku)) }}&quote={{ urlencode($products->product_name . ' - ' . $products->description) }}
                              "target="_blank" title="Share on Facebook">
                                 <i class="ti ti-facebook"></i> {{__('messages.facebook') }}
                              </a>
                           </li>
                           <!-- Twitter -->
                           <li>
                              <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('website.productdetail', $products->sku)) }}&text={{ urlencode($products->product_name . ' - ' . $products->description) }}
                                 "target="_blank" title="Share on Twitter">
                                 <i class="ti ti-twitter"></i> {{__('messages.twitter') }}
                              </a>
                           </li>
                           <!-- WhatsApp -->
                           <li>
                              <a href="https://api.whatsapp.com/send?text={{ urlencode($products->product_name . ' - ' . $products->description . ' ' . route('website.productdetail', $products->sku)) }}
                                 "target="_blank" title="Share on WhatsApp">
                                 <i class="ti ti-whatsapp"></i> {{__('messages.whatsapp_number') }}
                              </a>
                           </li>
                           <!-- LinkedIn -->
                           <li>
                              <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('website.productdetail', $products->sku)) }}&title={{ urlencode($products->product_name) }}&summary={{ urlencode($products->description) }}
                                 "target="_blank" title="Share on LinkedIn">
                                 <i class="ti ti-linkedin"></i> {{__('messages.linkedin') }}
                              </a>
                           </li>
                           
                           
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="policies-des">
            <h3>About</h3>
            @if($currentLang == 'en')
            <p>{{$products->description}} </p>
            @elseif($currentLang == 'ar')
            <p>{{$products->description_ar}} </p>
            @elseif($currentLang == 'cku')
            <p>{{$products->description_cku}} </p>
            @else
            <p>{{$products->description}} </p>
            @endif
         </div>
        <div class="recommendations-list">
    <h3>{{__('messages.recommendations') }}</h3>
    <div class="row">    
        @foreach($relatedProducts as $prod)
    @php 
        $isSoldOut = $prod->quantity <= 0; 
        // Calculate the discounted price
        $discountedPrice = $prod->base_price - ($prod->base_price * ($prod->discount / 100));
    @endphp
    <div class="col-md-3">
        <div class="product-box position-relative">
            <a href="{{ route('website.productdetail', ['id' => $prod->sku]) }}">
                <figure>
                    {{-- Display only the first image --}}
                    @if($prod->images->isNotEmpty())
                    <div class="item image-container position-relative">
                        <img src="{{ $prod->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="Product" class="product-image" />
                        
                        {{-- Sold Out Overlay --}}
                        @if($isSoldOut)
                       <div class="sold-out-overlay notclickable" style="pointer-events: none;">Sold Out</div>
                        @endif
                    </div>
                    @else
                    {{-- Fallback if no image exists --}}
                    <div class="item image-container position-relative">
                        <img src="https://dummyimage.com/16:9x1080/" class="product-image" alt="Default Product" />
                        
                        {{-- Sold Out Overlay --}}
                        @if($isSoldOut)
                         <div class="sold-out-overlay notclickable" style="pointer-events: none;">Sold Out</div>
                        @endif
                    </div>
                    @endif

                    {{-- Heart Button --}}
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
                    <div class="rating-box">
                        @php
                            $rating = $prod->rating;
                            $fullStars = floor($rating); 
                            $halfStar = ($rating - $fullStars) >= 0.5; 
                            $emptyStars = 5 - ceil($rating);
                        @endphp
                        
                        @for ($i = 1; $i <= $fullStars; $i++)
                            <i class="ti ti-star-filled active"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="ti ti-star-half active"></i>
                        @endif

                        @for ($i = 1; $i <= $emptyStars; $i++)
                            <i class="ti ti-star-filled"></i>
                        @endfor
                    </div>
                    <span class="cross-price">{{ number_format($discountedPrice, 2) }} Rs.</span>
                </figcaption>
            </a>
        </div>
    </div> 
@endforeach

    </div>
</div>
         <div class="detail-reviews-ratings-list">
            <h3>{{__('messages.reviews_ratings') }}</h3>
            <ul>
               @foreach ($ProductRating as $rating)
    <li>
        <div class="review-rating-head">
            <div class="review-rating-head-left">
                <h4>{{ $rating->user->name ?? 'User' }}</h4>  <!-- User's name -->
                <div class="rating-box">
                    @php
                        $ratingValue = $rating->rating;  // Get the rating value
                        $fullStars = floor($ratingValue);  // Full stars
                        $halfStar = ($ratingValue - $fullStars) >= 0.5 ? true : false;  // Half star
                        $emptyStars = 5 - ceil($ratingValue);  // Empty stars
                    @endphp
                    
                    @for ($i = 1; $i <= $fullStars; $i++)
                        <i class="ti ti-star-filled active"></i>  <!-- Filled star -->
                    @endfor

                    @if ($halfStar)
                        <i class="ti ti-star-half"></i>  <!-- Half star -->
                    @endif

                    @for ($i = 1; $i <= $emptyStars; $i++)
                        <i class="ti ti-star-filled"></i>  <!-- Empty star -->
                    @endfor
                </div>
            </div>
            <div class="day-ago">{{ \Carbon\Carbon::parse($rating->created_at)->diffForHumans() }}</div>  <!-- Time ago -->
        </div>
        <p>{{ $rating->review }}</p>  <!-- Review text -->
    </li>
@endforeach

              
              
            </ul>
         </div>
      </div>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


document.addEventListener('DOMContentLoaded', function() {
    // Add to Cart Button Click Event
    document.getElementById('addToCartBtn').addEventListener('click', function(event) {
        event.preventDefault();

        // const selectedSize = document.querySelector('input[name="variant"]:checked'); 
        // const sizeId = selectedSize ? selectedSize.getAttribute('data-size_id') : null; 

        // const selectedColor = document.querySelector('.color-option.selected');
        // const colorId = selectedColor ? selectedColor.getAttribute('data-color-id') : null;
        // //alert(colorId+'----->'+sizeId);
        // if (!sizeId) {
        //     alert('Please select a size before adding to cart.');
        //     return;
        // }

        // if (!colorId) {
        //     alert('Please select a color before adding to cart.');
        //     return;
        // }

        const sku = "{{ $products->sku }}"; // Pass SKU from Laravel Blade
        window.location.href = `/productcart/${sku}`;
    });

    // Color Option Selection with Shadow Effect
    document.querySelectorAll('.color-option').forEach(function(colorOption) {
        colorOption.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(option => option.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
});
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-like-heart ,#product-like-heart').forEach(function (heart) {
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
                  //   alert(data.message);

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
 $(document).ready(function () {
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    sync1.owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        loop: false,
        autoplay: false,
        smartSpeed: 1000,
        navText: ['<i class="ti ti-angle-left"></i>', '<i class="ti ti-angle-right"></i>'],
    }).on('changed.owl.carousel', syncPosition);

    sync2.owlCarousel({
        items: 4,
        margin: 10,
        dots: false,
        nav: false,
        smartSpeed: 1000,
        slideBy: 1,
        responsive: {
            0: { items: 3 },
            600: { items: 4 },
            1000: { items: 5 }
        }
    }).on('click', '.item', function () {
        var index = $(this).index();
        sync1.trigger('to.owl.carousel', [index, 1000, true]);
    });

    function syncPosition(event) {
        let index = event.item.index;
        sync2.trigger('to.owl.carousel', [index, 1000, true]);
        sync2.find(".owl-item").removeClass("current").eq(index).addClass("current");
    }

    sync2.find(".owl-item").eq(0).addClass("current");
});
</script>


<script>
  $(document).ready(function () {
    // When a variant (size) is selected
    $(".variant-select").on("change", function () {
        updateProductDetails();
    });

    // When a color option is clicked
    $(".color-option").on("click", function () {
        // Remove checkmark from all colors and deselect others
        $(".color-option").removeClass("selected").empty();
        
        // Add selected class and checkmark icon
        $(this).addClass("selected").html('<i class="fa fa-check" style="color: white;"></i>');

        updateProductDetails();
    });

    // Function to update product details (called on both size and color change)
    function updateProductDetails() {
        // Get the selected size and color IDs
        let sizeId = $(".variant-select:checked").data("size_id");
        let colorId = $(".color-option.selected").data("color-id");

        // If both size and color are selected, send via AJAX
        const sku = "{{ $products->sku }}";
        window.location.href = `/productdetail/${sku}?size_id=${sizeId}&color_id=${colorId}`;
    }
});


</script>



   </script>
@include('website.footer')