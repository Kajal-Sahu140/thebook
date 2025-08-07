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
            <li class="breadcrumb-item active" aria-current="page">Add Plan</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Plan</h1>
        <div class="card">
            <div class="card-body">
                <form id="addCategoryForm" action="{{route('admin.plan.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter Name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter a description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                      <div class="mb-3">
                        <label for="price" class="form-label"> Security Price</label>
                        <input type="text" name="security_amount" id="security_amount" class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('security_amount') }}" placeholder="securityamount">
                        @error('security_amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


                   <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price') }}" placeholder="Enter price">
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                <div class="mb-3">
                    <label for="tbd_price" class="form-label">Tbd Price</label>
                    <input type="text" name="tbd_price" id="tbd_price" class="form-control @error('tbd_price') is-invalid @enderror"
                        value="{{ old('tbd_price') }}" placeholder="Enter tbd price">
                    @error('tbd_price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount" class="form-label">Discount (%)</label>
                    <input type="text" name="discount" id="discount" class="form-control @error('discount') is-invalid @enderror"
                        value="{{ old('discount') }}" placeholder="Auto-calculated discount" readonly>
                    @error('discount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                    

                    <div class="mb-3">
                        <label for="days" class="form-label">Days</label>
                        <input type="number" name="days" id="days" class="form-control @error('days') is-invalid @enderror"
                            value="{{ old('days') }}" placeholder="Enter days">
                        @error('days')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                     <div class="mb-3">
                        <label for="minum_order" class="form-label">Minium Order</label>
                        <input type="number" name="minum_order" id="minum_order" class="form-control @error('minum_order') is-invalid @enderror"
                            value="{{ old('minum_order') }}" placeholder="Enter minum order">
                        @error('minum_order')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity') }}" placeholder="Enter quantity">
                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="1"
                                {{ old('status') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0"
                                {{ old('status') === '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">Inactive</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Plan</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $.validator.addMethod("tbdLessThanPrice", function(value, element) {
    var price = parseFloat($('#price').val());
    var tbdPrice = parseFloat(value);
    if (isNaN(price) || isNaN(tbdPrice)) return true;
    return tbdPrice <= price;
}, "TBD Price must be less than or equal to Price.");

    $(document).ready(function () {
        $("#addCategoryForm").validate({
           rules: {
        name: { required: true, maxlength: 30 },
        description: { required: true, maxlength: 1000 },
        price: { required: true, number: true, min: 1, max: 10000 },
        tbd_price: {
            required: true,
            number: true,
            tbdLessThanPrice: true
        },
        discount: { required: true, digits: true },
        quantity: { required: true, digits: true },
        status: { required: true }
    },
    messages: {
        name: { required: "Please enter the name.", maxlength: "Name can't exceed 30 characters." },
        description: { required: "Please provide a description.", maxlength: "Description can't exceed 1000 characters." },
        price: {
            required: "Please enter a price.",
            number: "Please enter a valid number.",
            min: "Price must be at least 1.",
            max: "Price cannot be more than 10000."
        },
        tbd_price: {
            required: "Please enter TBD price.",
            number: "Please enter a valid number.",
            tbdLessThanPrice: "TBD Price cannot be greater than the main Price."
        },
        discount: { required: "Please enter a discount.", digits: "Please enter whole numbers only." },
        quantity: { required: "Please enter a quantity.", digits: "Please enter whole numbers only." },
        status: { required: "Please select a status." }
    },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

    
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const priceInput = document.getElementById('price');
    const tbdPriceInput = document.getElementById('tbd_price');
    const discountInput = document.getElementById('discount');

    function calculateDiscount() {
        const price = parseFloat(priceInput.value);
        const tbdPrice = parseFloat(tbdPriceInput.value);

        if (!isNaN(price) && !isNaN(tbdPrice) && price > 0 && tbdPrice <= price) {
            const discount = ((price - tbdPrice) / price) * 100;
            discountInput.value = discount.toFixed(2); // e.g., 20.00
        } else {
            discountInput.value = '';
        }
    }

    priceInput.addEventListener('input', calculateDiscount);
    tbdPriceInput.addEventListener('input', calculateDiscount);
});
</script>

@endsection
