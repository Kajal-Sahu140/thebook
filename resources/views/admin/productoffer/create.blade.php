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
            width: 100%;
        }
        .btn-info {
            width: 100%;
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
            <li class="breadcrumb-item active" aria-current="page">Add Offer</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Product Offer</h1>
        <form id="addProductOfferForm" action="{{ route('admin.productoffer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Offer Title -->
                        <div class="col-md-6 mb-3">
                            <label for="offer_title" class="form-label">Offer Title</label>
                            <input type="text" class="form-control @error('offer_title') is-invalid @enderror" name="offer_title" id="offer_title" value="{{ old('offer_title') }}" placeholder="Enter the offer title">
                            @error('offer_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Product Selection -->
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">Product</label>
                            <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="product_id">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" {{ old('product_id') == $product->product_id ? 'selected' : '' }}>
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
                            <select class="form-control @error('offer_type') is-invalid @enderror" name="offer_type" id="offer_type">
                                <option value="">Select Offer Type</option>
                                <option value="percentage" {{ old('offer_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('offer_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('offer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Discount Value -->
                        <div class="col-md-6 mb-3">
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="number" class="form-control @error('discount_value') is-invalid @enderror" name="discount_value" id="discount_value" value="{{ old('discount_value') }}" placeholder="Enter discount value">
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Offer Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Offer Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Describe the offer in detail">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Offer Image -->
                       <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Offer Image</label>
                            
                            <!-- File Input -->
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Offer</button>
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
        // Update validation rules dynamically based on offer type
        function updateValidationRules() {
            const offerType = $('#offer_type').val();
            const discountInput = $('#discount_value');
            discountInput.prop('min', null).prop('max', null);

            if (offerType === 'percentage') {
                discountInput.prop('min', 1).prop('max', 100);
            } else if (offerType === 'fixed') {
                discountInput.prop('min', 1).prop('max', null);
            }
        }

        $('#offer_type').on('change', updateValidationRules);

        // jQuery Validation Plugin
        $('#addProductOfferForm').validate({
            rules: {
                offer_title:{
                    required: true,
                    maxlength: 50
                },
                product_id: "required",
                offer_type: "required",
                description:{
                    required: true,
                    maxlength: 150,
                }
                discount_value: {
                    required: true,
                    number: true,
                },
                start_date: "required",
                end_date: {
                    required: true,
                    greaterThan: "#start_date"
                }
            }, 
            messages: {
                offer_title:{
                    required: "Please enter a title for the offer.",
                    maxlength: "Title should not exceed 50 characters."
                }
                product_id: "Please select a product.",
                offer_type: "Please select an offer type.",
                description: {
                    required: "Please enter a description for the offer.",
                    maxlength: "Description should not exceed 150 characters."
                }
                discount_value: {
                    required: "Please enter a discount value.",
                    number: "Please enter a valid number."
                },
                start_date: "Please select a start date.",
                end_date: "Please select an end date that is after the start date."
            }
        });

        // Custom validator for end date
        $.validator.addMethod("greaterThan", function (value, element, params) {
            return new Date(value) > new Date($(params).val());
        }, "End date must be after the start date.");
    });
</script>
@endsection
