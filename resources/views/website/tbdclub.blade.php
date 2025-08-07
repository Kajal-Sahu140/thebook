@include('website.header')




<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
  overflow-x: hidden;
}

.card {
  max-width: 100%; /* ensure card doesn't overflow */
  box-sizing: border-box;
}
    .header-text {
        font-family: 'Poppins', sans-serif;
        color: #1e293b; /* slate-800 */
    }

    /* Remove unnecessary padding from container */
    .container {
        max-width: 100%;
        padding-left: 0;
        padding-right: 0;
        margin: 0 auto;
    }

    /* Adjust spacing for inner content box */
    .hero-box {
        max-width: 1608px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
    }

    .transition {
        transition: all 0.3s ease-in-out;
    }

    @media (max-width: 1608px) {
        .text-3xl {
            font-size: 1.875rem;
        }
    }
</style>
<style>
.step-box {
  background: #fff;
  border-radius: 0.75rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  padding: 1.5rem;
  text-align: center;
}
.step-number {
  background-color: #e0e7ff;
  color: #4f46e5;
  font-size: 1.5rem;
  font-weight: bold;
  width: 3.5rem;
  height: 3.5rem;
  margin: 0 auto 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}
.step-title {
  font-weight: bold;
  font-size: 1.125rem;
  margin-bottom: 0.5rem;
}
.step-desc {
  color: #475569;
  font-size: 0.95rem;
}

</style>
<!-- <style>
  .btn-purple {
  background-color: #6f42c1;
  color: white;
}
.btn-purple:hover {
  background-color: #5a35a1;
  color: white;
}
.bg-purple {
  background-color: #6f42c1 !important;
}

</style> -->

<style>
  .bg-purple {
    background-color: #6f42c1 !important;
  }
  .btn-purple {
    background-color: #6f42c1;
    color: white;
  }
  .btn-purple:hover {
    background-color: #5931a9;
  }
</style>


<style>
 .circle {
  width: 150px;
  height: 50px;
  background-color: #e0e7ff;
  color: #4338ca;
  font-weight: bold;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
}

</style>

<style>
  .accordion-button {
    font-size: 1.1rem;
    position: relative;
  }

  .accordion-button .arrow::after {
    content: "➤";
    display: inline-block;
    transform: rotate(0deg);
    transition: transform 0.3s ease;
    font-size: 16px;
  }

  .accordion-button:not(.collapsed) .arrow::after {
    transform: rotate(90deg);
  }

  .accordion-button:focus {
    box-shadow: none;
  }

  
</style>

<style>
  .custom-plan {
    max-width: 50%;
    height: 95%;
  }
  .custom-plan .card-header,
  .custom-plan .card-body,
  .custom-plan .card-footer {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
  }
</style>
<style>
  .plan-card {
    width: 100%;
    max-width: 680px;      /* Control width */
    min-height: 220px;     /* Consistent height */
    border-radius: 1rem;
  }

  .card-header h2 {
    font-size: 1.5rem;
  }

  .card-body li {
    font-size: 0.95rem;
  }

  .choose-plan-btn {
    font-size: 0.9rem;
    padding: 8px 16px;
  }

  .bg-purple {
    background-color: #6f42c1 !important;
  }
</style>


<!-- Hero Section -->

 
{{--<section class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Unlock Your Reading Potential — This Is Reading, Invented.</h2>
   
    <div class="card border-0 shadow-lg p-4 mx-auto" style="max-width: 1300px;">
      <img 
        src="https://thebookdoor.in/storage/app/public/banners/web/ZxpEPMxved1jCiRG5KJbaYykVG7R3YHFcFC9yE20.jpg" 
        alt="Stack of books with TBD Club logo surrounded by reading accessories" 
        class="img-fluid rounded mb-4"
      >
      <p class="fs-5 text-muted mb-4">
       Plan Your Reads, Own Your Story. Choose from  quarterly, Half Yearly or yearly plans to purchase books that fuel your passion for reading. Stay on track, discover new authors, and build your dream library!".    
      </p>
   <div class="d-grid gap-2 col-2 mx-auto">
  <a href="#plan" class="btn btn-teal py-1">Join Now</a>
</div>
    </div>
     
  </div>
</section>--}}


<section class="py-5">
  <div class="container text-center">
 <h2 class="fw-bold mb-4">Unlock Your Reading Potential — This Is Reading, Invented.</h2>
    <div class="card border-0 shadow-lg p-4 mx-auto" style="max-width: 1300px;">

      <!-- Video tag starts here -->
      <video class="img-fluid rounded mb-4" autoplay muted loop playsinline>
        <source src="https://thebookdoor.in/storage/app/public/banners/web/hlLgkHF79obVj4ZoEuw4364FK9qib2dktaeEMaQ3.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      <!-- Video tag ends here -->

       <p class="fs-5 text-muted mb-4">
       Plan Your Reads, Own Your Story. Choose from  quarterly, Half Yearly or yearly plans to purchase books that fuel your passion for reading. Stay on track, discover new authors, and build your dream library!".    
      </p>

      <div class="d-grid gap-2 col-2 mx-auto">
        <a href="#plan" class="btn btn-teal py-1">Join Now</a>
      </div>
    </div>
  </div>
