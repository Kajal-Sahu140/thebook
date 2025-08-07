@include('website.header')
<style>
.star-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 1.2rem; /* Adjust size for responsiveness */
}

.star-rating .ti-star {
    color: #ccc; /* Default empty star color */
    transition: color 0.3s;
}

.star-rating .ti-star.filled {
    color: #FFD700; /* Filled star color */
}



/* Make sidebar and content stack vertically on small screens */
@media (max-width: 767px) {
    .dashborad-page-warper .row {
        flex-direction: column;
    }
    .dashborad-sidebar,
    .dashborad-content-des {
        width: 100%;
    }
    .dashborad-content-des {
        margin-top: 20px;
    }
}

/* Ensure order-list items adapt */
.order-product figure img {
    width: 80px;
    height: auto;
}

/* Handle the order date box nicely on mobile */
.order-date-box {
    margin-top: 20px;
}

.order-date-box {
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    max-width: 100%;
    overflow-x: hidden;
}
.order-date h5 {
    font-weight: bold;
    margin-bottom: 5px;
}
.order-date span {
    display: block;
}


</style>
<div class="site-bg">
    <div class="dashborad-page-warper section-padding">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="dashborad-sidebar">
                        <div class="dashborad-sidebar-head text-center">
                            <h3>{{ auth()->user()->name }}</h3>
                            <p>{{ auth()->user()->phone }}</p>
                        </div>
                 <div class="sidebar-menu">
                            <ul>
                                <li>
                                    <a href="{{ route('website.myprofile') }}">
                                        <i class="ti ti-user"></i>
                                        <span>{{ __('messages.my_profile') }}</span>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="{{ route('website.order') }}">
                                        <i class="ti ti-package"></i>
                                        <span>{{ __('messages.my_orders') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.myaddress') }}">
                                        <i class="ti ti-map-pin"></i>
                                        <span>{{ __('messages.my_address') }}</span>
                                    </a>
                                </li>
                                {{--<li>
                                    <a href="{{ route('website.mysavecard') }}">
                                        <i class="ti ti-credit-card"></i>
                                        <span>{{ __('messages.saved_cards') }}</span>
                                    </a>
                                </li>--}}
                                <li>
                                    <a href="{{ route('website.rating') }}">
                                        <i class="ti ti-star"></i>
                                        <span>{{ __('messages.reviews_ratings') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.signOut') }}">
                                        <i class="ti ti-rotate-clockwise"></i>
                                        <span>{{ __('messages.logout') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- Include the sidebar -->
                        </div>
                    </div>
                <div class="dashborad-content-des">
                    <!-- Order Details -->
                    <div class="dashborad-title-head">
                        <h2>{{__('messages.order')}} #{{ $order->order_id }}</h2>
                        <div class="order-delivered">
                            <a href="javascript:;">
                                <i><img src="{{asset('/storage/app/public/assets/website/images/blue-dot.png') }}" alt="dot" /></i>
                               @foreach ($order->cartItems as $item)
    <span>
        {{ $item->order_status ?? ucfirst($order->order_status) }}
    </span>
@endforeach
                            </a>
                        </div>
                        
                       
                    </div>


                    <!-- Ordered Items -->
                    <div class="order-list-bg">
                        <ul>
                            @foreach ($order->cartItems as $item)
    <li>
        <div class="order-product">
            <figure>
                <img src="{{ $item->product->images->first()->image_url ?? asset('images/default-product.png') }}" alt="order" />
            </figure>
            <figcaption>
                <h3>{{ $item->product->product_name }}</h3>

                <p>{{__('messages.total_price')}}: <span>RS. {{ $item->price }}</span> <br>{{__('messages.quantity')}} : {{$item->quantity}} </p>
            </figcaption>
        </div>
                      <div class="return-btn">
    @php
        $daysSinceOrder = $item->delivery_date ? $item->delivery_date->diffInDays(now()) : null;
        $isReturnable = $daysSinceOrder !== null && $daysSinceOrder <= 7 && $item->order_status === "delivered";
    @endphp
@if(($item->order_status ?? $order->order_status) != 'cancelled' && ($item->order_status ?? $order->order_status) != 'delivered')
    <div class="order-delivered">
        <form id="order-cancel-{{ $order->id }}" 
              action="{{ route('order.cancel', ['id' => $order->id]) }}" 
              method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="cart_id" value="{{ $item->id }}">
            <button type="button" class="btn" onclick="confirmCancel('{{ $order->id }}')">
                Order Cancel
            </button>
        </form>
    </div>
@endif
    @if($isReturnable)
        @if(empty($productReturnOrder))
            <a href="javascript:;" class="btn" data-bs-toggle="modal" data-bs-target="#ReturnModal">Return</a>
        @else
            <span>Already Returned</span>
        @endif
    @endif
</div>

                    </li>
                    @endforeach
                    </ul>
                    </div>
                    <!--<div class="order-date-box">-->
                    <!--    <div class="order-date">-->
                    <!--        <h5>{{__('messages.subtotal')}}</h5>-->
                    <!--        <span>RS. {{ $order->subtotal_price }}</span>-->
                             
                    <!--    </div>-->
                         
                    <!--    <div class="order-date" style="margin-left: 500px;">-->
                    <!--        <h5>{{__('messages.delivery_date')}}</h5>-->
                    <!--        <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-Y') }}</span>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="order-date-box row">-->
                    <!--    <div class="order-date col-12 col-md-6 mb-3">-->
                    <!--        <h5>{{__('messages.subtotal')}}</h5>-->
                    <!--        <span>RS. {{ $order->subtotal_price }}</span>-->
                    <!--    </div>-->
                    
                    <!--    <div class="order-date col-12 col-md-6 mb-3">-->
                    <!--        <h5>{{__('messages.delivery_date')}}</h5>-->
                    <!--        <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-Y') }}</span>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!-- Shipping Address -->
                    <!--<div class="order-date col-12 mb-3">-->
                    <!--    <h5>{{__('messages.shipping_address')}}</h5>-->
                    <!--    <span>{{ $order->order_address }}</span>-->
                    <!--</div>-->
                    <div class="order-date-box row">
    <div class="order-date col-12 col-md-6 mb-3">
        <h5>{{__('messages.subtotal')}}</h5>
        <span>RS. {{ $order->subtotal_price }}</span>
    </div>

    <div class="order-date col-12 col-md-6 mb-3">
        <h5>{{__('messages.delivery_date')}}</h5>
        <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-Y') }}</span>
    </div>

    <div class="order-date col-12 mb-3">
        <h5>{{__('messages.shipping_address')}}</h5>
        <span>{{ $order->order_address }}</span>
    </div>
</div>
                    @if($order->order_status == 'delivered')
                    <div class="add-download-btn">
                        <ul>
                            <li>
    @if(!$productRating)
        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#ReviewRatingModal">
            <i class="ti ti-star"></i>
            <span>{{__('messages.addreview_rating')}}</span>
        </a>
    @else
        <div style="margin-top: 10px; color: #333;">
            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                    <i class="ti ti-star {{ $i <= $productRating->rating ? 'filled' : '' }}"></i>
                @endfor
            </div>
            @if($productRating->review)
                <strong>Your Review:</strong> {{ $productRating->review }}
            @else
                <strong>Your Review:</strong> No review provided.
            @endif
        </div>
    @endif
</li>
                    <li>
    <a href="{{ route('website.download.invoice', ['order_id' => $order->id, 'product_id' => $item->product->product_id]) }}">
        <i class="ti ti-download"></i>
        <span>{{__('messages.invoice_download')}}</span>
    </a>
</li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.footer')
<!-- Modals -->
<!-- Return Modal -->
<div class="modal fade" id="ReturnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Return your product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                   $daysSinceOrder = $item->delivery_date ? $item->delivery_date->diffInDays(now()) : null; 
                @endphp

                @if($daysSinceOrder > 7)
                    <div class="alert alert-danger">
                        The return window for this product has expired. Returns are allowed only within 7 days of purchase.
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @else
                    <p>Select the reason to return the product. You can return this product within 7 days of deliver.</p>
                    <form action="{{ route('website.productreturn') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Reason</label>
                            <select class="form-control" name="reason_id" id="reason_id" required>
                                <option value="">Select Reason</option>
                                @foreach($reason as $reasons)
                                    <option value="{{ $reasons->id }}">{{ $reasons->reason }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label>Comments (optional)</label>
                            <textarea class="form-control" name="return_comments" maxlength="250" rows="4" placeholder="Add any additional comments"></textarea>
                        </div>
                        <div class="form-submit-btn">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Review & Rating Modal -->
<!-- Modal for Review & Rating -->
<div class="modal fade" id="ReviewRatingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Review & Rating</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm" action="{{ route('website.addreview') }}" method="POST">
    @csrf
    <div class="order-rating">
        <h4>Rate Product</h4>
        <div class="rating-box">
            <i class="ti ti-star-filled" data-rating="1"></i>
            <i class="ti ti-star-filled" data-rating="2"></i>
            <i class="ti ti-star-filled" data-rating="3"></i>
            <i class="ti ti-star-filled" data-rating="4"></i>
            <i class="ti ti-star-filled" data-rating="5"></i>
        </div>
            @error('rating')
            <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
        @enderror
       
    </div>
   <div class="form-group">
    <label>Add Review</label>
    <textarea name="review" id="review" class="form-control" maxlength="250" placeholder="Write your review" required></textarea>
    <small id="review-error" class="text-danger" style="display: none;">Review must start with a character and cannot begin with spaces.</small>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const reviewInput = document.getElementById('review');
        const review = reviewInput.value;

        // Check if review starts with a non-space character
        if (review.trim().length === 0 || review[0] === ' ') {
            event.preventDefault();
            document.getElementById('review-error').style.display = 'block';
        } else {
            document.getElementById('review-error').style.display = 'none';
            reviewInput.value = review.trim(); // Trim spaces before submission
        }
    });
</script>


    <input type="hidden" name="product_id" value="{{ $product->product_id }}" />
    <input type="hidden" name="rating" id="rating" value="1" /> <!-- Default set to 1 -->
    <input type="hidden" name="order_id" value="{{ $order->id }}" />
    <div class="form-submit-btn">
        <button type="submit" class="btn">Submit</button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
<script>



</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingIcons = document.querySelectorAll('.rating-box i');
    const ratingInput = document.getElementById('rating');
    ratingIcons.forEach((icon, index) => {
        icon.addEventListener('click', function() {
            ratingInput.value = index + 1;
            ratingIcons.forEach((star, i) => {
                star.classList.toggle('active', i <= index);
            });
        });
    });
});
 $.validator.addMethod("noSpace", function(value, element) { 
        return value.trim().length > 0 && value.trim() === value; 
    }, "Review must start with a character and cannot begin with spaces.");
    $(document).ready(function () {
        let selectedRating = 0;

        $('.rating-box i').on('click', function () {
            selectedRating = $(this).data('rating');
            $('#rating').val(selectedRating);

            // Highlight the selected stars
            $('.rating-box i').removeClass('selected');
            $(this).prevAll().addBack().addClass('selected');
        });

        $.validator.addMethod("ratingRequired", function (value, element) {
            return value > 0;
        }, "Please select at least one star for rating.");
    });
    // Form validation using jQuery Validate
    $("#ratingForm").validate({
        rules: {
            review: {
                required: true,
                minlength: 3,                 // Minimum 3 characters
                maxlength: 250,
                noSpace: true
            },
            rating: {
                required: true,
                min: 1,
                max: 5
            }
        },
        messages: {
            review: {
                required: "Please enter your review.",
                minlength: "Review must be at least 3 characters long.",
                maxlength: "Review cannot exceed 250 characters.",
                noSpace: "Review must start with a character and cannot begin with spaces."
            },
            rating: {
                required: "Please select a rating.",
                min: "Please select a valid rating.",
                max: "Rating must be between 1 and 5."
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("text-danger mt-1");
            element.closest(".form-group").append(error);
        },
        submitHandler: function (form) {
            form.submit();  // Submit form if validation passes
        }
    });

    // Prevent form submission if validation fails
    $('#ratingForm').on('submit', function (e) {
        if (!$("#ratingForm").valid()) {
            e.preventDefault(); // Prevent submission if invalid
        }
    });

    // Clear form validation errors when the modal is closed
    $('#ReviewRatingModal').on('hidden.bs.modal', function () {
        $('#ratingForm')[0].reset();  // Reset the form
        $("#ratingForm").validate().resetForm();  // Reset validation messages
        $('.rating-box i').removeClass('active');  // Remove star highlights
        $('#rating').val(0);  // Reset rating value
    });



</script>
<script>
    //  function confirmCancel(orderId) {
    //     if (confirm("Are you sure you want to cancel this order?")) {
    //         document.getElementById('order-cancel-' + orderId).submit();
    //     }
    // }
    function confirmCancel(orderId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be cancel order!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, cancel it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('order-cancel-' + orderId).submit();
            }
        });
    }
</script>