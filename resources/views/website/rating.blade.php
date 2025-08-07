@include('website.header')
<div class="site-bg">
    <div class="dashborad-page-warper section-padding">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                    <div class="dashborad-sidebar">
                        <div class="dashborad-sidebar-head text-center">
                            <h3>{{ $user->name }}</h3>
                            <p>{{ $user->phone }}</p>
                        </div>
                        <div class="sidebar-menu">
                            <ul>
                                <li>
                                    <a href="{{ route('website.myprofile') }}">
                                        <i class="ti ti-user"></i>
                                        <span>{{ __('messages.my_profile') }}</span>
                                    </a>
                                </li>
                                <li>
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
                                <li>
                                    <a href="{{ route('website.mysavecard') }}">
                                        <i class="ti ti-credit-card"></i>
                                        <span>{{ __('messages.saved_cards') }}</span>
                                    </a>
                                </li>
                                <li class="active">
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
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="dashborad-content-des">
                        <div class="dashborad-title-head">
                            <h2>{{ __('messages.reviews_ratings') }}</h2>
                        </div>
                        <div class="review-rating-list">
                            <ul class="list-unstyled">
                                @foreach($productrating as $rating)
                                <li class="d-flex flex-wrap mb-4">
                                    <div class="review-user-box d-flex align-items-start">
                                        <figure class="me-3">
                                            <img src="{{ $rating->product->images->first()->image_url ?? asset('images/default-product.png') }}" 
                                                     alt="{{ $rating->product->product_name }}" 
                                                     class="img-fluid" 
                                                     >
                                        </figure>
                                        <div>
                                            <h3 class="mb-1">{{ $rating->product->product_name }}</h3>
                                            <div class="price mb-2 text-primary">IQD {{ $rating->product->base_price }}</div>
                                            <p class="mt-2 text-muted">
                                            {{ $rating->review ?? 'No review provided.' }}
                                        </p>
                                            <div class="day-ago text-muted">{{ $rating->created_at->diffForHumans() }}</div>
                                            <div class="rating-box mt-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                        <i class="ti ti-star-filled {{ $i <= $rating->rating ? 'active' : '' }}"></i>
                                                    @endfor
                                            </div>
                                        </div>

                                    </div>

                                  
                                </li>
                                @endforeach
                            </ul>
                             @if($productrating->isEmpty())
                                <p class="text-center text-muted">You haven't reviewed any products yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.footer')