</section>


<section class="py-5" style="background-color: #f0f4ff;">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold">How It Works</h2>

    <!-- Flex container to center the entire process -->
    <div class="d-flex flex-wrap justify-content-center align-items-stretch gap-3">

      <!-- Step 1 -->
      <div class="card p-3 shadow-sm text-center" style="width: 180px;">
        <div class="circle mb-2">1</div>
        <h5 class="fw-bold">Add a Request</h5>
        <p class="text-muted small">Let us know which book you want to read through our app or website.</p>
      </div>

      <!-- Arrow -->
      <div class="d-flex align-items-center fs-2 text-primary">➜</div>

      <!-- Step 2 -->
      <div class="card p-3 shadow-sm text-center" style="width: 180px;">
        <div class="circle mb-2">2</div>
        <h5 class="fw-bold">Select Book</h5>
        <p class="text-muted small">Choose from our curated selection or demand a specific title.</p>
      </div>

      <div class="d-flex align-items-center fs-2 text-primary">➜</div>

      <!-- Step 3 -->
      <div class="card p-3 shadow-sm text-center" style="width: 180px;">
        <div class="circle mb-2">3</div>
        <h5 class="fw-bold">We Deliver</h5>
        <p class="text-muted small">Your selected books will be delivered right to your doorstep.</p>
      </div>

      <div class="d-flex align-items-center fs-2 text-primary">➜</div>

      <!-- Step 4 -->
      <div class="card p-3 shadow-sm text-center" style="width: 180px;">
        <div class="circle mb-2">4</div>
        <h5 class="fw-bold">Read Book</h5>
        <p class="text-muted small">Enjoy your reading experience at your own pace.</p>
      </div>

      <div class="d-flex align-items-center fs-2 text-primary">➜</div>

      <!-- Step 5 -->
      <div class="card p-3 shadow-sm text-center" style="width: 180px;">
        <div class="circle mb-2">5</div>
        <h5 class="fw-bold">We Pickup</h5>
        <p class="text-muted small">When you're done, we'll pick up the book from you.</p>
      </div>

    </div>
  </div>
</section>

{{--<section class="py-5 bg-light" id="plan">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold">Plan & Pricing</h2>

    <div class="row justify-content-center text-start g-4">

      <!-- Basic Plan -->
      <div class="col-sm-10 col-md-6 col-lg-4 d-flex justify-content-center">
        <div class="card border-0 shadow-lg h-100 w-100">
          <div class="card-header bg-primary text-white rounded-top text-center">
            <h4 class="my-2">Basic Plan</h4>
            <h2>₹345<small class="fs-6">/90 Days</small></h2>
          </div>
          <div class="card-body px-4">
            <ul class="list-unstyled">
              <li>✅ Rent 6 Books</li>
              <li>✅ Max 2 Books At A Time</li>
              <li>✅ Free Home Delivery</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent border-0 text-center">
          <a href="#" class="btn btn-primary w-75 choose-plan-btn"
                data-bs-toggle="modal"
                data-bs-target="#subscriptionModal"
                data-plan-name="Basic Plan"
                data-plan-id="1">
                Choose Basic Plan
              </a>
          </div>
        </div>
      </div>

      <!-- Reader Plan -->
      <div class="col-sm-10 col-md-6 col-lg-4 d-flex justify-content-center">
        <div class="card border-0 shadow-lg h-100 w-100">
          <div class="card-header bg-success text-white rounded-top position-relative text-center">
            <h4 class="my-2">Reader Plan</h4>
            <h2>₹549<small class="fs-6">/180 Days</small></h2>
            <span class="badge bg-warning text-dark position-absolute top-0 end-0 mt-2 me-2">Popular</span>
          </div>
          <div class="card-body px-4">
            <ul class="list-unstyled">
              <li>✅ Rent 12 Books</li>
              <li>✅ Max 2 Books At A Time</li>
              <li>✅ Free Home Delivery</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent border-0 text-center">
              <a href="#" class="btn btn-primary w-75 choose-plan-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#subscriptionModal"
                    data-plan-name="Reader Plan"
                    data-plan-id="2">
                    Choose Reader Plan
                  </a>
          </div>
        </div>
      </div>

      <!-- Scholar Plan -->
      <div class="col-sm-10 col-md-6 col-lg-4 d-flex justify-content-center">
        <div class="card border-0 shadow-lg h-100 w-100">
          <div class="card-header bg-purple text-white rounded-top text-center position-relative">
            <h4 class="my-2">Scholar Plan</h4>
            <h2>₹999<small class="fs-6">/360 Days</small></h2>
          </div>
          <div class="card-body px-4">
            <ul class="list-unstyled">
              <li>✅ Rent 24 Books</li>
              <li>✅ Max 2 Books At A Time</li>
              <li>✅ Free Home Delivery</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent border-0 text-center">
                 <a href="#" class="btn btn-primary w-75 choose-plan-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#subscriptionModal"
                  data-plan-name="Scholar Plan"
                  data-plan-id="3">
                  Choose Scholar Plan
                </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>--}}
