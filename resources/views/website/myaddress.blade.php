@include('website.header')
<div class="site-bg">
    <div class="dashborad-page-warper section-padding">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4 col-sm-12">
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
                                <li class="active">
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
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="dashborad-content-des">
                        <div class="dashborad-title-head d-flex justify-content-between align-items-center">
                            <h2>{{ __('messages.my_address') }}</h2>
                        </div>
                        <!-- Addresses List -->
                        <div class="my-addresses-list mt-4">
                            <ul class="list-unstyled">
                                @foreach($addresses as $address)
    <li class="mb-4">
        <div class="my-addresses-box p-3 border rounded d-flex flex-column flex-md-row align-items-md-center {{ $address->make_as_default ? 'default-address' : '' }}" >
            <div class="address-details flex-grow-1">
                <h3 class="mb-1">{{ $address->name }}
                    @if($address->make_as_default)
                        <span class="badge bg-success">Default</span>
                    @endif
                </h3>
                <p class="mb-1">{{ $address->city }}, {{ $address->country }} {{ $address->zip_code }}</p>
                <p class="mb-0">{{ $address->country_code.' '.$address->mobile_number }}</p>
            </div>
            <div class="edit-delete-btn mt-3 mt-md-0 d-flex">
                <a href="{{ route('website.editaddress', $address->id) }}" class="btn btn-outline-primary btn-sm me-2 d-flex align-items-center">
                    <i class="ti ti-edit me-1"></i>
                    <span>{{ __('messages.edit') }}</span>
                </a>
                @if(!$address->make_as_default)
                <form action="{{ route('website.deleteaddress', $address->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm delete-address-btn">{{ __('messages.delete') }}</button>
                    </form>
                @endif
            </div>
        </div>
    </li>
@endforeach

                            </ul>
                        </div>
                        <!-- Add Address Button -->
                        <div class="add-address-btn text-center mt-4">
                            <a href="{{ route('website.addnewaddress') }}" class="btn btn-primary">{{ __('messages.add_new') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Address Confirmation Modal -->
<div class="modal fade" id="deleteAddressModal" tabindex="-1" role="dialog" aria-labelledby="deleteAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAddressModalLabel">Delete Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this address?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

@include('website.footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-address-btn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            const confirmation = confirm('Are you sure you want to delete this address?');
            if (!confirmation) {
                event.preventDefault();
            }
        });
    });
});


</script>
