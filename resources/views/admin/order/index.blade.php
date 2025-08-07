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
        .mb-2 .d-flex {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-info {
            width: 100%;
            margin-top: 0.5rem;
        }
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Order Management</h1>

        <!-- Search Form -->
       <div class="mb-2 d-flex justify-content-end flex-wrap">
    <form action="{{ route('admin.order') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
        <!-- Search by Order ID -->
        <input 
            type="text" 
            name="order_id" 
            class="form-control me-2" 
            placeholder="Search by Order ID" 
            value="{{ request()->input('order_id') }}"
        >
        <!-- Filter by Order Status -->
        <select name="order_status" class="form-select me-2">
            <option value="">All Order Status</option>
            <option value="pending" {{ request()->input('order_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request()->input('order_status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="canceled" {{ request()->input('order_status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
            <option value="refunded" {{ request()->input('order_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            <option value="shipped" {{ request()->input('order_status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="processing" {{ request()->input('order_status') == 'processing' ? 'selected' : '' }}>Processing</option>
            
        </select>

        <!-- Submit and Reset Buttons -->
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('admin.order') }}" class="btn btn-secondary ms-2">Reset</a>
    </form>
</div>


        <!-- Order Table -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Total Items</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Coupon Discount</th>
                            <th>Delivery Fee</th>
                            <th>Grand Total</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($CartOrderSummary->currentPage() - 1) * $CartOrderSummary->perPage() + 1;
                        @endphp
                        @forelse($CartOrderSummary as $order)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($order->user->name ?? 'User', 10) }}</td>

                                <td>{{ $order->total_items }}</td>
                                <td> {{ number_format($order->subtotal_price, 2) }} IQD</td>
                                <td> {{ number_format($order->total_discount, 2) }}  IQD</td>
                                <td> {{ number_format($order->coupon_discount, 2) }} IQD</td>
                                <td> {{ number_format($order->delivery_fee, 2) }} IQD</td>
                                <td> {{ number_format($order->grand_total, 2) }} IQD</td>
                                <td>
                                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $order->order_status === 'completed' ? 'bg-success' : ($order->order_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                    <a href="{{ route('admin.order.view', base64_encode($order->id)) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.order.edit', base64_encode($order->id)) }}" class="btn btn-warning btn-sm">Edit</a>
</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                @if ($CartOrderSummary->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $CartOrderSummary->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
