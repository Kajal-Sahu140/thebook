@extends('admin.master')
@section('content')
    <style>
        /* Card and form styling */
        .card {
            margin: 20px;
        }
        /* Form controls are full-width on small screens */
        @media (max-width: 768px) {
            .form-control {
                width: 100%;
            }
        }
        /* Breadcrumb styling */
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
                <li class="breadcrumb-item"><a href="{{ route('admin.coupon') }}">Coupons List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show Coupon</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-10 mx-auto mt-7">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Coupon Details</h3>
            </div>
            <form class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="couponCode" class="col-sm-2 col-form-label">Coupon Code</label>
                        <div class="col-sm-10">
                            <input type="text" name="coupon_code" class="form-control" value="{{ $coupon->coupon_code }}" readonly id="couponCode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discountType" class="col-sm-2 col-form-label">Discount Type</label>
                        <div class="col-sm-10">
                            <input type="text" name="discount_type" class="form-control" value="{{ ucfirst($coupon->discount_type) }}" readonly id="discountType">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discountValue" class="col-sm-2 col-form-label">Discount Value</label>
                        <div class="col-sm-10">
                            <input type="text" name="discount_value" class="form-control" value="{{ $coupon->discount_value }}" readonly id="discountValue">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="usageLimitPerCoupon" class="col-sm-2 col-form-label">Usage Limit per Coupon</label>
                        <div class="col-sm-10">
                            <input type="text" name="usage_limit_per_coupon" class="form-control" value="{{ $coupon->usage_limit_per_coupon }}" readonly id="usageLimitPerCoupon">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="usageLimitPerCustomer" class="col-sm-2 col-form-label">Usage Limit per Customer</label>
                        <div class="col-sm-10">
                            <input type="text" name="usage_limit_per_customer" class="form-control" value="{{ $coupon->usage_limit_per_customer }}" readonly id="usageLimitPerCustomer">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minPurchaseAmount" class="col-sm-2 col-form-label">Minimum Purchase Amount</label>
                        <div class="col-sm-10">
                            <input type="text" name="min_purchase_amount" class="form-control" value="{{ $coupon->min_purchase_amount ?? 'N/A' }}" readonly id="minPurchaseAmount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="maxDiscountAmount" class="col-sm-2 col-form-label">Maximum Discount Amount</label>
                        <div class="col-sm-10">
                            <input type="text" name="max_discount_amount" class="form-control" value="{{ $coupon->max_discount_amount ?? 'N/A' }}" readonly id="maxDiscountAmount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="startDate" class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="start_date" class="form-control" value="{{ $coupon->start_date }}" readonly id="startDate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="endDate" class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="end_date" class="form-control" value="{{ $coupon->end_date }}" readonly id="endDate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input type="text" name="status" class="form-control" value="{{ ucfirst($coupon->status ?? 'N/A') }}" readonly id="status">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Optional: Include buttons for further actions if needed -->
                </div>
            </form>
        </div>
    </div>
@endsection
