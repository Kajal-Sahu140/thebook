@include('website.header')
<style>
  .form-group .error {
    font-size: 14px;
    color: red;
    font-weight: 600;
    margin-bottom: 8px;
}
#mobile-error{
   margin-top: 2px;
    margin-right: 10pc;
}
.form-control.country_code {
    width: 80px;
    flex: 0 0 90px;
}
    </style>
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
                       <div class="dashborad-title-head">
                          <h2>{{ __('messages.add_new_address') }}</h2>
                       </div>
                       <form id="contactForm" method="POST" action="{{ route('website.saveaddress') }}">
                          @csrf
                          <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.name') }}</label>
                                    <input type="text" class="form-control" name="name" oninput="this.value = this.value.trimStart()" placeholder="Enter Name" value="{{ old('name') }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.address') }}</label>
                                    <input type="text" class="form-control" name="address" oninput="this.value = this.value.trimStart()" placeholder="Enter Address" value="{{ old('address') }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                 <label for="mobile">{{ __('messages.mobile') }} <sup>*</sup></label>
                                 <!-- Country Code Dropdown -->
                                 <div class="input-group">
                                    <select name="country_code" id="country_code" class="form-control country_code @error('country_code') is-invalid @enderror">   
                                          <!-- @foreach($country_codes as $code)
                                             <option value="{{ $code->code }}" {{ old('country_code') == $code->code ? 'selected' : '' }}>{{ $code->code }}</option>
                                          @endforeach -->
                                           <option value="+964">+964</option>
                                    </select>

                                    <!-- Mobile Input Field -->
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                             id="mobile" 
                                             name="mobile" 
                                             placeholder="Enter Mobile" 
                                             value="{{ old('mobile') }}" 
                                              oninput="validateWhatsappNumber(this)" /><br>
                                              <script>
                                              function validateWhatsappNumber(input) {
                                              input.value = input.value.replace(/[^0-9]/g, ''); // Allow only numbers

                                              const invalidNumbers = /^0+$/; // Matches all zeros
                                              if (invalidNumbers.test(input.value)) {
                                                  document.getElementById('mobile-error').innerText = "Invalid number (e.g., 00000 not allowed).";
                                                  input.value = ""; // Clear input
                                              } else {
                                                  document.getElementById('mobile-error').innerText = "";

                                              }

                                              </script>
                                    
                                    @error('mobile')
                                          <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                                 </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.house_number') }}</label>
                                    <input type="text" class="form-control" name="house_number" placeholder="Enter House Number" value="{{ old('house_number') }}" /> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.street_name') }}</label>
                                    <input type="text" class="form-control" oninput="this.value = this.value.trimStart()" name="street_name" placeholder="Enter Street Name" value="{{ old('street_name') }}"oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.landmark') }}</label>
                                    <input type="text" class="form-control" oninput="this.value = this.value.trimStart()"  maxlength="150"  name="landmark" placeholder="Enter Landmark" value="{{ old('landmark') }}"oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.city') }}</label>
                                    <input type="text" class="form-control" oninput="this.value = this.value.trimStart()"  name="city" placeholder="Enter City" value="{{ old('city') }}"oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.country') }}</label>
                                    <input type="text" class="form-control" oninput="this.value = this.value.trimStart()"  name="country" placeholder="Enter Country" value="{{ old('country') }}"oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('messages.zip_code') }}</label>
                                    <input type="number" class="form-control" name="zip_code" placeholder="Enter Zip Code" value="{{ old('zip_code') }}"oninput="this.value = this.value.replace(/[^0-9]/g, '')"/> 
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Make as Default</label>
                                    <input type="checkbox" name="make_as_default" value="1"/> 
                                 </div>
                              </div>
                          </div>
                          <div class="save-btn mar-top15">
                              <button class="btn" type="submit">{{ __('messages.save') }}</button>
                          </div>
                       </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.footer')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
   $(function () {
      // Form Validation
      $("#contactForm").validate({
         rules: {
            name: {
               required: true,
               minlength: 2,
               maxlength: 50
            },
            address: {
               required: true,
               minlength: 5,
               maxlength: 150
            },
            mobile: {
               required: true,
               minlength: 10,
               maxlength: 15,
               digits: true
            },

            house_number: {
               required: true,
               minlength: 1,
               maxlength: 50
            },
            street_name: {
               required: true,
               minlength: 3,
               maxlength: 100
            },
            city: {
               required: true,
               minlength: 2,
               maxlength: 50
            },
            country: {
               required: true,
               minlength: 2,
               maxlength: 50
            },
            zip_code: {
               required: true,
               digits: true,
               minlength: 5,
               maxlength: 10
            }
         },
         messages: {
            name: {
               required: "Please enter your name",
               minlength: "Name should be at least 2 characters",
               maxlength: "Name should not exceed 50 characters"
            },
            address: {
               required: "Please enter your address",
               minlength: "Address should be at least 5 characters",
               maxlength: "Address should not exceed 255 characters"
            },
            mobile: {
               required: "Please enter your mobile number",
               minlength: "Mobile number should be at least 10 digits",
               maxlength: "Mobile number should not exceed 15 digits",
               digits: "Mobile number should contain only digits"
            },
            house_number: {
               required: "Please enter your house number",
               minlength: "House number should be at least 1 character",
               maxlength: "House number should not exceed 50 characters"
            },
            street_name: {
               required: "Please enter your street name",
               minlength: "Street name should be at least 3 characters",
               maxlength: "Street name should not exceed 100 characters"
            },
            city: {
               required: "Please enter your city",
               minlength: "City should be at least 2 characters",
               maxlength: "City should not exceed 50 characters"
            },
            country: {
               required: "Please enter your country",
               minlength: "Country should be at least 2 characters",
               maxlength: "Country should not exceed 50 characters"
            },
            zip_code: {
               required: "Please enter your zip code",
               digits: "Zip code should contain only digits",
               minlength: "Zip code should be at least 5 digits",
               maxlength: "Zip code should not exceed 10 digits"
            }
         }
      });
   });
</script>
