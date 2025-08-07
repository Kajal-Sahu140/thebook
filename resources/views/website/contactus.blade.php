@include('website.header')

<div class="site-bg">
   <!-- Inner Page Title Section -->
   <section class="inner-page-title-section section-padding">
      <div class="container">
         <h2>{{__('messages.contactus')}}</h2>
         <ul>
            <li class="active"><a href="{{ route('website.index') }}">Home -></a></li>
            <li>{{__('messages.contactus')}}</li>
         </ul>
      </div>
   </section>

   <!-- Contact Page Description Section -->
   <section class="contact-page-des section-padding">
      <div class="container">
         <div class="row">
            <!-- Contact Info Section -->
            <div class="col-md-6 col-lg-4 mb-4">
               <div class="contact-des">
                  <div class="contact-head">
                     <h3>Let’s Talk Books!</h3>
                     <p>Whether you're a passionate reader, an author, or simply curious about what we offer, we're here to chat. Explore timeless classics, discover new releases, or ask us anything about your next great read. Let’s make your reading journey unforgettable—reach out today!</p>
                  </div>
                  <ul>
                     <li>
                        <a href="javascript:;">  
                           <i class="ti ti-map-pin"></i> 
                           <span> Near Bus Stand Alwar (Rajasthan)</span>  
                        </a> 
                     </li>
                     <li>
                        <a href="tel:+91 8386992953">  
                           <i class="ti ti-phone-call"></i>
                           <span>+91 8386992953</span>  
                        </a> 
                     </li>
                     <li>
                        <a href="mailto:devpakiya@gmail.com">  
                           <i class="ti ti-mail"></i>
                           <span>devpakiya@gmail.com</span>  
                        </a> 
                     </li>
                  </ul>
               </div>
            </div>

            <!-- Contact Form Section -->
            <div class="col-md-6 col-lg-8">
               <div class="contact-form-box">
                  <!-- Form Start -->
                  <form id="contactForm" method="POST" action="{{ route('website.sendMessage') }}">
                     @csrf
                     <div class="row">
                        <!-- Name Field -->
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="name">Name</label>  
                              <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter Name" />
                           </div>
                        </div>

                        <!-- Email Field -->
                        <div class="col-md-6">
                         <div class="form-group">
    <label for="email">Email</label>  
    <input 
        type="email" 
        id="email" 
        name="email" 
        value="{{ old('email')}}" 
        class="form-control @error('email') is-invalid @enderror" 
        placeholder="Enter Email">
    @error('email')
        <div id="email-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                     </div>

                     <!-- Subject Field -->
                     <div class="form-group">
                        <label for="subject">Subject</label> 
                        <input type="text" id="subject" name="subject" value="{{old('subject')}}" class="form-control" placeholder="Enter Subject" />
                     </div>

                     <!-- Description Field -->
                     <div class="form-group">
                        <label for="description">Description</label> 
                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description">{{old('description')}}</textarea>
                     </div>

                     <!-- Submit Button -->
                     <div class="form-submit-btn">
                        <button type="submit" class="btn btn-primary">Send</button>  
                     </div>
                  </form>
                  <!-- Form End -->
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

@include('website.footer')

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
  $(document).ready(function() {
      // Form Validation
      $("#contactForm").validate({
         rules: {
            name: {
               required: true,
               minlength: 2,
               maxlength: 50
            },
             email: {
    required: true,
    maxlength: 70,
    pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
},
            subject: {
               required: true,
               minlength: 3,
               maxlength: 100
            },
            description: {
               required: true,
               minlength: 5,
               maxlength: 500
            }
         },
         messages: {
            name: {
               required: "Please enter your name.",
               minlength: "Name must be at least 2 characters.",
               maxlength: "Name cannot exceed 50 characters."
            },
            email: {
                required: "The email field is required.",
                maxlength: "Email cannot exceed 70 characters.",
                pattern: "The email field format is invalid."
               

            },
            subject: {
               required: "Please enter a subject.",
               minlength: "Subject must be at least 3 characters.",
               maxlength: "Subject cannot exceed 100 characters."
            },
            description: {
               required: "Please enter a description.",
               minlength: "Description must be at least 5 characters.",
               maxlength: "Description cannot exceed 500 characters."
            }
         },
         errorElement: 'div',
         errorClass: 'invalid-feedback',
         errorPlacement: function (error, element) {
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid');
         }
      });
   //    $('#contactForm').on('submit', function () {
   //      // Remove server-side error messages when form is submitted (client-side validation will handle errors)
   //      $('.invalid-feedback').hide();
   //  });
   });
</script>
