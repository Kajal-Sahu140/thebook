@include('website.header')
<style>
::placeholder {
    text-transform: capitalize;
}
.form-control.country_code {
    width: 80px;
    flex: 0 0 90px;
}
.form-control.whatsapp_country_code {
     width: 80px;
    flex: 0 0 90px;
}
</style>
<div class="site-bg">
    <div class="dashborad-page-warper section-padding">
        <div class="container">
            <div class="dashborad-des-bg row">
                <!-- Sidebar Section -->
                <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                    <div class="dashborad-sidebar">
                        <div class="dashborad-sidebar-head text-center">
                            <h3>{{ $user->name }}</h3>
                            <p>{{ $user->phone }}</p>
                        </div>
                        <div class="sidebar-menu">
                            <ul>
                                <li class="active">
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

                <!-- Content Section -->
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="dashborad-content-des">
                        <h2>My Profile</h2>
                        <form class="mt-4" id="profileForm" action="{{route('website.myprofileupdate')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Name Field -->
                                <div class="col-md-6 col-sm-12">
    <div class="form-group">
        <label for="name">{{ __('messages.full_name') }}</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="{{ trim($user->name) }}" oninput="this.value = this.value.trimStart()" />
    </div>
</div>

<!-- Email Field -->
<div class="col-md-6 col-sm-12">
    <div class="form-group">
        <label for="email">{{ __('messages.email_address') }}</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" 
               placeholder="Enter Your Email Address" 
               value="{{ old('email', trim($user->email)) }}" 
               oninput="this.value = this.value.trimStart()" 
               onblur="validateEmail(this)" />
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <span id="email-error" class="text-danger" style="display:none; font-size: 12px;">Invalid email format</span>
    </div>
</div>

<script>
function validateEmail(input) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const errorMessage = document.getElementById('email-error');

    if (!emailPattern.test(input.value)) {
        errorMessage.style.display = 'block';
        input.classList.add('is-invalid');
    } else {
        errorMessage.style.display = 'none';
        input.classList.remove('is-invalid');
    }
}
</script>


                                <!-- Mobile Field -->
                               <div class="col-md-6 col-sm-12">
                                     <div class="form-group">
                                 <label for="mobile">{{__('messages.mobile')}} <sup>*</sup></label>
                                 <!-- Country Code Dropdown -->
                                 <div class="input-group">
                                    <select name="country_code" id="country_code" disabled class="form-control country_code @error('country_code') is-invalid @enderror">   
                                         
                                             <option value="{{ $user->country_code }}">{{ $user->country_code }}</option>
                                         
                                    </select>

                                    <!-- Mobile Input Field -->
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                             id="mobile" 
                                             name="phone" 
                                             placeholder="Enter Mobile" 
                                             value="{{ old('mobile',$user->phone) }}" 
                                             oninput="this.value = this.value.replace(/[^0-9]/g, '')" disabled /><br>
                                    
                                    @error('mobile')
                                          <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                                 </div>
                                 </div>
                                </div>
                                <!-- WhatsApp Mobile Number Field -->
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="whatsapp">{{__('messages.whatsapp_number')}}</label>

                                        <div class="input-group">
                                         <select name="whatsapp_country_code" id="whatsapp_country_code" disabled class="form-control whatsapp_country_code @error('whatsapp_country_code') is-invalid @enderror">   
                                         
                                             <option value="{{ $user->whatsapp_country_code }}">{{ $user->whatsapp_country_code }}</option>
                                         
                                    </select>
                                       <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                        placeholder="Enter Your Whatsapp Number" value="{{ $user->whatsapp }}"
                                        oninput="validateWhatsappNumber(this)" maxlength="15" />
                                    </div>


<script>
       function validateWhatsappNumber(input) {
    input.value = input.value.replace(/[^0-9]/g, ''); // Allow only numbers

    const invalidNumbers = /^0+$/; // Matches all zeros
    if (invalidNumbers.test(input.value)) {
        document.getElementById('whatsapp-error').innerText = "Invalid number (e.g., 00000 not allowed).";
        input.value = ""; // Clear input
    } else {
        document.getElementById('whatsapp-error').innerText = "";
    }
}
</script>
                                    </div>
                                </div>
                            </div>
                            <div class="save-btn-bxo">
                                <button type="submit" class="btn btn-primary">{{__('messages.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.footer')
<!-- jQuery and Validation Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $("#profileForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 70,
                    pattern: /^[a-zA-Z0-9._%+-]+@gmail\.com$/,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                whatsapp: {
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                }
            },
            messages: {
                name: {
                    required: "Please enter your name.",
                    minlength: "Name must be at least 2 characters.",
                    maxlength: "Name cannot exceed 50 characters."
                },
                email: {
                    required: "Please enter your email.",
                    email: "Please enter a valid email address.",
                    maxlength: "Email cannot exceed 70 characters.",
                    pattern: "Please enter a valid Gmail email address."
                },
                phone: {
                    required: "Please enter your mobile number.",
                    digits: "Please enter only digits.",
                    minlength: "Mobile number must be at least 10 digits.",
                    maxlength: "Mobile number cannot exceed 15 digits."
                },
                whatsapp: {
                    digits: "Please enter only digits.",
                    minlength: "WhatsApp number must be at least 10 digits.",
                    maxlength: "WhatsApp number cannot exceed 15 digits."
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) {
                error.insertAfter(element); // Position error message below the input
            },
            highlight: function (element) {
                $(element).addClass('is-invalid'); // Highlight invalid input
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid'); // Remove highlight on valid input
            }
        });
    });
</script>
