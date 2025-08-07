@include('website.header')
<style>


.sold-out-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
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
   <div class="inner-page-warper">
      <section class="search-content-warper section-padding">
         <div class="container">
            @if(!empty($query))
            <h2>{{__('messages.serach_page')}} "{{ $query }}"</h2>
            @endif
            @if($products->count() > 0)
               <div class="row">
                  @foreach($products as $product)
                 
                     <div class="col-md-3">
    <div class="product-box">
       
        <a href="{{ $product->quantity > 0 ? route('website.productdetail', ['id' => $product->sku]) : route('website.productdetail', ['id' => $product->sku]) }}" 
           class="{{ $product->quantity <= 0 ? 'disabled-link' : '' }}">
            <figure>
                @foreach($product->images as $image)
                    <img src="{{ $image->image_url }}" alt="{{ $product->product_name }}"/>
                   
                @endforeach
                 @if ($product->quantity <= 0)
            <div class="sold-out-overlay">Sold Out</div>
        @endif
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
                        $rating = $product->rating ?? 0;  
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
                @php
                    $discountedPrice = $product->base_price - ($product->base_price * ($product->discount / 100));
                @endphp
                <span>{{ $discountedPrice }} IQD</span>
            </figcaption>
        </a>
    </div>
</div>

                  @endforeach
               </div>
               
               <!-- Pagination Links -->
               <div class="pagination-box">
                  {{ $products->links('pagination::bootstrap-4') }} <!-- Laravel's pagination links -->
               </div>
            @else
               <p>No products found for "{{ $query }}".</p>
            @endif
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
                  window.location.reload();      
                    // Show success message
                   // alert(data.message);

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
