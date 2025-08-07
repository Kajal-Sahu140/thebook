@include('website.header')
<div class="site-bg">
   <div class="dashborad-page-warper section-padding">
      <div class="container">
         <div class="dashborad-des-bg">
                       <div class="dashborad-sidebar">
               <div class="dashborad-sidebar-head">
                  <h3>{{$user->name}}</h3>
                  <p>{{$user->phone}}</p>
               </div>
               <div class="sidebar-menu">
                  <ul>
                     <li>
                        <a href="{{route('website.myprofile')}}">
                        <i class="ti ti-user"></i> 
                        <span>My Profile</span>
                        </a>
                     </li>
                     <li>
                        <a href="{{route('website.order')}}">
                        <i class="ti ti-package"></i>
                        <span>My Orders</span>
                        </a>
                     </li>
                     <li >
                        <a href="{{route('website.myaddress')}}">
                        <i class="ti ti-map-pin"></i>
                        <span>My Addresses</span>
                        </a>
                     </li>
                     <!-- <li class="active">
                        <a href="{{route('website.m')}}">
                        <i class="ti ti-lock"></i>
                        <span>Change Password</span>
                        </a>
                     </li> -->
                     <li>
                        <a href="javascript:;">
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
                        <a href="{{route('website.signOut')}}">
                        <i class="ti ti-rotate-clockwise"></i>
                        <span>Logout</span>
                        </a>
                     </li>
                  </ul>
               </div>
</div>
        <div class="dashborad-content-des">
               <div class="dashborad-title-head">
                  <h2>Change Password</h2>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" class="form-control" placeholder="Enter Old Password  "/> 
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" placeholder="Enter New Password"/> 
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" placeholder="Enter New Password"/> 
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
@include('website.footer')