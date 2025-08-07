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
                                        <span>My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.order') }}">
                                        <i class="ti ti-package"></i>
                                        <span>My Orders</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.myaddress') }}">
                                        <i class="ti ti-map-pin"></i>
                                        <span>My Addresses</span>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="{{route('website.mysavecard')}}">
                                        <i class="ti ti-credit-card"></i>
                                        <span>Saved Cards</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('website.rating')}}">
                                        <i class="ti ti-star"></i>
                                        <span>Reviews & Ratings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.signOut') }}">
                                        <i class="ti ti-rotate-clockwise"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="dashborad-content-des">
                        <!-- Title -->
                        <div class="dashborad-title-head d-flex justify-content-between align-items-center">
                            <h2>Saved Cards</h2>
                        </div>
                        <!-- Saved Cards List -->
                        <div class="my-addresses-list mt-4">
                            <ul class="list-unstyled row">
                                <!-- Card Item -->
                                <li class="mb-4">
                                    <div class="save-card-box p-3 border rounded shadow-sm">
                                        <div class="save-card-head d-flex justify-content-between align-items-center mb-3">
                                            <i>
                                                <img src="images/card.png" alt="Card" class="img-fluid" style="width: 50px;" />
                                            </i>
                                            <a href="javascript:;" class="delete-btn text-danger d-flex align-items-center">
                                                <i class="ti ti-trash me-2"></i>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                        <h5 class="mb-3 text-center">XXXX XXXX XXXX 2567</h5>
                                        <div class="card-info-bg d-flex justify-content-between">
                                            <div class="card-user-info-box">
                                                <p class="mb-1 text-muted">Cardholder Name</p>
                                                <h4 class="m-0">Michael Bruno</h4>
                                            </div>
                                            <div class="card-user-info-box">
                                                <p class="mb-1 text-muted">Expiry</p>
                                                <h4 class="m-0">01/24</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- Repeat Card Item -->
                                <li class="mb-4">
                                    <div class="save-card-box p-3 border rounded shadow-sm">
                                        <div class="save-card-head d-flex justify-content-between align-items-center mb-3">
                                            <i>
                                                <img src="images/card.png" alt="Card" class="img-fluid" style="width: 50px;" />
                                            </i>
                                            <a href="javascript:;" class="delete-btn text-danger d-flex align-items-center">
                                                <i class="ti ti-trash me-2"></i>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                        <h5 class="mb-3 text-center">XXXX XXXX XXXX 2567</h5>
                                        <div class="card-info-bg d-flex justify-content-between">
                                            <div class="card-user-info-box">
                                                <p class="mb-1 text-muted">Cardholder Name</p>
                                                <h4 class="m-0">Michael Bruno</h4>
                                            </div>
                                            <div class="card-user-info-box">
                                                <p class="mb-1 text-muted">Expiry</p>
                                                <h4 class="m-0">01/24</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Add New Card Button -->
                        <div class="add-address-btn text-center mt-4">
                            <a href="{{route('website.addnewcard')}}" class="btn btn-primary">Add New Card</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.footer')
