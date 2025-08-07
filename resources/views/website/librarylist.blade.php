@include('website.header')

<style>
.product-box {
    border: 1px solid #eaeaea;
    padding: 15px;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    text-align: center;
}
.product-box img {
    max-width: 100%;
    height: auto;
}
</style>

<section class="amazing-deals-section section-padding">
    <div class="container">
        <div class="section-head mb-4">
            <h2>Library</h2>
        </div>
        <div class="row" id="library-container">
            @include('website.partials.library_item', ['libraries' => $libraries])
        </div>
        @if ($libraries->hasMorePages())
            <div class="text-center mt-4">
                <button id="load-more-btn" class="btn btn-primary" data-url="{{ $libraries->nextPageUrl() }}">
                    Load More
                </button>
            </div>
        @endif
    </div>
</section>

@include('website.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '#load-more-btn', function () {
    var button = $(this);
    var nextPage = button.data('url');

    if (nextPage) {
        button.prop('disabled', true).text('Loading...');
        $.get(nextPage, function (response) {
            $('#library-container').append(response.html);

            if (response.nextPageUrl) {
                button.data('url', response.nextPageUrl).prop('disabled', false).text('Load More');
            } else {
                button.remove(); // Hide button if no more pages
            }
        }).fail(function () {
            button.text('Load Failed').prop('disabled', false);
        });
    }
});
</script>