<section class="py-5 bg-light" id="plan">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold">Plan & Pricing</h2>

    <div class="row justify-content-center text-start g-4">

      <!-- Basic Plan -->
      <div class="col-sm-10 col-md-6 col-lg-3 d-flex justify-content-center">
        <div class="card border-0 shadow-lg h-100 plan-card">
          <div class="card-header bg-primary text-white rounded-top text-center">
            <h4 class="my-2">Basic Plan</h4>
            <h2>₹345<small class="fs-6">/90 Days</small></h2>
          </div>
          <div class="card-body px-3">
            <ul class="list-unstyled">
              <li>✅ Rent 6 Books</li>
              <li>✅ Max 2 Books At A Time</li>
              <li>✅ Free Home Delivery</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent border-0 text-center">
            <a href="#" class="btn btn-primary w-75 choose-plan-btn"
              data-bs-toggle="modal"
              data-bs-target="#subscriptionModal"
              data-plan-name="Basic Plan"
              data-plan-id="1">
              Choose Basic Plan
            </a>
          </div>
        </div>
      </div>

      <!-- Reader Plan -->
      <div class="col-sm-10 col-md-6 col-lg-3 d-flex justify-content-center">
        <div class="card border-0 shadow-lg h-100 plan-card position-relative">
          <div class="card-header bg-success text-white rounded-top text-center">
            <h4 class="my-2">Reader Plan</h4>
            <h2>₹549<small class="fs-6">/180 Days</small></h2>
            <span class="badge bg-warning text-dark position-absolute top-0 end-0 mt-2 me-2">Popular</span>
          </div>
          <div class="card-body px-3">
            <ul class="list-unstyled">
              <li>✅ Rent 12 Books</li>
              <li>✅ Max 2 Books At A Time</li>
              <li>✅ Free Home Delivery</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent border-0 text-center">
            <a href="#" class="btn btn-primary w-75 choose-plan-btn"
              data-bs-toggle="modal"
              data-bs-target="#subscriptionModal"
              data-plan-name="Reader Plan"
              data-plan-id="2">
              Choose Reader Plan
            </a>
          </div>
        </div>
      </div>

      <!-- Scholar Plan -->
      <div class="col-sm-10 col-md-6 col-lg-3 d-flex justify-content-center">
        <div class="card border-0 shadow-lg h-100 plan-card">
          <div class="card-header bg-purple text-white rounded-top text-center position-relative">
            <h4 class="my-2">Scholar Plan</h4>
            <h2>₹999<small class="fs-6">/360 Days</small></h2>
          </div>
          <div class="card-body px-3">
            <ul class="list-unstyled">
              <li>✅ Rent 24 Books</li>
              <li>✅ Max 2 Books At A Time</li>
              <li>✅ Free Home Delivery</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent border-0 text-center">
            <a href="#" class="btn btn-primary w-75 choose-plan-btn"
              data-bs-toggle="modal"
              data-bs-target="#subscriptionModal"
              data-plan-name="Scholar Plan"
              data-plan-id="3">
              Choose Scholar Plan
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>






