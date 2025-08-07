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
                                <li class="active">
                                    <a href="{{ route('website.myaddress') }}">
                                        <i class="ti ti-map-pin"></i>
                                        <span>My Addresses</span>
                                    </a>
                                </li>
                                <li>
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
               <div class="dashborad-title-head">
                  <h2>Add New Card</h2>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Add New Card</label>
                        <input type="text" class="form-control" placeholder="Enter Card Number"/> 
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Card Holder Name</label>
                        <input type="text" class="form-control" placeholder="Enter Card Holder Name"/> 
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Expiry</label>
                        <input type="text" class="form-control" placeholder="Enter Expiry"/> 
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>CVV</label>
                        <input type="text" class="form-control" placeholder="Enter CVV"/> 
                     </div>
                  </div>
               </div>
               <div class="save-btn mar-top15">
                  <button class="btn">Save</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('website.footer')
