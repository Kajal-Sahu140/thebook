@extends('warehouse.master')
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


<main class="content">
    <div class="container p-0">
        <div aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('warehouse.order') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">Edit Order</li>
        </ol>
</div>
        <h1 class="h3 mb-3">Edit Order</h1>
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
                        <label class="form-label">Subtotal Price</label>
                        <input type="text" class="form-control" value="${{ $CartOrderSummary->subtotal_price }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Discount</label>
                        <input type="text" class="form-control" value="{{ $CartOrderSummary->total_discount }} IQD" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Coupon Discount</label>
                        <input type="text" class="form-control" value="{{ $CartOrderSummary->coupon_discount }} IQD" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Fee</label>
                        <input type="text" class="form-control" value="{{ $CartOrderSummary->delivery_fee }} IQD" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Date</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($CartOrderSummary->delivery_date)->format('Y-m-d') }}" disabled>
                    </div>
<div class="mb-3">
                    <label class="form-label">Delivery Address</label>
                    <input type="text" class="form-control" value="{{ $CartOrderSummary->order_address }}" disabled>
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
                            <th>Order status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CartOrderSummary->cartItems as $cartItem)
                        <!-- {{$cartItem}} -->
                            <tr>
                                <td>
                                    <img src="{{ $cartItem->product->images->first()->image_url ?? asset('images/default-product.png') }}" alt="Product" class="product-image" height="100px" width="100px">
                                </td>
                                <td>{{ $cartItem->product->product_name }}</td>
                                <td> {{ number_format($cartItem->price, 2) }} IQD</td>
                                <td>{{ $cartItem->quantity }}</td>
                                <td> {{ number_format($cartItem->price * $cartItem->quantity, 2) }} IQD</td>
                                <td>
                                    @if ($cartItem->order_status !== 'cancelled')
                                        <form action="{{ route('warehouse.order.ordercancel',$cartItem->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this item?')">Cancel</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>


                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <input type="text" class="form-control" value="{{ ucfirst($CartOrderSummary->payment_status) }}" disabled>
                    </div>
                    <!-- Editable Order Status -->
                     <form action="{{ route('warehouse.order.update', base64_encode($CartOrderSummary->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select name="order_status" class="form-control">
                            <option value="pending" {{ $CartOrderSummary->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $CartOrderSummary->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="delivered" {{ $CartOrderSummary->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $CartOrderSummary->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="return" {{ $CartOrderSummary->order_status == 'return' ? 'selected' : '' }}>Return</option>
                            <option value="shipped" {{ $CartOrderSummary->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Order</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
