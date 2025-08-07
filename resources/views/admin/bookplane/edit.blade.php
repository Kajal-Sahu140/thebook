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
            <li class="breadcrumb-item active" aria-current="page">Edit Plan</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Plan</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.plan.update',['id'=>$planModule->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $planModule->name) }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Enter Name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter a description">{{ old('description', $planModule->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                

                    <div class="mb-3">
                        <label for="security_amount" class="form-label">Security Price</label>
                        <input type="text" name="security_amount" id="security_amount" 
                               value="{{ old('security_amount', $planModule->security_amount) }}" 
                               class="form-control @error('security_amount') is-invalid @enderror" 
                               placeholder="Enter security amount">
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" id="price" 
                               value="{{ old('price', $planModule->price) }}" 
                               class="form-control @error('price') is-invalid @enderror" 
                               placeholder="Enter price">
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                     <div class="mb-3">
                        <label for="tbd_price" class="form-label">Tbd Price</label>
                        <input type="text" name="tbd_price" id="tbd_price" class="form-control @error('tbd_price') is-invalid @enderror"
                            value="{{ old('tbd_price', $planModule->tbd_price) }}" placeholder="Enter tbd_price">
                        @error('tbd_price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <input type="text" name="discount" id="discount" 
                               value="{{ old('discount', $planModule->discount) }}" 
                               class="form-control @error('discount') is-invalid @enderror" 
                               placeholder="Enter discount">
                        @error('discount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                      

                    <div class="mb-3">
                        <label for="days" class="form-label">Days</label>
                        <input type="number" name="days" id="days" class="form-control @error('days') is-invalid @enderror"
                            value="{{ old('days', $planModule->days) }}" placeholder="Enter days">
                        @error('days')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                     <div class="mb-3">
                        <label for="minum_order" class="form-label">Minium order</label>
                        <input type="number" name="minum_order" id="minum_order" class="form-control @error('minum_order') is-invalid @enderror"
                            value="{{ old('minum_order', $planModule->minum_order) }}" placeholder="Enter minum order">
                        @error('minum_order')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" 
                               value="{{ old('quantity', $planModule->quantity) }}" 
                               class="form-control @error('quantity') is-invalid @enderror" 
                               placeholder="Enter quantity">
                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="1"
                                {{ old('status', $planModule->status) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0"
                                {{ old('status', $planModule->status) == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">Inactive</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Plan</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $("form").validate({
        rules: {
            name: { required: function(el){ return $('#name').val().trim() === ''; } },
            description: { required: function(el){ return $('#description').val().trim() === ''; } },
            security_amount: {
                required: function(el){ return $('#security_amount').val().trim() === ''; },
                number: true
            },
            price: {
                required: function(el){ return $('#price').val().trim() === ''; },
                number: true,
                min: 1,
                max: 10000
            },
            tbd_price: {
                required: function(el){ return $('#tbd_price').val().trim() === ''; },
                number: true,
                max: function() {
                    return parseFloat($('#price').val()) || 0;
                }
            },
            discount: {
                required: function(el){ return $('#discount').val().trim() === ''; },
                number: true,
                max: 100
            },
            days: {
                required: function(el){ return $('#days').val().trim() === ''; },
                digits: true
            },
            minum_order: {
                required: function(el){ return $('#minum_order').val().trim() === ''; },
                digits: true
            },
            quantity: {
                required: function(el){ return $('#quantity').val().trim() === ''; },
                digits: true
            },
            status: { required: true }
        },
        messages: {
               price: {
                min: "Price must be at least 1.",
                max: "Price cannot be more than 10000.",
                number: "Please enter a valid number for price."
            },
            tbd_price: {
                max: "TBD Price cannot be greater than Price."
            },
            discount: {
                max: "Discount cannot be more than 100%."
            }
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
            discountInput.value = discount.toFixed(2);
        } else {
            discountInput.value = '';
        }
    }

    priceInput.addEventListener('input', calculateDiscount);
    tbdPriceInput.addEventListener('input', calculateDiscount);
});
</script>
