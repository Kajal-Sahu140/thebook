@extends('admin.master')
@section('content')
<style>
    .breadcrumb {
        background-color: #e9eef2;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
    }
    .breadcrumb li a {
        text-decoration: none;
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.coupon') }}">Coupons</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Coupon</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Coupon</h1>
        <div class="card">
            <div class="card-body">
                <form id="addCouponForm" action="{{ route('admin.coupon.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="code_format" class="form-label">Code Format</label>
        <select name="code_format" id="code_format" class="form-control @error('code_format') is-invalid @enderror">
            <option value="">Select Format</option>
            <option value="numeric" {{ old('code_format') === 'numeric' ? 'selected' : '' }}>Numeric</option>
            <option value="alphanumeric" {{ old('code_format') === 'alphanumeric' ? 'selected' : '' }}>Alphanumeric</option>
            <option value="alphabetical" {{ old('code_format') === 'alphabetical' ? 'selected' : '' }}>Alphabetical</option>
        </select>
        @error('code_format')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="discount_type" class="form-label">Discount Type</label>
        <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
            <option value="">Select Discount Type</option>
            <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
            <option value="flat" {{ old('discount_type') === 'flat' ? 'selected' : '' }}>Flat</option>
        </select>
        @error('discount_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="discount_value" class="form-label">Discount Value</label>
        <input type="number" name="discount_value" id="discount_value" class="form-control @error('discount_value') is-invalid @enderror" 
            value="{{ old('discount_value') }}" step="0.01" min="0" placeholder="Enter discount value">
        @error('discount_value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>
    <div class="mb-3">
        <label for="usage_limit_per_coupon" class="form-label">Usage Limit per Coupon</label>
        <input type="number" name="usage_limit_per_coupon" id="usage_limit_per_coupon" class="form-control @error('usage_limit_per_coupon') is-invalid @enderror" 
            value="{{ old('usage_limit_per_coupon') }}" min="1" placeholder="Enter usage limit per coupon">
        @error('usage_limit_per_coupon')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    <div class="mb-3">
        <label for="usage_limit_per_customer" class="form-label">Usage Limit per Customer</label>
        <input type="number" name="usage_limit_per_customer" id="usage_limit_per_customer" class="form-control @error('usage_limit_per_customer') is-invalid @enderror" 
            value="{{ old('usage_limit_per_customer') }}" min="1" placeholder="Enter usage limit per customer">
        @error('usage_limit_per_customer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    <div class="mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" 
            value="{{ old('start_date') }}"  min="{{ now()->toDateString() }}"placeholder="Select start date">
        @error('start_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    <div class="mb-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" 
            value="{{ old('end_date') }}"  min="{{ now()->toDateString() }}" placeholder="Select end date">
        @error('end_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    <div class="mb-3">
        <label for="min_purchase_amount" class="form-label">Minimum Purchase Amount</label>
        <input type="number" name="min_purchase_amount" id="min_purchase_amount" class="form-control @error('min_purchase_amount') is-invalid @enderror" 
            value="{{ old('min_purchase_amount') }}" step="0.01" min="0" placeholder="Enter minimum purchase amount">
        @error('min_purchase_amount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    <div class="mb-3">
        <label for="max_discount_amount" class="form-label">Maximum Discount Amount</label>
        <input type="number" name="max_discount_amount" id="max_discount_amount" class="form-control @error('max_discount_amount') is-invalid @enderror" 
            value="{{ old('max_discount_amount') }}" step="0.01" min="0" placeholder="Enter maximum discount amount">
        @error('max_discount_amount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    <button type="submit" class="btn btn-primary">Add Coupon</button>
</form>
            </div>
        </div>
    </div>
</main>
<!-- Validation Script -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
    // Function to update the max value of discount_value based on selected discount_type
    function updateDiscountValueMax() {
        var discountType = $('#discount_type').val();
        var discountValueInput = $('#discount_value');
        
        if (discountType === 'percentage') {
            discountValueInput.attr('max', 100);  // Set max to 100 if percentage
        } else {
            discountValueInput.removeAttr('max'); // Remove max for flat
        }
    }

    // Call the function to set the initial state
    updateDiscountValueMax();

    // Update the max value when discount_type changes
    $('#discount_type').change(function () {
        updateDiscountValueMax();
    });
});


   $(document).ready(function () {
        generateCouponCode();  // Auto-generate when the page is ready
    });
    // Function to generate a random coupon code
    function generateCouponCode(length = 8) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Characters to choose from
        let couponCode = '';
        // Loop to generate the code
        for (let i = 0; i < length; i++) {
            couponCode += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        // Set the generated code in the input field
        $('#coupon_code').val(couponCode); // Use jQuery to set the value
    }
    $(function () {
    $("#addCouponForm").validate({
        rules: {
            coupon_code: {
                required: true,
                maxlength: 50,
            },
            code_format: {
                required: true,
            },
            discount_type: {
                required: true,

            },
            discount_value: {
                required: true,
                number: true,
                min: 0,
                maxlength: 10
           
            },
            usage_limit_per_coupon: {
                required: true,
                number: true,
                min: 1,
                max: 100000, // Set max limit here
            },
            usage_limit_per_customer: {
                required: true,
                number: true,
                min: 1,
                max: 100, // Set max limit here
            },
            start_date: {
                required: true,
                date: true,
                min: "{{ now()->toDateString() }}",
            },
            end_date: {
                required: true,
                date: true,
                min: "{{ now()->toDateString() }}",
                greaterThanStartDate: "#start_date"
            },
            min_purchase_amount: {
                required: true,
                number: true,
                min: 0,
                maxlength: 10,
            },
            max_discount_amount: {
                number: true,
                min: 0,
                maxlength: 10
            },
        },
        messages: {
            coupon_code: {
                required: "Please enter the coupon code.",
                maxlength: "Coupon code cannot exceed 50 characters.",
            },
            code_format: {
                required: "Please select a code format.",
            },
            discount_type: {
                required: "Please select a discount type.",
            },
            discount_value: {
                required: "Please enter a discount value.",
                number: "Discount value must be a number.",
                min: "Discount value cannot be negative.",
               maxlength: "Discount value cannot exceed 10 characters.",
            },
            usage_limit_per_coupon: {
                required: "Please enter a usage limit per coupon.",
                number: "Usage limit must be a number.",
                min: "Usage limit must be at least 1.",
                max: "Usage limit cannot exceed 100000.", // Custom error for max value
            },
            usage_limit_per_customer: {
                required: "Please enter a usage limit per customer.",
                number: "Usage limit must be a number.",
                min: "Usage limit must be at least 1.",
                max: "Usage limit cannot exceed 100.", // Custom error for max value
            },
            start_date: {
                required: "Please select a start date.",
                date: "Enter a valid date.",
                min: "{{ now()->toDateString() }}",
            },
            end_date: {
                required: "Please select an end date.",
                date: "Enter a valid date.",
                min: "{{ now()->toDateString() }}",
                greaterThanStartDate: "End date must be after the start date.",
            },
            min_purchase_amount: {
                required: "Please enter a minimum purchase amount.",
                number: "Must be a valid number.",
                min: "Minimum purchase cannot be negative.",
                maxlength: "Minimum purchase cannot exceed 10 characters.",
            },
            max_discount_amount: {
                number: "Must be a valid number.",
                min: "Maximum discount cannot be negative.",
                maxlength: "Maximum discount cannot exceed 10 characters.",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});

</script>
@endsection