<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold">Frequently Asked Questions</h2>

    <div class="accordion mx-auto" id="faqAccordion" style="max-width: 768px;">

      <!-- FAQ 1 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq1">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false"
            aria-controls="faqCollapse1">
            What is the TBD Club?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faq1"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            The TBD Club is a monthly book subscription service that delivers curated titles to your doorstep.
          </div>
        </div>
      </div>

      <!-- FAQ 2 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq2">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false"
            aria-controls="faqCollapse2">
            What are the benefits of TBD Club membership?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faq2"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            You get curated books, free home delivery, and 100% cashback in the form of coupons usable on our bookstore.
          </div>
        </div>
      </div>

      <!-- FAQ 3 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq3">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false"
            aria-controls="faqCollapse3">
            Is there any security deposit?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faq3"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            No security deposit is required. Just pay your membership fee and enjoy 100% cashback as a coupon.
          </div>
        </div>
      </div>

      <!-- FAQ 4 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq4">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false"
            aria-controls="faqCollapse4">
            Is the membership available across India?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faq4"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            Currently, we serve Jaipur, Delhi, and Alwar locations only.
          </div>
        </div>
      </div>

      <!-- FAQ 5 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq5">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false"
            aria-controls="faqCollapse5">
            Is there any difference between books on rent and TBD Club membership?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faq5"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            With TBD Club membership, you not only get books but also 100% cashback and free home delivery at no extra cost.
          </div>
        </div>
      </div>

      <!-- FAQ 6 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq6">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse6" aria-expanded="false"
            aria-controls="faqCollapse6">
            How can I get my 100% cashback?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse6" class="accordion-collapse collapse" aria-labelledby="faq6"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            You will receive your 100% cashback as a coupon that can be used at our bookstore.
          </div>
        </div>
      </div>

      <!-- FAQ 7 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq7">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse7" aria-expanded="false"
            aria-controls="faqCollapse7">
            Are the books in paperback or e-book format?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse7" class="accordion-collapse collapse" aria-labelledby="faq7"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            All books are in physical paperback format and delivered to your doorstep.
          </div>
        </div>
      </div>

      <!-- FAQ 8 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq8">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse8" aria-expanded="false"
            aria-controls="faqCollapse8">
            Are there any hidden charges?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse8" class="accordion-collapse collapse" aria-labelledby="faq8"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            No, there are absolutely no hidden charges.
          </div>
        </div>
      </div>

      <!-- FAQ 9 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq9">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse9" aria-expanded="false"
            aria-controls="faqCollapse9">
            Is there any charge if I lose a book?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse9" class="accordion-collapse collapse" aria-labelledby="faq9"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            Yes, you will be required to pay 75% of the book's price if it is lost.
          </div>
        </div>
      </div>

      <!-- FAQ 10 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded">
        <h2 class="accordion-header" id="faq10">
          <button class="accordion-button collapsed text-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#faqCollapse10" aria-expanded="false"
            aria-controls="faqCollapse10">
            Can I request books not listed on your website?
            <!--<span class="arrow ms-2"></span>-->
          </button>
        </h2>
        <div id="faqCollapse10" class="accordion-collapse collapse" aria-labelledby="faq10"
          data-bs-parent="#faqAccordion">
          <div class="accordion-body text-center">
            Of course! You can request books not listed on our website. We’ll try to arrange them subject to availability and terms.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>




<!-- ////////////////////////popup -->

<!-- Subscription Modal -->
<!-- Subscription Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="subscriptionModalLabel">Subscribe to Basic Plan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="subscriptionForm" action="{{route('website.planuser')}}" method="post">
          @csrf
         <input type="hidden" name="plan_id" id="planIdInput" value="">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" >
          @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>
          <div class="mb-3">
            <label for="userMobile" class="form-label">Mobile</label>
            <input type="tel" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" id="userMobile" placeholder="Enter your mobile number" >
           @error('mobile')
                  <span class="invalid-feedback">{{ $message }}</span>
              @enderror
          </div>
          <div class="mb-3">
            <label for="userAddress" class="form-label">Address</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address"  id="userAddress" rows="3" 
            placeholder="Enter your address" >{{ old('address') }} </textarea>
              @error('address')
                  <span class="invalid-feedback">{{ $message }}</span>
              @enderror
          </div>
       
          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>



@include('website.footer')



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success') || $errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
       // modal.show();

        @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>
@endif



@if ($errors->any())
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const subscriptionModal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
    subscriptionModal.show();

    // Get old plan ID from server (embedded from Blade)
    const oldPlanId = "{{ old('plan_id') }}";
    let planName = "";

    // Match plan ID to plan name
    switch (oldPlanId) {
      case "1":
        planName = "Basic Plan";
        break;
      case "2":
        planName = "Reader Plan";
        break;
      case "3":
        planName = "Scholar Plan";
        break;
    }

    // Set modal title and plan ID
    if (planName) {
      document.getElementById('subscriptionModalLabel').textContent = `Subscribe to ${planName}`;
      document.getElementById('planIdInput').value = oldPlanId;
    }
  });
</script>
@endif


<script>
document.addEventListener('DOMContentLoaded', function () {
  const choosePlanButtons = document.querySelectorAll('.choose-plan-btn');

  choosePlanButtons.forEach(button => {
    button.addEventListener('click', function () {
      const planName = this.getAttribute('data-plan-name');
      const planId = this.getAttribute('data-plan-id');

      // Set modal title
      document.getElementById('subscriptionModalLabel').textContent = `Subscribe to ${planName}`;

      // Set plan ID in hidden input
 
      document.getElementById('planIdInput').value = planId;
    });
  });



  
});
</script>
