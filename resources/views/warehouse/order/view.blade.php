@extends('warehouse.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<main class="content">
    <div class="container p-0">
        <div aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('warehouse.order') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">View Order</li>
        </ol>
         @if ($CartOrderSummary->cartItems->isNotEmpty() && $CartOrderSummary->cartItems->first()->product)
   <a href="{{ route('admin.download.invoice', ['order_id' => $CartOrderSummary->id, 'product_id' => $CartOrderSummary->cartItems->first()->product->product_id]) }}" 
   class="btn btn-dark" 
   style="right:360px; position: absolute;">
    <i class="fas fa-print"></i> <!-- Print Icon -->
</a>

@else
    <p>No products available for invoice.</p>
@endif
</div>
        <h1 class="h3 mb-3">View Order</h1>
        <div class="card">
            <div class="card-body">
                <!-- Order Details -->
                <div class="mb-3">
                    <label class="form-label">Order ID</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->order_id }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->user->name ?? 'User' }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Customer Email</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->user->email ?? '' }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Items</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->total_items }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Grand Total</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->grand_total }} IQD" disabled>
                </div>

                <!-- Product Details -->
                <h5 class="mb-3 mt-4">Product Details</h5>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CartOrderSummary->cartItems as $cartItem)
                            <tr>
                                <td>
                                    <img src="{{ $cartItem->product->images->first()->image_url ?? asset('images/default-product.png') }}" alt="Product" class="product-image" style="width: 64px; height: 64px;">
                                </td>
                                <td>{{ $cartItem->product->product_name }}</td>
                                <td>{{ number_format($cartItem->product->base_price, 2) }} IQD</td>
                                <td>{{ $cartItem->quantity }}</td>
                                <td>{{ number_format($cartItem->product->base_price * $cartItem->quantity, 2) }} IQD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>

                <!-- Other Order Details -->
                <div class="mb-3">
                    <label class="form-label">Delivery Fee</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->delivery_fee }} IQD" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Delivered Date</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($CartOrderSummary->delivery_date)->format('Y-m-d') }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Delivery Address</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->order_address }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($CartOrderSummary->payment_status) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Order Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($CartOrderSummary->order_status) }}" disabled>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Order Date</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($CartOrderSummary->created_at)->format('Y-m-d') }}" disabled>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
