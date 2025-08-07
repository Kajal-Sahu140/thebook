
<!-- Font Awesome CDN -->
@include('website.header')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
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

    .with-icon {
        position: relative;
    }

    /* .with-icon input {
        padding-right: 45px;
    } */
    .with-icon input {
    padding-right: 45px;
    color: #000 !important; /* Ensure visible text */
    background-color: #fff !important; /* Optional: ensure background contrast */
}

    .pwd-show-tgl {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
    }

    .error {
        color: red;
        font-size: 12px;
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
                                <h3>Change Password</h3>
                                <p>Change Password</p>
                            </div>

                            <!-- Change Password Form -->
         
                            <form class="form-horizontal" action="{{route('website.userchangepassword')}}" method="post" id="editPassword">
                @csrf
                <div class="card-body">
               
                  
                  <!-- Current Password -->
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Phone <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <!-- <div class="with-icon"> -->
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="oldPasswordEdit">
                            <!-- <span class="input-group-text pwd-show-tgl" data-target="oldPasswordEdit">
                                <i class="fas fa-eye"></i>
                            </span> -->
                        <!-- </div> -->
                        @error('old')
                        <p class="error invalid-feedback error-message text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

<!-- New Password -->
<div class="form-group row">
    <label class="col-sm-4 col-form-label">New Password <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <div class="with-icon">
            <input type="password" name="new" value="{{ old('new') }}" class="form-control" id="newPasswordEdit">
            <span class="input-group-text pwd-show-tgl" data-target="newPasswordEdit">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        @error('new')
        <p class="error invalid-feedback error-message text-center">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Confirm Password -->
<div class="form-group row">
    <label class="col-sm-4 col-form-label">Confirm Password <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <div class="with-icon">
            <input type="password" name="confirm" value="{{ old('confirm') }}" class="form-control" id="confirmPasswordEdit">
            <span class="input-group-text pwd-show-tgl" data-target="confirmPasswordEdit">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        @error('confirm')
        <p class="error invalid-feedback error-message text-center">{{ $message }}</p>
        @enderror
    </div>
</div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex align-items-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <!-- /.card-footer -->
            </form>

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
        $('#editPassword').validate({
            rules: {
        old: { // Change to 'old'
            required: true
        },
        new: { // Change to 'new'
            required: true,
            minlength: 6
        },
        confirm: { // Change to 'confirm'
            required: true,
            equalTo: "#newPasswordEdit"
        },
      


    },
    messages: {
        old: {
            required: "Please enter your current password"
        },
        new: {
            required: "Please enter a new password",
            minlength: "Password must be contain at least 6 characters long"
        },
        confirm: {
            required: "Please confirm your new password",
            equalTo: "New password & confirm passsword must be same."
        },
        
    },
            errorElement: 'p',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
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

    $('.npwd-show-tgl').click(function() {
        if ($(this).data('show')) {
            $('#newPasswordEdit').attr('type', 'password')
            $('#i-nhidePwd').hide()
            $('#i-nshowPwd').show()
            $(this).data('show', false)
        } else {
            $('#newPasswordEdit').attr('type', 'text')
            $('#i-nshowPwd').hide()
            $('#i-nhidePwd').show()
            $(this).data('show', true)
        }
    })
    $('.cpwd-show-tgl').click(function() {
        if ($(this).data('show')) {
            $('#confirmPasswordEdit').attr('type', 'password')
            $('#i-chidePwd').hide()
            $('#i-cshowPwd').show()
            $(this).data('show', false)
        } else {
            $('#confirmPasswordEdit').attr('type', 'text')
            $('#i-cshowPwd').hide()
            $('#i-chidePwd').show()
            $(this).data('show', true)
        }
    })

    var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 2000); // 2 seconds
        }
    });
</script>



<!-- Font Awesome CDN -->


