@include('website.header')
<style>

#coupon-list {
        max-width: 100%;
        box-sizing: border-box;
        display: block;
        margin-top: 10px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #coupon-items {
        padding-left: 20px;
        margin-top: 10px;
    }

    #coupon-items li {
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 8px;
    }

    #coupon-list span {
        font-size: 18px;
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
    }

    /* For smaller screens (mobile and tablets) */
    @media (max-width: 768px) {
        #coupon-list {
            padding: 10px;
        }

        #coupon-items li {
            font-size: 14px; /* Slightly smaller text on mobile */
        }

        #coupon-list span {
            font-size: 16px; /* Adjust title font size on smaller screens */
        }
    }

    @media (max-width: 480px) {
        #coupon-list {
            padding: 8px;
        }

        #coupon-items li {
            font-size: 13px; /* Even smaller text on very small screens */
        }

        #coupon-list span {
            font-size: 14px; /* Adjust title font size even more */
        }
    }
.product-box {
    position: relative;
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
    z-index: 10;
    text-transform: uppercase;
}

.disabled-link {
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
 <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
    <div class="inner-page-warper">
        <section class="search-content-warper section-padding">
            <div class="container">
                <h2>{{__('messages.cart')}}</h2>
                <div class="cart-page-content">
    <div class="cart-page-content-left">
        <div class="cart-item-list">
            <ul>
               @foreach($cart as $item)
    <li>
        <div class="cart-item-box">
            <div class="cart-item-img">
                <a href="{{ $item->product->quantity > 0 ? route('website.productdetail', ['id' => $item->product->sku]) : 'javascript:void(0)' }}">
                    <img src="{{ $item->product->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="product">
                </a>
            </div>
            <div class="cart-item-content">
                <!-- Product Name -->
                @if($currentLang == 'en')
                <h3>{{ $item->product->product_name ?? 'N/A'  }}</h3>
                @elseif($currentLang == 'ar')
                <h3>{{ $item->product->product_name_ar ?? 'N/A'  }}</h3>
                @elseif($currentLang == 'cku')
                <h3>{{ $item->product->product_name_cku ?? 'N/A'  }}</h3>
                @else
                <h3>{{ $item->product->product_name ?? 'N/A'  }}</h3>
                @endif
               
                @php
                $discountedPrice = $item->product->base_price - ($item->product->base_price * ($item->product->discount / 100));
                @endphp
                @if($item->product->discount>0)
                 <span style="text-decoration: line-through;">RS. {{$item->product->base_price ,2}} </span><span>   RS. {{number_format($discountedPrice ,2)}}</span></br>
               
                @endif
                <!-- Remove Button -->
                <button class="remove-item-btn mt-1" 
                        data-id="{{ $item->id }}" 
                        onclick="removeCartItem({{ $item->id }})"
                        style="background-color: transparent; cursor: pointer; color: white; font-weight: bold;background-color:#62c6bf; border-radius: 5px; padding: 5px 10px;">
                    <i class="ti ti-close"></i> {{__('messages.remove')}}
                </button>
                <!-- Rating -->
                <div class="cart-item-rating mt-2">
                    <div class="rating-box">
                       @php
                            $ratingValue = $item->rating ?? 0; // Get the rating value
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
                    <span>{{ $item->rating ?? 0 }} ratings</span>
                </div>
                <!-- Size and Color -->
               {{-- <div class="cart-size-color">
                    <span><strong>{{__('messages.size')}}:</strong> 
                    @if($currentLang == 'en')
                    {{ $item->size_name ?? 'N/A' }}</span>
                    @elseif($currentLang == 'ar')
                    {{ $item->size_name_ar ?? 'N/A' }}</span>
                    @elseif($currentLang == 'cku')
                    {{ $item->size_name_cku ?? 'N/A' }}</span>
                    @else
                    {{ $item->size_name ?? 'N/A' }}</span>  
                    @endif
                    <span><strong>{{__('messages.color')}}:</strong>
                        <input type="color" value="{{ $item->color_code ?? '#ffffff' }}" disabled />
                    </span>
                </div>--}}
            </div>
        </div>
        <div class="cart-item-right">
            <div class="cart-qty-price">
                <!-- Quantity Selector -->
                <div class="cart-qty">
                    <!-- @if ($item->product->quantity > 0) -->
                        <span class="decrease-qty" data-id="{{ $item->id }}"><i class="ti ti-minus"></i></span>
                        <div class="qty-box">
                            <input type="number" value="{{ $item->quantity }}" min="0"  data-id="{{ $item->id }}" class="quantity-input">
                        </div>
                        <span class="increase-qty" data-id="{{ $item->id }}"><i class="ti ti-plus"></i></span>
                    <!-- @else
                        <span class="sold-out">Sold Out</span>
                    @endif -->
                </div>
                <!-- Price -->
                <div class="cart-price">
                    <span>RS. {{ number_format($item->product->base_price * $item->quantity, 2) }}</span>
                </div>
            </div>
            <!-- Delivery Date -->
            <div class="cart-delivery-date">
                {{__('messages.delivery_by')}} {{ $item->delivery_date ?? 'N/A' }}
            </div>
        </div>
    </li>
@endforeach
     </ul>
        </div>
        @if($cart->isEmpty())
        <img src="https://skoozo.com/assets/img/empty-cart.png"class="img-fluid img-responsive"alt="empty cart"style="image-rendering: pixelated;" />
        @endif
         <div class="recommendations-box">
                            <h3>{{__('messages.recommendations')}}</h3>
                            <div class="row">
                              @foreach($recommendations as $product)
    <div class="col-md-4">
        <div class="product-box">
            <figure>
                <a href="{{ route('website.productdetail', ['id' => $product->sku]) }}">
                    <img src="{{ $product->images->first()->image_url }}" alt="product" />
                    @if($product->quantity <= 0)
                        <div class="sold-out-overlay notclickable" style="pointer-events:none;">Sold Out</div>
                    @endif
                </a>
                <div class="product-like-heart" 
                     style="background-color: {{ $product->is_wishlisted ? '#62c6bf' : '' }};" 
                     data-product-id="{{ $product->product_id }}">
                    <i class="ti ti-heart"></i>
                </div> 
            </figure>
            <figcaption>
                @if($currentLang == 'en')
                <h4>{{ $product->product_name }}</h4>
                @elseif($currentLang == 'ar')
                <h4>{{ $product->product_name_ar }}</h4>
                @elseif($currentLang == 'cku')
                <h4>{{ $product->product_name_cku }}</h4>
                @else
                <h4>{{ $product->product_name }}</h4>
                @endif
                <div class="rating-box">
                    @php
                        $ratingValue = $product->rating;  // Get the rating value
                        $fullStars = floor($ratingValue);  // Full stars
                        $halfStar = ($ratingValue - $fullStars) >= 0.5 ? true : false;  // Half star
                        $emptyStars = 5 - ceil($ratingValue);  // Empty stars
                    @endphp

                    @for ($i = 1; $i <= $fullStars; $i++)
                        <i class="ti ti-star-filled active"></i>  <!-- Filled star -->
                    @endfor

                    @if ($halfStar)
                        <i class="ti ti-star-half active"></i>  <!-- Half star -->
                    @endif

                    @for ($i = 1; $i <= $emptyStars; $i++)
                        <i class="ti ti-star-filled"></i>  <!-- Empty star -->
                    @endfor
                </div>
                <span>RS. {{ $product->base_price }}</span>
            </figcaption>
        </div>
    </div>
@endforeach
                            </div>
                        </div>
                    </div>
                   <div class="cart-page-content-right">
                   <!-- @php 
                $appliedCoupon = session('applied_coupon', null);
                @endphp
                <input type="text" id="coupon-code" class="" placeholder="Coupon Code" value="{{ $appliedCoupon}}" /> -->
    <div class="cart-summary-box">
        <h3>{{__('messages.price_summary')}}</h3>
        <div class="coupon-code-box">
            <h5>{{__('messages.coupon_code')}}</h5>
            <div class="coupon-code-input">
    @php 
        $appliedCoupon = session('applied_coupon', null);
    @endphp

    <input type="text" id="coupon-code" name="coupon_code" class="form-control" 
        placeholder="{{ __('messages.coupon_code') }}" 
        value="{{ $appliedCoupon ?? '' }}" 
        autocomplete="off" readonly />

    <button class="btn" id="apply-btn" 
        onclick="applyCoupon()" 
        style="{{ $appliedCoupon ? 'display: none;' : '' }}">
        {{ __('messages.apply') }}
    </button>

    @if ($appliedCoupon)
        <button class="btn" id="remove-btn" onclick="removeCoupon()">
            {{ __('messages.remove') }}
        </button>
    @endif
</div>

@if($cart->isNotEmpty())
    <div id="coupon-list" style="margin-top: 10px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
        <span>{{__('messages.available_coupons')}}:</span>
        @if ($coupons->count() > 0)
           <ul id="coupon-items">
    @foreach ($coupons as $coupon)
        @php
            $totalPrice = $cart->sum(fn($item) => $item->product->base_price * $item->quantity)
                        - $cart->sum(fn($item) => $item->product->base_price * ($item->product->discount / 100) * $item->quantity)
                        - ($couponDiscount ?? 0) 
                        + ($totalDeliveryFee ?? 0);

            $isCouponApplied = $appliedCoupon === $coupon->coupon_code;
            $isClickable = $totalPrice >= $coupon->min_purchase_amount;
        @endphp

        <li style="display: flex; align-items: center; gap: 10px; cursor: {{ $isClickable ? 'pointer' : 'not-allowed' }}; opacity: {{ $isClickable ? '1' : '0.5' }};" 
            @if($isClickable) onclick="selectCoupon('{{ $coupon->coupon_code }}')" @endif>
            
            <strong>{{ $coupon->coupon_code }}</strong>  
            @if($coupon->discount_type == "percentage")
                {{ $coupon->discount_value }}% off
            @else
                RS. {{ $coupon->discount_value }} off
            @endif
            (Valid until {{ \Carbon\Carbon::parse($coupon->end_date)->format('M d, Y') }})

            @if ($isCouponApplied)
                <span style="width: 10px; height: 10px; background-color: green; border-radius: 50%; display: inline-block;" title="Coupon Applied"></span>
            @endif

            @if (!$isClickable)
                <span style="color: red; font-size: 12px; margin-left: 10px;">
                    (Min purchase: RS. {{ number_format($coupon->min_purchase_amount, 2) }})
                </span>
            @endif
        </li>
    @endforeach
</ul>

        @else
            <p style="font-size: 14px; color: #777;">No coupons available.</p>
        @endif
    </div>
@endif

<!-- <div id="applied-coupon" style="display: {{ $appliedCoupon ? 'block' : 'none' }}; margin-top: 10px;">
    <h4>{{__('messages.applied_coupon')}}:</h4>
    <p id="applied-coupon-text">{{ $appliedCoupon }}</p>
</div> -->

    <div class="cart-summary-box-bottom">
                                <ul>
                                    <li>
                                        <span>{{__('messages.subtotal')}}</span>
                                        <span><strong>RS. {{ number_format($subtotal,2) }}</strong></span>
                                    </li>
                                    <li>
                                     <!-- Product Name -->
                                          <span>{{__('messages.discount')}}</span>
                                            
                                            <!-- Product Discount (calculated) -->
                                            <span><strong>
                                            RS. {{ number_format($totalDiscount, 2) }}
                                </strong></span>
                                    </li>
                                

                                    <li>
                                        <span>{{__('messages.coupon_discount')}}</span>
                                        <span><strong>RS. {{ number_format($couponDiscount,2) ?? 0 }}</strong></span>
                                    </li>
                                    <li>
                                        <span>{{__('messages.delivery_fees')}}</span>
                                        <span><strong>RS. {{ number_format($totalDeliveryFee, 2) }}</strong></span>
                                    </li>
                                   <li>
                                    <span><strong>{{__('messages.total')}}</strong></span>
                                    <span><strong>
                                        RS. {{ number_format(
                                            $cart->sum(fn($item) => $item->product->base_price * $item->quantity) 
                                            - $cart->sum(fn($item) => $item->product->base_price * ($item->product->discount / 100) * $item->quantity) 
                                            - ($couponDiscount ?? 0) 
                                            + ($totalDeliveryFee ?? 0), 2) 
                                        }}
                                    </strong></span>
                                </li>
                                </ul>
                            </div>
                            <div class="cart-summary-box-bottom-btn">
                                 @if($cart->isEmpty() || $subtotal <= 0)
                                <button class="btn" disabled>Order Now</button>
                                @else
                            <a class="btn btn-buy-now"  href="{{route('website.orderSummary')}}">{{__('messages.order_now')}}</a>
                                @endif
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    /////////////////////////////////
  document.addEventListener('DOMContentLoaded', function() {
    const couponInput = document.getElementById('coupon-code');
    let lastValue = couponInput.value;

    couponInput.addEventListener('input', function(e) {
        const currentValue = e.target.value;
        
        if (currentValue !== lastValue) {
            lastValue = currentValue;
        }
    });
});

 function selectCoupon(couponCode) {
    const input = document.getElementById('coupon-code');

    // Get the current cursor position
    const cursorPosition = input.selectionStart;
    input.focus();
    // Set the new value
    input.value = couponCode;

    // Restore the cursor position
    input.setSelectionRange(cursorPosition, cursorPosition);

    document.getElementById('apply-btn').innerText = 'Apply';
}


    function applyCoupon() {
        var couponInput = document.getElementById('coupon-code').value;
        if (couponInput.trim() !== '') {
            document.getElementById('applied-coupon').style.display = 'block';
            document.getElementById('applied-coupon-text').innerText = 'Coupon Applied: ' + couponInput;
            document.getElementById('apply-btn').innerText = 'Remove';
            document.getElementById('apply-btn').setAttribute('onclick', 'removeCoupon()');
        }
    }

    function removeCoupon() {
        document.getElementById('coupon-code').value = '';
        document.getElementById('applied-coupon').style.display = 'none';
        document.getElementById('apply-btn').innerText = 'Apply';
        document.getElementById('apply-btn').setAttribute('onclick', 'applyCoupon()');
    }

    async function removeCoupon() {
        const couponCode = document.getElementById('coupon-code').value;

        if (!couponCode) {
            alert("Please enter a coupon code.");
            return;
        }

        try {
            const response = await fetch('/removeCoupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'  // CSRF token for security
                },
                body: JSON.stringify({ coupon_code: couponCode })
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem('applied_coupon', couponCode);
               // alert(data.message); 
                //alert(data.message + " Total Discount: " + data.totalDiscount);
                location.reload();
                // Optionally, update the UI with the new cart details here
            } else {

                alert(data.error);
                 location.reload();
            }
        } catch (error) {
           location.reload();
            console.error("Error applying coupon:", error);
            alert("There was an error applying the coupon. Please try again.");
        }
    }


    /////////////////////////////
  function toggleCouponList() {
    const couponList = document.getElementById("coupon-list");

    // Toggle visibility of the coupon list
    if (couponList.style.display === "none") {
        couponList.style.display = "block";
       
    } else {
        couponList.style.display = "none";
    }
}
//////////////////////
async function applyCoupon() {
        const couponCode = document.getElementById('coupon-code').value;

        if (!couponCode) {
            alert("Please enter a coupon code.");
            return;
        }

        try {
            const response = await fetch('/applyCoupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'  // CSRF token for security
                },
                body: JSON.stringify({ coupon_code: couponCode })
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem('applied_coupon', couponCode);
               // alert(data.message); 
                //alert(data.message + " Total Discount: " + data.totalDiscount);
                location.reload();
                // Optionally, update the UI with the new cart details here
            } else {

                alert(data.error);
                 location.reload();
            }
        } catch (error) {
           location.reload();
            console.error("Error applying coupon:", error);
            alert("There was an error applying the coupon. Please try again.");
        }
    }
    /////////////////////////remove//////////////////////

