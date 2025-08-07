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
    #whatsapp_country_code{
        max-width: fit-content;
    }
</style>
</style>
<div class="site-bg">
   <section class="form-bg section-padding">
      <div class="container">
         <div class="form-box-inner">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-fild-content">
                     <div class="form-head">
                        <h3>{{ __('messages.signup') }}</h3>
                        <p>{{ __('messages.loginmessage') }}</p>
                     </div>
                     <form id="signupForm" action="{{ route('website.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                         <input type="hidden" id="fcm_token" name="fcm_token">
                        <div class="form-group">
                           <label for="name">{{ __('messages.name') }} <sup>*</sup></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('messages.enter_name') }}" value="{{ old('name') }}"/>
                           @error('name')
                               <span class="invalid-feedback">{{ $message }}</span>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label for="email">{{__('messages.email')}} <sup>*</sup></label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('messages.enter_email') }}" value="{{ old('email') }}"/>
                           @error('email')
                               <span class="invalid-feedback">{{ $message }}</span>
                           @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password<sup>*</sup></label>
                            <div class="input-group with-icon" style="position: relative;">
                                <input type="password" class="form-control" id="newPasswordEdit" name="password" value="{{ old('password') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text pwd-show-tgl" data-target="newPasswordEdit">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                           <label for="mobile">{{__('messages.mobile')}} <sup>*</sup></label>
                             <div class="input-group">
                           <select name="country_code" id="country_code" class="form-control country_code @error('country_code') is-invalid @enderror">
                                             <!-- @foreach($country_codes as $code)
                                            <option value="{{ $code->code }}" {{ old('country_code') == $code->code ? 'selected' : '' }}>{{ $code->code }}</option>
                                        @endforeach -->
                                           <option value="+91">+91</option>

                                        </select>
                                    
                           <input type="text" class="form-control @error('phone') is-invalid @enderror" id="mobile" name="phone" placeholder="{{ __('messages.enter_mobile') }}" value="{{ old('phone') }}"/>
                           @error('phone')
                               <span class="invalid-feedback">{{ $message }}</span>
                           @enderror
                        </div>  
                        </div>  
                        <div class="form-group">
                           <label for="whatsapp_mobile">{{__('messages.whatsapp_mobile_number')}} <sup>*</sup></label>
                             <div class="input-group">
                           <select name="whatsapp_country_code" id="whatsapp_country_code" class="form-control country_code @error('whatsapp_country_code') is-invalid @enderror">
                                              <!-- @foreach($country_codes as $code)
                                            <option value="{{ $code->code }}" {{ old('country_code') == $code->code ? 'selected' : '' }}>{{ $code->code }}</option>
                                        @endforeach -->
                                        <option value="+91">+91</option>
                                        </select>
                           <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp_mobile" name="whatsapp" placeholder="{{ __('messages.enter_whatsapp_mobile_number') }}" value="{{ old('whatsapp') }}"/>
                           @error('whatsapp')
                               <span class="invalid-feedback">{{ $message }}</span>
                           @enderror
                        </div>
                        </div>
                        <div class="form-check accept-box">
                           <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                           <label class="form-check-label" for="terms">
                             {{ __('messages.i_accept')}} <a href="{{ Route('website.tremscondition') }}">{{ __('messages.terms_and_conditions') }}</a>
                           </label>
                           @error('terms')
                               <span class="invalid-feedback">{{ $message }}</span>
                           @enderror
                        </div>
                        <div class="form-submit-btn">
                           <button type="submit" class="btn">{{ __('messages.signup') }}</button>
                        </div>
                        <div class="form-foot">
                           <p>{{ __('messages.already_have_an_account')}} <a href="{{ route('website.signin') }}">{{ __('messages.login') }}</a></p>
                        </div>
                     </form>
                  </div>
               </div>
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
<script>
jQuery.noConflict();
jQuery(document).ready(function($) {
    
        $("#signupForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                password: {
                    required: true,
                    password: true,
                    maxlength: 15
                },
                phone: {
                    required: true,
                    digits: true,
                    maxlength: 15
                },
                whatsapp: {
                    digits: true,
                    maxlength: 15
                },
                terms: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your name.",
                    maxlength: "Your name can't be longer than 255 characters."
                },
                email: {
                    required: "Please enter your email.",
                    email: "Please enter a valid email address.",
                    maxlength: "Your email can't be longer than 255 characters."
                },
                phone: {
                    required: "Please enter your phone number.",
                    digits: "Please enter only digits.",
                    maxlength: "Your phone number can't be longer than 15 digits."
                },
                whatsapp: {
                    digits: "Please enter only digits.",
                    maxlength: "Your WhatsApp number can't be longer than 15 digits."
                },
                terms: {
                    required: "You must accept the terms and conditions."
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
                if (element.attr("type") == "checkbox") {
                    error.insertAfter(element.closest(".form-check"));
                } else {
                    error.insertAfter(element);
                }
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





 
 
