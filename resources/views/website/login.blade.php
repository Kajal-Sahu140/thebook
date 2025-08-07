@include('website.header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">




<style>
            .with-icon input {
    padding-right: 45px;
    color: #000 !important; /* Ensure visible text */
    background-color: #fff !important; /* Optional: ensure background contrast */
}
.pwd-show-tgl {
    cursor: pointer;
}


    .pwd-show-tgl {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
    }
    @media (max-width: 576px) {
        .form-des-head h3 {
            font-size: 1.5rem;
        }

        .form-des-head p {
            font-size: 1rem;
        }

        .form-ger-box img {
            width: 100%;
            height: auto;
        }
    }
    #country_code {
        max-width: fit-content;
    }
</style>

<div class="site-bg">
    <section class="form-bg section-padding">
        <div class="container">
            <div class="form-box-inner">
                <div class="row">
                    <!-- Form Column -->
                    <div class="col-md-6">
                        <div class="form-fild-content">
                            <div class="form-head">
                                <h3>{{__('messages.login')}}</h3>
                                <p>{{__('messages.loginmessage')}}</p>
                            </div>
                            <!-- Start of the Login Form -->
                            <form id="loginForm" action="{{ route('website.signin') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                <label for="mobile">{{__('messages.mobile')}} <sup>*</sup></label>
                                <!-- Country Code Dropdown -->
                                <div class="input-group">
                                    <select name="country_code" id="country_code" class="form-control country_code @error('country_code') is-invalid @enderror">   
                                        <!-- @foreach($country_codes as $code)
                                            <option value="{{ $code->code }}" {{ old('country_code') == $code->code ? 'selected' : '' }}>{{ $code->code }}</option>
                                        @endforeach -->
                                          <option value="+91">+91</option>
                                    </select>
                            
                                    <!-- Mobile Input Field -->
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="mobile" 
                                           name="phone" 
                                           placeholder="{{__('messages.enter_mobile')}}" 
                                           value="{{ old('phone') }}" 
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                    
                                    @error('phone')
                                        <span class="invalid-feedback" style="display: block; font-size: 12px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                

                                 </div>
                                 
                                  <div class="form-group">
        <label for="password">Password <sup>*</sup></label>
        <div class="input-group with-icon" style="position: relative;">
                                <input type="password" class="form-control" id="newPasswordEdit" name="password" value="{{ old('password') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text pwd-show-tgl" data-target="newPasswordEdit">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
    </div>

                                <!-- Submit Button -->
                                <div class="form-submit-btn">
                                    <button type="submit" class="btn">{{__('messages.login')}}</button>
                                </div>

                                <!-- Footer with Sign Up Link -->
                                 <div style="margin-top: 5px;">
                                    <a href="{{route('website.forgetpassword')}}" style="font-size: 13px;">Forget Password</a>
                                </div>
                                <div class="form-foot">
                                    <p>{{__('messages.didnt')}} <a href="{{ route('website.signup') }}">{{__('messages.signup')}}</a></p>
                                </div>
                            </form>
                            <!-- End of the Login Form -->
                        </div>
                    </div>

                    <!-- Description Column -->
                    <div class="col-md-6">
                        <div class="form-des-box">
                          <div class="form-des-head">
                                <h3>Books for You, Delivered with Love</h3>
                                <p>From bedtime stories to first words, we’ve got all your favorite books. Help your little one learn and grow—all in one easy place.</p>
                         </div>
                            <div class="form-ger-box">
                                <img src="https://thebookdoor.in/storage/app/public/category_images/sHV8YHTwyjElzibU1HBmWd0wsatQiE6j3NprB1LK.jpg" alt="form ger"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('website.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
jQuery.noConflict();
jQuery(document).ready(function($) {
        $("#loginForm").validate({
            rules: {
                country_code: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                    maxlength: 15
                }
            },
            messages: {
                country_code: {
                    required: "Please select your country code."
                },
                phone: {
                    required: "Please enter your phone number.",
                    digits: "Please enter only digits.",
                    maxlength: "Your phone number can't be longer than 15 digits."
                }
            },
            errorElement: "span",
            errorClass: "invalid-feedback",
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });

        $('.pwd-show-tgl').click(function() {
    let input = $('#' + $(this).data('target'));
    let icon = $(this).find('i');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});

    });
</script>