function removeCartItem(itemId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch(`/cartproductremove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //alert('Item removed successfully!');
                location.reload(); // Reload the page to reflect cart changes
            } else {
                alert('Failed to remove item. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    }
}


    //////////////////////////////////////////
$(document).ready(function() {
    // Increase quantity
    $('.increase-qty').on('click', function() {
        var $this = $(this);
        var itemId = $this.data('id');
        var $quantityInput = $('[data-id="' + itemId + '"].quantity-input');
        var currentQuantity = parseInt($quantityInput.val());

        // Increase the quantity by 1, up to max 10
        var newQuantity = currentQuantity < 10 ? currentQuantity + 1 : 10;
        $quantityInput.val(newQuantity);

        updateCartItemQuantity(itemId, newQuantity);
    });

    // Decrease quantity
    $('.decrease-qty').on('click', function() {
        var $this = $(this);
        var itemId = $this.data('id');
        var $quantityInput = $('[data-id="' + itemId + '"].quantity-input');
        var currentQuantity = parseInt($quantityInput.val());

        // Decrease the quantity by 1, down to minimum 1
        var newQuantity = currentQuantity > 1 ? currentQuantity - 1 : 1;
        $quantityInput.val(newQuantity);
           var newQuantity = currentQuantity - 1;
            if (newQuantity <= 0) {
                removeCartItem(itemId);
           }
        // Update the cart item
        if(newQuantity==0){
updateCartItemQuantity(itemId, newQuantity+1);
        }
        else{
updateCartItemQuantity(itemId, newQuantity);
        }

        
    });
    // Change quantity manually in the input box
    $('.quantity-input').on('change', function() {
        var $this = $(this);
        var itemId = $this.data('id');
        var newQuantity = parseInt($this.val());

        // Ensure the quantity is between 1 and 10
        if (newQuantity < 1) newQuantity = 1;
        if (newQuantity > 10) newQuantity = 10;

        $this.val(newQuantity);

        // Update the cart item
        updateCartItemQuantity(itemId, newQuantity);
    });

    // Function to send the updated quantity to the server
    function updateCartItemQuantity(itemId, newQuantity) {
    // Prepare the form data to be sent in the request body
    const formData = new FormData();
    formData.append('item_id', itemId);
    formData.append('quantity', newQuantity);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    // Send the POST request using fetch
    fetch("{{ route('website.updateCartQuantity') }}", {
        method: 'POST',
        body: formData,  // Send form data in the request body
    })
    .then(response => response.json())  // Parse the JSON response
    .then(response => {
        console.log('Response:', response);  // Debugging output

        // Check if the response indicates success
        if (response.success) {
          window.location.reload();     
            var totalPrice = response.total_price;
            console.log('Updated price:', totalPrice);  // Debugging output

            // Update the price in the cart item
            $('[data-id="' + itemId + '"].cart-price span').text('$' + totalPrice.toFixed(2));
        } else {
            alert('Error updating cart quantity');
        }
    })
    .catch(error => {
        console.log('Error:', error);  // Debugging output
        window.location.reload();       
        // alert('Out Of Stock');
    });
}

});
////////////////////////////
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
</script>


@include('website.footer')
