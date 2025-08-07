@include('website.header')
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

.product-like-heart {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 15; /* Ensure it stays above the overlay */
    cursor: pointer;
}



</style>
 <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
   <div class="inner-page-warper">
      <section class="search-content-warper section-padding">
         <div class="container">
            <h2>{{__('messages.wishlist')}}</h2>
            <div class="row">
               @if($wishlistItems->isEmpty())
                  <h2 class="empty-wishlist" style="text-align: center;margin-top: 20px; color:gray;">Your wishlist is empty.</h2>
               @else
                 @foreach($wishlistItems as $item)
                 @if($item->product!=null)
   <div class="col-md-3">
      <div class="product-box">
         <figure>
           @php
          
               $isSoldOut = $item->product->quantity <= 0; // Check if product is sold out
           @endphp
           <a href="{{route('website.productdetail',['id' => $item->product->sku])}}"
              class="{{ $isSoldOut ? 'disabled-link' : '' }}">
               <img src="{{ $item->product->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" 
                    alt="{{ $item->product->name }}"/>
               
           </a>
           @if($isSoldOut)
               <div class="sold-out-overlay">Sold Out</div> <!-- Overlay for sold out -->
           @endif
           <div class="product-like-heart" 
                    style="background-color: {{ $item->product->is_wishlisted ? '#62c6bf' : '#62c6bf' }};" 
                    data-product-id="{{ $item->product->product_id }}">
                   <i class="ti ti-heart"></i>
               </div>
         </figure>
         <figcaption>
    @if($currentLang == 'en')
            <h5>{{ \Str::limit($item->product->product_name, 25) }}
</h5>
            @elseif($currentLang == 'ar')   
            <h5>{{ \Str::limit($item->product->product_name_ar , 25) }}</h5>
            @elseif($currentLang == 'cku')
            <h5>{{ \Str::limit($item->product->product_name_cku , 25) }}</h5>
            @else
            <h5>{{ \Str::limit($item->product->product_name , 25) }}</h5>
            @endif
            <div class="rating-box">
               @php
                   $ratingValue = $item->rating;  // Get the rating value
                   $fullStars = floor($ratingValue);  // Full stars
                   $halfStar = ($ratingValue - $fullStars) >= 0.5;  // Half star
                   $emptyStars = 5 - ceil($ratingValue);  // Empty stars
               @endphp

               @for ($i = 1; $i <= $fullStars; $i++)
                   <i class="ti ti-star-filled active"></i> <!-- Filled star -->
               @endfor

               @if ($halfStar)
                   <i class="ti ti-star-half"></i> <!-- Half star -->
               @endif

               @for ($i = 1; $i <= $emptyStars; $i++)
                   <i class="ti ti-star-filled"></i> <!-- Empty star -->
               @endfor
            </div>
            @php
               // Calculate the discounted price
               $discountedPrice = $item->product->base_price - ($item->product->base_price * ($item->product->discount / 100));
            @endphp
            <span class="cross-price">{{ $discountedPrice }} IQD</span>
         </figcaption>
         <div class="add-to-cart-btn">
            @if(!$isSoldOut)
               @if ($item->is_in_cart)
                {{-- "Go to Cart" button if the product is already in the cart --}}
                <a href="{{ route('website.mycart') }}" 
                   class="border-btn" 
                   style="background-color: #62c6bf; color: white;">
                    <i class="ti ti-shopping-cart"></i>  
                    <span style="color: white;">Go to Cart</span>
                </a>
            @else
                {{-- "Add to Cart" button if the product is not in the cart --}}
                <a href="{{ route('website.productcart', $item->product->sku) }}" 
                   class="border-btn" 
                   style="background-color: #62c6bf; color: white;">
                    <i class="ti ti-shopping-cart"></i>  
                    <span style="color: white;">Add to Cart</span>
                </a>
            @endif
            @else
               <a href="#" 
                   class="border-btn" 
                   style="background-color: #62c6bf;color:white;">
                    <i class="ti ti-shopping-cart"></i>  
                    <span style="color: white;">Sold Out</span>
                </a>
            @endif
         </div>
      </div>
   </div>
   @endif
@endforeach

               @endif
            </div>
            
            <!-- Pagination links -->
            <div class="pagination-box">
               <ul class="pagination justify-content-center">
                  {{ $wishlistItems->links('pagination::bootstrap-4') }}
               </ul>
            </div>
         </div>
      </section>
   </div>
</div>
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
                       
                     //alert(data.message);

                    // Toggle heart color
                    if (data.status === 'added') {
                        heartIcon.style.color = '#62c6bf'; // Heart becomes red
                    } else if (data.status === 'removed') {
                        alert('Item removed from wishlist');
                        heartIcon.style.color = ''; // Revert to default
                    }
                    window.location.reload(); 
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
