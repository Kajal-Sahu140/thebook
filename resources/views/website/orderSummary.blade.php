@include('website.header')
<style>
  .form-group .error {
    font-size: 14px;
    color: red;
    font-weight: 600;
    margin-bottom: 8px;
}
.form-control.country_code
{
   width:70px;
   flex:0 0 70px;
}
    </style>
     <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
   <div class="inner-page-warper">
      <section class="search-content-warper section-padding">
         <div class="container">
            <h2>{{__('messages.order_summary')}}</h2>
            <div class="cart-page-content">
               <div class="cart-page-content-left">
                  <div class="cart-item-list">
                     <ul>
                        <!-- Loop through cart items dynamically -->

                        @foreach ($filteredCart as $item)
                        <li>
                           <div class="cart-item-box">
                              <div class="cart-item-img">
                                 <img src="{{ $item->product->images->first()->image_url ?? 'https://dummyimage.com/16:9x1080/' }}" alt="{{ $item->product->product_name }}">
                              </div>
                              <div class="cart-item-content">
                                 @if($currentLang == 'en')
                                 <h3>{{ $item->product->product_name }}</h3>
                                 @elseif($currentLang == 'ar')
                                 <h3>{{ $item->product->product_name_ar }}</h3>
                                 @elseif($currentLang == 'cku')
                                 <h3>{{ $item->product->product_name_cku }}</h3>
                                 @endif
                                 <div class="cart-item-rating">
                                    <div class="rating-box">
                                       @php
                        $ratingValue = $item->rating;  // Get the rating value
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
                                    <span>{{ $item->product->ratings ?? 'No ratings' }}</span>
                                 </div>
                                {{-- <div class="cart-size-color">
                                    <span><strong>{{__('messages.size')}}:</strong> 
                                    @if($currentLang == 'en')
                                    {{ $item->size_name ?? 'N/A' }}
                                    @elseif($currentLang == 'ar')
                                    {{ $item->size_name_ar ?? 'N/A' }}
                                    @elseif($currentLang == 'cku')
                                    {{ $item->size_name_cku ?? 'N/A' }}
                                    @else
                                    {{ $item->size_name ?? 'N/A' }}
                                    @endif   
                                 </span>
                                    <span><strong>{{__('messages.color')}}:</strong> <input type="color" value="{{ $item->color_code ?? '#ffffff' }}" /></span>
                                 </div>
                              </div>--}}
                           </div>
                           <div class="cart-item-right">
                               @php
                $discountedPrice = $item->product->base_price - ($item->product->base_price * ($item->product->discount / 100));
                @endphp
                @if($item->product->discount>0)
                 <span>   RS. {{ number_format($item->product->base_price * $item->quantity, 2) }}</span></br>
               @else
                 <span>   RS. {{ number_format($item->product->base_price, 2) }}</span></br>
                @endif
                             
                              <div class="cart-delivery-date"><div class="cart-delivery-date">
                {{__('messages.delivery_by')}} {{ $item->delivery_date ?? 'N/A' }}
            </div></div>
                           </div>
                        </li>
                        @endforeach
                     </ul>
                  </div>

                  <div class="delivery-address-bg">
    <h3>{{__('messages.delivery_address')}}</h3>
    <div class="delivery-address-des d-block">
        <div class="row">
            <div class="col-md-12">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">{{__('messages.add_address')}}</button>
                </div>
            @if($useraddress->isEmpty())
                <!-- Show Add Address Button if no address exists -->
                
            @else
                <!-- Display Addresses -->
                @foreach($useraddress as $address)
                <div class="col-md-6">
                    <div class="delivery-address-box">
                        <label>
                            <input type="radio" name="selected_address" value="{{ $address->id }}" {{ $address->make_as_default ? 'checked' : '' }}>
                            <h4>{{ $address->name }} 
                                <span class="badge bg-success">{{ $address->make_as_default ? __('messages.default') : '' }}</span>
                            </h4>
                            <p>{{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->zip_code }}, {{ $address->country }}</p>
                            <p>{{ $address->mobile_number }}</p>
                        </label>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        
    </div>
