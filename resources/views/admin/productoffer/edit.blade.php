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
    .table-responsive {
        overflow-x: auto;
    }
    #discount_value-error{
        color: red;
    }
    .error{
        color: red;
    }
    /* Media query adjustments */
    @media (max-width: 768px) {
        .breadcrumb {
            font-size: 0.9rem;
        }
        .table th, .table td {
            font-size: 0.9rem;
        }
        .h3.mb-3 {
            font-size: 1.5rem;
        }
        .col-md-6 {
            width: 100%; /* Full-width columns on smaller screens */
        }
        .btn-info {
            width: 100%; /* Full-width Add button on smaller screens */
            margin-top: 0.5rem;
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
    }
    /* Summernote styling for proper visibility */
    .note-editable {
        min-height: 150px;
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.productoffer') }}">Product Offers</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Offer</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Product Offer</h1>
        <form id="editProductOfferForm" action="{{ route('admin.productoffer.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Offer Title -->
                        <div class="col-md-6 mb-3">
                            <label for="offer_title" class="form-label">Offer Title</label>
                            <input type="text" class="form-control @error('offer_title') is-invalid @enderror" name="offer_title" id="offer_title" value="{{ old('offer_title', $offer->offer_title) }}" placeholder="Enter the offer title" required>
                            @error('offer_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Product Selection -->
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">Product</label>
                            <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" {{ old('product_id', $offer->product_id) == $product->product_id ? 'selected' : '' }}>
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Offer Type -->
                        <div class="col-md-6 mb-3">
    <label for="offer_type" class="form-label">Offer Type</label>
    <select class="form-control @error('offer_type') is-invalid @enderror" name="offer_type" id="offer_type" required>
        <option value="">Select Offer Type</option>
        <option value="percentage" {{ old('offer_type', $offer->offer_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
        <option value="fixed" {{ old('offer_type', $offer->offer_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
    </select>
    @error('offer_type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Discount Value -->
<div class="col-md-6 mb-3">
    <label for="discount_value" class="form-label">Discount Value</label>
    <input type="number" class="form-control @error('discount_value') is-invalid @enderror" 
           name="discount_value" id="discount_value" 
           value="{{ old('discount_value', $offer->discount_value) }}" 
           placeholder="Enter discount value" required step="0.01">
    @error('discount_value')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                        <!-- Offer Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Offer Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Describe the offer in detail">{{ old('description', $offer->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date', $offer->start_date) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date', $offer->end_date) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Offer Image -->
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Offer Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
                            <p class="mt-2">Current Image: <img src="{{ $offer->image }}" alt="Offer Image" style="width: 100px;"></p>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                                <option value="active" {{ old('status', $offer->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $offer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Offer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>

 $(document).ready(function () {
        // Function to update validation rules dynamically
        function updateValidationRules() {
            const offerType = $('#offer_type').val(); // Get the selected offer type
            const discountInput = $('#discount_value');

            // Reset previous validation rules
            discountInput.prop('min', null).prop('max', null);

            if (offerType === 'percentage') {
                // For "percentage" type, set min 0 and max 99
                discountInput.prop('min', 0).prop('max', 99);
                discountInput.attr('placeholder', 'Enter percentage value (0-99)');
            } else if (offerType === 'fixed') {
                // For "fixed" type, set only min 0
                discountInput.prop('min', 0);
                discountInput.attr('placeholder', 'Enter fixed amount');
            }
        }

        // Trigger validation update when offer_type changes
        $('#offer_type').on('change', function () {
            updateValidationRules();
        });

        // Initialize validation rules on page load
        updateValidationRules();
    });

    $(function () {
        // Existing validation script for edit form
        $("#editProductOfferForm").validate({
            rules: {
                offer_title: {
                    required: true,
                    maxlength: 100,
                },
                product_id: {
                    required: true,
                },
                offer_type: {
                    required: true,
                },
                discount_value: {
                    required: true,
                    number: true,
                    min: 0,
                    max:99,
                },
                description: {
                    required: true,
                    maxlength: 500,
                },
                start_date: {
                    required: true,
                    date: true,
                },
                end_date: {
                    required: true,
                    date: true,
                    greaterThan: "#start_date"
                },
                image: {
                    extension: "jpg|jpeg|png",
                },
                status: {
                    required: true,
                },
            },
            messages: {
               offer_title: {
                    required: "Please enter the offer title.",
                    maxlength: "Offer title can't exceed 100 characters.",
                },
                product_id: {
                    required: "Please select a product.",
                },
                offer_type: {
                    required: "Please select an offer type.",
                },
                discount_value: {
                    required: "Please enter a discount value.",
                    number: "Discount value must be a number.",
                    min: "Discount value must be a positive number.",
                    max: "Discount value must be less than or equal to 99.",
                },
                description: {
                    required: "Please provide a description for the offer.",
                    maxlength: "Description can't exceed 150 characters.",
                },
                start_date: {
                    required: "Please select a start date.",
                },
                end_date: {
                    required: "Please select an end date.",
                    greaterThan: "End date must be after the start date.",
                },
                image: {
                    required: "Please upload an image for the offer.",
                    extension: "Only JPG, JPEG, and PNG formats are allowed.",
                },
                status: {
                    required: "Please select a status.",
                },
            },
            // Error handling as in Add form
        });
        $.validator.addMethod("greaterThan", function (value, element, param) {
            var startDate = $(param).val();
            return new Date(value) > new Date(startDate);
        }, "End date must be after the start date.");
    });
</script>
@endsection
