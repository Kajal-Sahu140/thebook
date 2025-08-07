@foreach ($libraries as $prod)
    <div class="col-md-4 mb-4">
        <div class="product-box">
            <figure>
                <a href="{{ route('website.librarydetail', ['id' => $prod->id]) }}">
                    <img src="{{ $prod->image ?? 'https://dummyimage.com/600x400/ccc/fff' }}" alt="product" />
                </a>
            </figure>
            <figcaption>
                <h4>{{ $prod->name }}</h4>
            </figcaption>
        </div>
    </div>
@endforeach
