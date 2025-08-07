@include('website.header')

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<style>
/* Product box style */
.product-box {
    box-shadow: 0 0 10px rgba(0,0,0,0.08);
    padding: 15px;
    border-radius: 8px;
    background: #fff;
    text-align: center;
}
.owl-carousel .item {
    padding: 10px;
}

/* Pagination styles (not used now) */
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

/* No products found */
.no-products {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 60vh;
    background-color: #f9f9f9;
}
.img-center {
    max-width: 100%;
    height: auto;
    display: block;
}

/* Share button */
.share-btn {
    background-color: white;
    color: black;
    border: 2px solid #999;
    border-radius: 25px;
    padding: 8px 20px;
    text-align: center;
    font-weight: 500;
    min-width: 100px;
    transition: 0.3s;
}
.share-btn:hover {
    background-color: #f1f1f1;
    color: #000;
}

/* About section */
.library-about {
    padding: 20px 0;
    border-top: 1px solid #ddd;
    margin-top: 30px;
}
.about-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}
.about-description {
    font-size: 16px;
    line-height: 1.7;
    color: #555;
}
</style>

<div class="site-bg">
    <div class="brand-detail-bg">
        <!-- Library Detail Section -->
        <section class="brand-detail-banner section-padding">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="{{ $library->image ? $library->image : asset('/storage/assets/website/images/pr03.png') }}"
                            alt="{{ $library->name }}" class="img-fluid rounded" />
                    </div>
                    <div class="col-md-8">
                        <h2>{{ $library->name }}</h2>
                        <ul class="list-unstyled mt-3">
                            <li><strong>Address:</strong> {{ $library->address }}</li>
                            <li><strong>Phone:</strong> {{ $library->phone }}</li>
                            <li><strong>Email:</strong> {{ $library->email }}</li>
                        </ul>
                        <div class="social-share mt-4">
                            <h5>{{ __('messages.share_this_product') }}:</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('website.librarydetail', $library->id)) }}"
                                    target="_blank" class="share-btn">Facebook</a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('website.librarydetail', $library->id)) }}"
                                    target="_blank" class="share-btn">Twitter</a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode(route('website.librarydetail', $library->id)) }}"
                                    target="_blank" class="share-btn">WhatsApp</a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('website.librarydetail', $library->id)) }}"
                                    target="_blank" class="share-btn">LinkedIn</a>
                            </div>
                        </div>
                    </div>
                    <div class="library-about mt-5">
                        <h3 class="about-title">About</h3>
                        <p class="about-description">{{ $library->description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Other Libraries Carousel -->
        <section class="item-list-warper section-padding paddTop0">
            <div class="container">
                <h3 class="mb-4">Other Libraries</h3>

                @if($libraries->count() > 0)
                <div class="owl-carousel owl-theme">
                    @foreach($libraries as $pro)
                    <div class="item">
                        <div class="product-box p-3 border rounded h-100">
                            <figure class="mb-2">
                                <a href="{{ route('website.librarydetail', $pro->id) }}">
                                    <img src="{{ $pro->image ? $pro->image : asset('/storage/assets/website/images/pr03.png') }}"
                                        alt="{{ $pro->name }}" class="img-fluid" />
                                </a>
                            </figure>
                            <figcaption>
                                <h5>{{ $pro->name }}</h5>
                                <p class="mb-1"><strong>Phone:</strong> {{ $pro->phone }}</p>
                                <p><strong>Email:</strong> {{ $pro->email }}</p>
                            </figcaption>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="no-products col-12 text-center">
                    <img class="img-center"
                        src="https://stores.blackberrys.com/VendorpageTheme/Enterprise/EThemeForBlackberrys/images/product-not-found.jpg"
                        alt="No libraries found" />
                </div>
                @endif
            </div>
        </section>
    </div>
</div>

@include('website.footer')

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Initialize Owl Carousel -->
<script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        smartSpeed: 600,
        responsive: {
            0: { items: 1 },
            576: { items: 1 },
            768: { items: 2 },
            992: { items: 3 }
        }
    });
});
</script>
