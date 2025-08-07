@include('website.header')
<?php
use Illuminate\Support\Facades\Session;
$phone = Session()->get('phone');
$user_id = Session()->get('user_id');
$country_code = Session()->get('country_code');
// Check if the phone number is valid
if ($phone && strlen($phone) >= 7) {
    // Format the phone number
    $formattedPhone = '+1 ' . substr($phone, 2, 2) . '----' . substr($phone, -2);
} else {
    $formattedPhone = $phone; // Return the original if not valid
}
?>
<style>
    .otp-input {
        cursor: auto; /* Default cursor behavior */
    }
</style>
<div class="site-bg">
    <section class="form-bg section-padding">
        <div class="container">
            <div class="form-box-inner">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-fild-content">
                            <div class="form-head">
                                <h3>{{__('messages.enterotp')}} {{ session('otp') }}</h3>
                                <p>
                                    {{__('messages.digitotp')}}
                                    {{ 
                                        (!empty($country_code) ? $country_code : '+1') . 
                                        ' ' . substr($phone, 0, 2) . '----' . substr($phone, -2) 
                                    }},
                                </p>
                            </div>
                            <!-- Form for OTP submission -->
                            <form id="otpForm" action="{{ route('website.verifyOtp') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$user_id}}" />
                                <input type="hidden" name="phone" value="{{$phone}}" />
                                <input type="hidden" name="country_code" value="{{$country_code}}" />
                                <div class="otp-list">
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('otp[0]') is-invalid @enderror otp-input" maxlength="1" name="otp[0]" />
                                        @error('otp[0]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('otp[1]') is-invalid @enderror otp-input" maxlength="1" name="otp[1]" />
                                        @error('otp[1]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('otp[2]') is-invalid @enderror otp-input" maxlength="1" name="otp[2]" />
                                        @error('otp[2]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('otp[3]') is-invalid @enderror otp-input" maxlength="1" name="otp[3]" />
                                        @error('otp[3]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-submit-btn">
                                    <button type="submit" class="btn">Continue</button> 
                                </div>
                            </form>
                            <form action="{{ route('website.resendOtp') }}" method="POST" id="resendOtpForm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$user_id}}" />
                                <input type="hidden" name="phone" value="{{$phone}}" />
                                <input type="hidden" name="country_code" value="{{$country_code}}" />
                                <input type="hidden" name="otp" value=" {{ session('otp') }}" />

                                <div class="form-foot">
                                    <p>{{__('messages.didnt')}} <button type="submit" class="btn">{{__('messages.resendotp')}}</button></p>
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
<script>
    window.onload = function() {
        // Check if OTP is available in localStorage
        const storedOtp = localStorage.getItem('otp');
        const storedUserId = localStorage.getItem('user_id');
        if (storedOtp && storedUserId) {
            // If OTP and user_id are available in localStorage, populate the OTP fields
            document.querySelectorAll('.otp-input').forEach((input, index) => {
                input.value = storedOtp[index]; // Fill each input with corresponding OTP digit
            });
            // Set the hidden user_id input with the stored user_id
            document.querySelector('input[name="user_id"]').value = storedUserId;
        }
    };
    // Handle OTP input field navigation
    document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
        input.addEventListener('input', function () {
            // Move to the next input field if the current field has a value
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });
        input.addEventListener('keydown', function (e) {
            // Move to the previous input field if the backspace key is pressed and current input is empty
            if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
    // Form validation
    $(document).ready(function () {
        $("#otpForm").validate({
            rules: {
                'otp[0]': {
                    required: true,
                    digits: true
                },
                'otp[1]': {
                    required: true,
                    digits: true
                },
                'otp[2]': {
                    required: true,
                    digits: true
                },
                'otp[3]': {
                    required: true,
                    digits: true
                }
            },
            messages: {
                'otp[0]': {
                    required: "Please enter the first digit of OTP.",
                    digits: "Please enter a valid digit."
                },
                'otp[1]': {
                    required: "Please enter the second digit of OTP.",
                    digits: "Please enter a valid digit."
                },
                'otp[2]': {
                    required: "Please enter the third digit of OTP.",
                    digits: "Please enter a valid digit."
                },
                'otp[3]': {
                    required: "Please enter the fourth digit of OTP.",
                    digits: "Please enter a valid digit."
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
    });
</script>
