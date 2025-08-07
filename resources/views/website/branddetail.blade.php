@include('website.header')
<style>
   .pagination {
   justify-content: center;
   margin-top: 20px;
   }
   .pagination li {
   margin: 0 5px;
   }
   .pagination a, .pagination span {
   padding: 8px 16px;
   border-radius: 50%;
   font-size: 16px;
   }
   .pagination .active a {
   background-color: #007bff;
   color: #fff;
   }
   /* Center the container */
   .no-products {
   display: flex;
   justify-content: center;
   align-items: center;
   text-align: center;
   height: 60vh; /* Optional: Full page height */
   padding: 0px; /* Optional: Add some spacing */
   background-color: #f9f9f9; /* Optional: Light background */
   }
   /* Make the image responsive */
   .img-center {
   max-width: 100%; /* Ensures the image scales down */
   height: auto; /* Maintain aspect ratio */
   display: block; /* Ensures it's treated as a block element */
   }
   .slider-container {
   position: relative;
   width: 100%;
   margin: 20px 0;
   }
   .range-input {
   position: absolute;
   width: 100%;
   pointer-events: none; /* Allows user to interact with one range at a time */
   -webkit-appearance: none;
   appearance: none;
   height: 0;
   z-index: 2;
   outline: none;
   }
   .range-input::-webkit-slider-thumb {
   pointer-events: all;
   position: relative;
   z-index: 3;
   width: 20px;
   height: 20px;
   background: #007bff;
   border-radius: 50%;
   border: 2px solid #fff;
   cursor: pointer;
   -webkit-appearance: none;
   appearance: none;
   }
   .range-input::-moz-range-thumb {
   width: 20px;
   height: 20px;
   background: #007bff;
   border-radius: 50%;
   border: 2px solid #fff;
   cursor: pointer;
   }
   .progress-bar {
   position: absolute;
   height: 6px;
   background: #007bff;
   z-index: 1;
   top: 50%;
   transform: translateY(-50%);
   border-radius: 5px;
   }
   .value-container {
   display: flex;
   justify-content: space-between;
   margin-top: 10px;
   font-size: 14px;
   }
   .color-list ul {
   list-style: none;
   padding: 0;
   display: flex;
   flex-wrap: wrap;
   gap: 10px;
   }
   .color-list li {
   display: flex;
   align-items: center;
   justify-content: center;
   cursor: pointer;
   }
   .color-list label {
   display: flex;
   align-items: center;
   cursor: pointer;
   }
   .color-list input[type="checkbox"] {
   display: none; /* Hide the checkbox */
   }
   .color-list input[type="checkbox"]:checked + div {
   border: 2px solid #007bff; /* Highlight selected colors */
   box-shadow: 0 0 9px #007bff;
   }
   #applyFilters {
   margin-top: 20px;
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
</style>
<?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
   <div class="brand-detail-bg">
      <section class="brand-detail-banner section-padding">
         <div class="container">
            <img src="https://thebookdoor.in/storage/app/public/banners/web/5Bw6jzznIOT0Q6L4iGAOGM5kpOGIcqz0F3GrMuPa.jpg" alt="brand-banner" height="258px"/>
         </div>
      </section>
      <section class="item-list-warper section-padding paddTop0">
         <div class="container">
            <div class="item-list-content">
               <div class="item-filter">
                  <div class="filter-head">
                     <h3>{{ __('messages.filters') }}</h3>
                     <div class="clear-all">
                        <a href="javascript:;" onclick="clearQueryParams()">{{ __('messages.clearall') }}</a>
                     </div>
                  </div>
                  <!-- Filters -->
                  <div class="accordion" id="accordionExample">
                     <!-- Age Group Filter -->
                     <div class="accordion-item">
{{--h2 class="accordion-header">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                           {{ __('messages.age_group') }}
                           </button>
                        </h2>--}}
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                          {{-- <div class="accordion-body">
                              <div class="age-group">
                                 @if($size->isNotEmpty())
                                 @foreach($size as $value)
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$value->id}}" id="check{{$value->id}}">
                                    @if($currentLang == 'en')
                                    <label class="form-check-label" for="check{{$value->id}}">{{$value->name}}</label>
                                    @elseif($currentLang == 'ar')
                                    <label class="form-check-label" for="check{{$value->id}}">{{$value->name_ar}}</label>
                                    @elseif($currentLang == 'cku')
                                    <label class="form-check-label" for="check{{$value->id}}">{{$value->name_cku}}</label>
                                    @else
                                    <label class="form-check-label" for="check{{$value->id}}">{{$value->name}}</label>
                                    @endif
                                 </div>
                                 @endforeach
                                 @else
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="check01">
                                    <label class="form-check-label" for="check01">Size Not Found</label>
                                 </div>
                                 @endif
                              </div>
                           </div>--}}
                        </div>
                     </div>
                     <!-- Price Filter -->
                     <div class="accordion-item">
                        <h2 class="accordion-header">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                              data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                           {{ __('messages.price') }}
                           </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              <div class="slider-container">
                                 <input type="range" min="0" max="{{$max_price}}" value="0" class="range-input" id="minRange">
                                 <input type="range" min="10" max="{{$max_price}}" value="{{$max_price}}" class="range-input" id="maxRange">
                                 <div class="progress-bar" id="progress"></div>
                                 <div class="value-container">
                                    <span id="minValue">{{$min_price}} Rs.</span>
                                    <span id="maxValue">{{$max_price}} Rs.</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Color Filter -->
                     {{--<div class="accordion-item">
                        <h2 class="accordion-header">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                              data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                           {{ __('messages.color') }}
                           </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                           <div class="accordion-body">
                              <div class="color-list">
                                 <ul>
                                    @if($color->isNotEmpty())
                                    @foreach($color as $col)
                                    <li>
                                       <label>
                                          <input type="checkbox" value="{{ $col->id }}" class="color-checkbox">
                                          <div style="width: 20px; height: 20px; border-radius: 50%; 
                                             background-color: {{ $col->hex_code }}; border: 1px solid #ccc;" 
                                             title="{{ $col->name }}">
                                          </div>
                                       </label>
                                    </li>
                                    @endforeach
                                    @else
                                    <li>No colors available</li>
                                    @endif
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>--}}
                     <!-- Filter Button -->
                     <div class="accordion-item">
                        <div class="accordion-body">
                           <button id="applyFilters" class="btn btn-primary" style="margin-top: 20px;">{{ __('messages.apply_filter') }}</button>
                        </div>
                     </div>
                  </div>
               </div>
          
               <div class="item-content-des mt-3">
                  <div class="row">
                     @if($products->count() > 0)
                     @foreach($products as $pro)
                     @php
                     $isSoldOut = $pro->quantity <= 0; // Check if the product is sold out
                     $discountedPrice = $pro->base_price - ($pro->base_price * ($pro->discount / 100)); // Calculate discounted price
                     @endphp
                     <div class="col-md-4">
                        <div class="product-box">
                           <figure>
                              <!-- Product Link -->
                              <a href="{{route('website.productdetail', ['id' => $pro->sku])}}" 
                                 class="{{ $isSoldOut ? 'disabled-link' : '' }}">
                                 @if ($pro->images->isNotEmpty())
                                 @foreach ($pro->images as $image)
                                 <img src="{{ $image->image_url }}" alt="product" />
                                 @endforeach
                                 @else
                                 <img src="{{ asset('/storage/assets/website/images/pr03.png') }}" alt="default product" />
                                 @endif
                                 <!-- Sold Out Overlay -->
                                 @if($isSoldOut)
                                 <div class="sold-out-overlay">Sold Out</div>
                                 @endif
                              </a>
                              <!-- Wishlist Button -->
                              <div class="product-like-heart" 
                                 style="background-color: {{ $pro->is_wishlisted ? '#62c6bf' : '' }};" 
                                 data-product-id="{{ $pro->product_id }}">
                                 <i class="ti ti-heart"></i>
                              </div>
                           </figure>
                           <figcaption>
                              @if($currentLang == 'en')
                              <h4>{{ $pro->product_name }}</h4>
                              @elseif($currentLang == 'ar')
                              <h4>{{ $pro->product_name_ar }}</h4>
                              @elseif($currentLang == 'cku')
                              <h4>{{ $pro->product_name_cku }}</h4>
                              @else
                              <h4>{{ $pro->product_name }}</h4>
                              @endif
                              <div class="rating-box">
                                 @php
                                 $rating = $pro->rating;  // Get the rating value
                                 $fullStars = floor($rating);  // Number of full stars
                                 $halfStar = ($rating - $fullStars) >= 0.5;  // Check for half star
                                 $emptyStars = 5 - ceil($rating);  // Empty stars
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
                              <span>{{ number_format($discountedPrice, 2) }} Rs.</span>
                           </figcaption>
                        </div>
                     </div>
                     @endforeach
                     @else
                     <div class="no-products">
                        <img class="img-center" src="https://stores.blackberrys.com/VendorpageTheme/Enterprise/EThemeForBlackberrys/images/product-not-found.jpg" alt="No products found" />
                     </div>
                     @endif
                  </div>
                  <!-- Dynamic Pagination -->
                  <div class="pagination-box">
                     {{ $products->links('pagination::bootstrap-4') }}  <!-- Display pagination links -->
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
</div>
<script>
   document.addEventListener("DOMContentLoaded", () => {
     const applyFiltersButton = document.getElementById("applyFilters");
     const pre_url = "{{ url()->current() }}";
   
     const urlParams = new URLSearchParams(window.location.search);
   
     const selectedAgeGroups = urlParams.get('age_group');
     const selectedColors = urlParams.get('colors');
     const selectedPriceMin = urlParams.get('price_min');
     const selectedPriceMax = urlParams.get('price_max');
   
     const minRange = document.getElementById('minRange');
     const maxRange = document.getElementById('maxRange');
     const progress = document.getElementById('progress');
     const minValue = document.getElementById('minValue');
     const maxValue = document.getElementById('maxValue');
   
     // Preselect filters
     const preselectFilters = () => {
         if (selectedAgeGroups) {
             selectedAgeGroups.split(',').forEach(id => {
                 const checkbox = document.querySelector(`.form-check-input[value='${id}']`);
                 if (checkbox) checkbox.checked = true;
             });
         }
   
         if (selectedColors) {
             selectedColors.split(',').forEach(id => {
                 const checkbox = document.querySelector(`.color-checkbox[value='${id}']`);
                 if (checkbox) checkbox.checked = true;
             });
         }
   
         if (selectedPriceMin) {
             minRange.value = selectedPriceMin;
             minValue.textContent = `${selectedPriceMin} Rs.`;
         }
   
         if (selectedPriceMax) {
             maxRange.value = selectedPriceMax;
             maxValue.textContent = `${selectedPriceMax} Rs.`;
         }
   
         updateSliderProgress();
     };
   
     // Update slider progress
     const updateSliderProgress = () => {
         const minVal = parseInt(minRange.value);
         const maxVal = parseInt(maxRange.value);
   
         minValue.textContent = `${minVal} Rs.`;
         maxValue.textContent = `${maxVal} Rs.`;
   
         const minPercent = ((minVal - minRange.min) / (minRange.max - minRange.min)) * 100;
         const maxPercent = ((maxVal - maxRange.min) / (maxRange.max - minRange.min)) * 100;
   
         progress.style.left = `${minPercent}%`;
         progress.style.right = `${100 - maxPercent}%`;
     };
   
     minRange.addEventListener('input', updateSliderProgress);
     maxRange.addEventListener('input', updateSliderProgress);
   
     // Fetch filtered data
     const fetchFilteredData = () => {
         const ageGroups = [...document.querySelectorAll('.form-check-input:checked')].map(cb => cb.value).join(',');
         const colors = [...document.querySelectorAll('.color-checkbox:checked')].map(cb => cb.value).join(',');
         const priceMin = minRange.value || 0;
         const priceMax = maxRange.value || 100000;
   
         const params = new URLSearchParams();
         if (ageGroups) params.append('age_group', ageGroups);
         if (colors) params.append('colors', colors);
         params.append('price_min', priceMin);
         params.append('price_max', priceMax);
   
         window.location.href = `${pre_url}?${params.toString()}`;
     };
   
     applyFiltersButton.addEventListener('click', fetchFilteredData);
   
     preselectFilters();
   });
   
   function clearQueryParams() {
     // Get the current URL
     var currentUrl = window.location.href;
   
     // Remove everything after the '?' (the query parameters)
     var newUrl = currentUrl.split('?')[0];
   
     // Redirect to the new URL without the query parameters
     window.location.href = newUrl;
   }
   
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
                    // alert(data.message);
                    window.location.reload();      
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