</div>
<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAddressModalLabel">{{__('messages.add_new_address')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm" method="POST" action="{{ route('website.saveaddress') }}">
                    @csrf
                    <input type="hidden" name="ordersummary" value="1">
                    <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.name')}}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Name"/> 
                                    @error('name')
                                       <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.address')}}</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Enter Address"/> 
                                 </div>
                                 @error('address')
                                       <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                 <label for="mobile">{{__('messages.mobile')}} <sup>*</sup></label>
                                 <!-- Country Code Dropdown -->
                                 <div class="input-group">
                                    <select name="country_code" id="country_code" class="form-control country_code @error('country_code') is-invalid @enderror">   
                                          <!-- @foreach($country_codes as $code)
                                             <option value="{{ $code->code }}" {{ old('country_code') == $code->code ? 'selected' : '' }}>{{ $code->code }}</option>
                                          @endforeach -->
                                          <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+964</option>
                                    </select>

                                    <!-- Mobile Input Field -->
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                             id="mobile" 
                                             name="mobile" 
                                             placeholder="Enter Mobile" 
                                             value="{{ old('mobile') }}" 
                                             oninput="this.value = this.value.replace(/[^0-9]/g, '')" /><br>
                                    
                                    @error('mobile')
                                          <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                                 </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.house_number')}}</label>
                                    <input type="text" class="form-control" name="house_number" value="{{ old('house_number') }}" placeholder="Enter House Number"/> 

                                </div>
                                @error('house_number')
                                    <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.street_name')}}</label>
                                    <input type="text" class="form-control" name="street_name" value="{{ old('street_name') }}" placeholder="Enter Street Name"/> 
                                    @error('street_name')
                                       <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror 
                                </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.landmark')}}</label>
                                    <input type="text" class="form-control" maxlength="150" value="{{ old('landmark') }}" name="landmark" placeholder="Enter Landmark"/> 

                                </div>
                                @error('landmark')
                                    <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                 @enderror
                            </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.city')}}</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="Enter City"/> 
                                    
                                 </div>
                                 @error('city')
                                       <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.country')}}</label>
                                    <input type="text" class="form-control" value="{{ old('country') }}" name="country" placeholder="Enter Country"/> 
                                 </div>
                                 @error('country')
                                    <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{__('messages.zip_code')}}</label>
                                    <input type="text" class="form-control" name="zip_code" value="{{ old('zip_code') }}" placeholder="Enter Zip Code"/> 
                                 </div>
                                 @error('zip_code')
                                    <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                 @enderror
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Make as Default</label>
                                    <input type="checkbox" name="make_as_default" value="1"/> 
                                 </div>
                              </div>
                          </div>
                          <div class="save-btn mar-top15">
                              <button class="btn" type="submit">{{__('messages.save')}}</button>
                          </div>
                </form>
            </div>
        </div>
    </div>
</div>
 </div>
               <div class="cart-page-content-right">
                  <div class="cart-summary-box">
                     <h3>{{__('messages.price_summary')}}</h3>
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
                        {{--<form id="paymentForm">
    @csrf

    <button type="submit" class="btn" id="placebutton" disabled>Payment</button>
</form>--}}
  <form>
    @csrf

       <button type="button" class="btn" id="payNowButton" disabled>{{__('messages.pay_now')}}</button> 
</form>
    <!-- <button type="button" class="btn" id="payNowButton" disabled>{{__('messages.pay_now')}}</button> -->
    @else
    <!-- <button type="button" class="btn" id="payNowButton">{{__('messages.pay_now')}}</button> -->
    <form>
    @csrf
  <button type="button" class="btn" id="payNowButton">{{__('messages.pay_now')}}</button> 
    <!--<button type="submit" class="btn" id="payNowButton">Payment</button>-->
</form>
    @endif
    

   <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid">
            </div>
            <form id="paymentstatusForm">
            <input type="hidden" id="paymentId" value="">
            <div class="modal-footer">

                <button type="submit" id="payButton" class="btn btn-success">Pay Now</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center p-4">
                <div class="order-success-des">
                    <figure><img src="{{ asset('/storage/app/public/assets/website/images/success.png')}}" alt="success-icon" /></figure>
                    <h2>Order Placed Successfully</h2>
                    <p>Your order is successfully placed. It will be delivered to your home by {{ now()->addDays(5)->format('d M Y') }}.</p>
                    <div class="order-success-btn">
                        <a href="{{route('website.index')}}" class="btn">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
</div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    // Close the modal when clicking the "Continue Shopping" button
    document.getElementById('continueShoppingBtn').addEventListener('click', function() {
        var orderSuccessModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
        orderSuccessModal.hide();
    });

$(document).ready(function () {
      // Form Validation
      $("#addressForm").validate({
         rules: {
            name: {
               required: true,
               minlength: 2,
               maxlength: 50
            },
            address: {
               required: true,
               minlength: 5,
               maxlength: 255
            },
            mobile: {
               required: true,
               minlength: 10,
               maxlength: 15,
               digits: true
            },
            house_number: {
               required: true,
               minlength: 1,
               maxlength: 50
            },
            street_name: {
               required: true,
               minlength: 3,
               maxlength: 100
            },
            city: {
               required: true,
               minlength: 2,
               maxlength: 100
            },
            country: {
               required: true,
               minlength: 2,
               maxlength: 100
            },
            zip_code: {
               required: true,
               digits: true,
               minlength: 5,
               maxlength: 10
            }
         },
         messages: {
            name: {
               required: "Please enter your name",
               minlength: "Name should be at least 2 characters",
               maxlength: "Name should not exceed 50 characters"
            },
            address: {
               required: "Please enter your address",
               minlength: "Address should be at least 5 characters",
               maxlength: "Address should not exceed 255 characters"
            },
            mobile: {
               required: "Please enter your mobile number",
               minlength: "Mobile number should be at least 10 digits",
               maxlength: "Mobile number should not exceed 15 digits",
               digits: "Mobile number should contain only digits"
            },
            house_number: {
               required: "Please enter your house number",
               minlength: "House number should be at least 1 character",
               maxlength: "House number should not exceed 50 characters"
            },
            street_name: {
               required: "Please enter your street name",
               minlength: "Street name should be at least 3 characters",
               maxlength: "Street name should not exceed 100 characters"
            },
            city: {
               required: "Please enter your city",
               minlength: "City should be at least 2 characters",
               maxlength: "City should not exceed 100 characters"
            },
            country: {
               required: "Please enter your country",
               minlength: "Country should be at least 2 characters",
               maxlength: "Country should not exceed 100 characters"
            },
            zip_code: {
               required: "Please enter your zip code",
               digits: "Zip code should contain only digits",
               minlength: "Zip code should be at least 5 digits",
               maxlength: "Zip code should not exceed 10 digits"
            }
         },
         submitHandler: function(form) {
            // Prevent the default form submission
            var formData = $(form).serialize();

            // Use AJAX to submit the form data
            $.ajax({
               url: '{{ route("website.saveaddress") }}', // The route to save the address
               type: 'POST',
               data: formData,
               success: function(response) {
                  if (response.success) {
                     // On success, close the modal
                     $('#addAddressModal').modal('hide');
                     alert('Address saved successfully!');
                     // Optionally, refresh the page to show the new address or update the UI
                     location.reload(); // You can customize this depending on the situation
                  } else {
                     alert(response.error || 'Something went wrong!');
                  }
               },
               error: function(xhr, status, error) {
                  alert('Error saving the address: ' + error);
               }
            });
         }
      });
   });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("paymentForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        // Show the loader before sending the request
        document.getElementById("globalLoader").style.display = "block";

        let formData = {
            _token: document.querySelector('meta[name="csrf-token"]').content, // Include CSRF token
        };

        fetch("{{ route('website.payment') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json",
                "Content-Type": "application/json", 
            },
            body: JSON.stringify(formData), // Send JSON data
        })
        .then(response => response.json())
        .then(data => {
            // Hide the loader after receiving response
            document.getElementById("globalLoader").style.display = "none";

            if (data.error) {
                alert("Payment Failed: " + data.message);
            } else {
                // Check if QR code exists in response
                if (data.qrCode) {
                    // Set QR code image source
                    document.getElementById("qrCodeImage").src = data.qrCode;
                    document.getElementById("paymentId").value = data.paymentId;
                    
                    // Show the modal
                    var qrModal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
                    qrModal.show();
                } else {
                    alert("QR Code not found in response.");
                }
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong!");
            
            // Hide the loader if an error occurs
            document.getElementById("globalLoader").style.display = "none";
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Check if payment form is submitted
    document.addEventListener("submit", function (event) {
        if (event.target && event.target.id === "paymentstatusForm") {
            event.preventDefault();

            let paymentId = document.getElementById("paymentId").value.trim();
            if (!paymentId) {
                alert("⚠ Payment ID is missing.");
                return;
            }

            // Make AJAX request to check payment status
            fetch(`/payment-status/${paymentId}`, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.status === "PAID") {
                        alert("✅ Payment Successful!");

                        // Show success modal if required
                        let successModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
                        successModal.show();

                        // Redirect after 3 seconds
                        setTimeout(() => {
                            window.location.href = "/"; // Change to your actual home route
                        }, 3000);
                    } else if (data.status === "FAILED") {
                        alert("❌ Payment Failed. Try Again.");
                    } else {
                        alert("⏳ Payment Pending.");
                    }
                } else {
                    alert("⚠ Error checking payment status.");
                }
            })
            .catch(error => {
                console.error("Error checking payment status:", error);
                alert("⚠ Something went wrong!");
            });
        }
    });

    // Show modal if errors exist (Blade logic inside JavaScript)
    @if ($errors->any())
        let refundModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
        refundModal.show();
    @endif

    // Handle "Pay Now" button click
    let payNowButton = document.getElementById("payNowButton");
    if (payNowButton) {
        payNowButton.addEventListener("click", function () {
            let orderId = this.getAttribute("data-order-id");

            // Get the selected address ID
            let selectedAddress = document.querySelector('input[name="selected_address"]:checked');
            if (!selectedAddress) {
                // alert("⚠ Please select a delivery address.");
                // return;
            }
            let addressId = selectedAddress.value;

            // Perform the AJAX request for payment
            fetch("/order/pay-now", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ address_id: addressId }) // Include the selected address ID
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success modal
                    let successModal = new bootstrap.Modal(document.getElementById("orderSuccessModal"), {
                        backdrop: "static",  // Prevent closing on click outside
                        keyboard: false      // Prevent closing with Esc key
                    });

                    successModal.show();

                    // Redirect to home page after 3 seconds
                    setTimeout(() => {
                        window.location.href = "{{ route('website.order') }}";
                    }, 3000);
                } else {
                   // alert("⚠ " + data.error);
                }
            })
            .catch(error => {
                // console.error("Error:", error);
                // alert("⚠ Something went wrong!");
            });
        });
    }
});



    document.addEventListener("DOMContentLoaded", function() {
    @if ($errors->any())
        var refundModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
        refundModal.show();
    @endif
    });
   document.getElementById('payNowButton').addEventListener('click', function () {
      var orderId = this.getAttribute('data-order-id');
      
      // Get the selected address ID
      var selectedAddress = document.querySelector('input[name="selected_address"]:checked');
      if (!selectedAddress) {
         alert('Please select a delivery address.');
         return;
      }
      var addressId = selectedAddress.value;

      // Perform the AJAX request for payment
      fetch('/order/pay-now', {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
         body: JSON.stringify({
            address_id: addressId // Include the selected address ID
         })
      })
      .then(response => response.json())
      .then(data => {
       if (data.success) {
    // Show success modal on successful payment
    $('#orderSuccessModal').modal({
        backdrop: 'static',  // Prevent closing on click outside
        keyboard: false      // Prevent closing with keyboard (Esc key)
    });

    $('#orderSuccessModal').modal('show');

    // Redirect to home page after modal opens
    setTimeout(function() {
        window.location.href = "{{ route('website.index') }}";
    }, 3000);  // Redirect after 3 seconds (adjust time if needed)
} else {
    alert(data.error);
}

      })
      .catch(error => {
         console.error('Error:', error);
         alert('Something went wrong!');
      });
   });
</script>
@include('website.footer')
