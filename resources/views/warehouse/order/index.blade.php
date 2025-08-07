@extends('warehouse.master')
@section('content')
<style>
   button, select {
   text-transform: none;
   margin-left: 10px;
   }
   .btn {
   padding: 7px 15px;
   margin-left: 10px;
   }
   .badge-lg {
   font-size: 14px; /* Bigger text */
   padding: 8px 10px; /* More padding */
   font-weight: bold; /* Bold text */
   border-radius: 5px; /* Rounded edges */
   }
   .pagination{
   margin-left: 20px;
   }
</style>
<div class="content-body">
 <div class="container-fluid mt-3">

   <div aria-label="breadcrumb">
      <ol class="breadcrumb float-end">
         <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
         <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">Orders</li>
      </ol>
   </div>
   <h1 class="h3 mb-3">Order Management</h1>
   <!-- Search Form -->
   <div class="mb-2 d-flex justify-content-end flex-wrap">
      <form action="{{ route('warehouse.order') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
         <!-- Search by Order ID -->
         <input 
            type="text" 
            name="order_id" 
            class="form-control me-2" 
            placeholder="Search by Order ID" 
            value="{{ request()->input('order_id') }}"
            maxlength="10"
            >
         <!-- Filter by Order Status -->
         <select name="order_status" class="form-select me-2">
            <option value="">All Order Status</option>
            <option value="pending" {{ request()->input('order_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="delivered" {{ request()->input('order_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request()->input('order_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <!-- <option value="refunded" {{ request()->input('order_status') == 'refunded' ? 'selected' : '' }}>Refunded</option> -->
            <option value="shipped" {{ request()->input('order_status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="processing" {{ request()->input('order_status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="return" {{ request()->input('order_status') == 'return' ? 'selected' : '' }}>Return</option>
         </select>
         <!-- Submit and Reset Buttons -->
         <button type="submit" class="btn btn-primary">Search</button>
         <a href="{{ route('warehouse.order') }}" class="btn btn-secondary ms-2">Reset</a>
      </form>
   </div>
   <!-- Order Table -->
   <div class="card shadow">
      <div class="card-body table-responsive">
         <table class="table  table-striped">
            <thead>
               <tr >
                  <th>Sr.No</th>
                  <th>Order ID</th>
                  <th>User</th>
                  <th>Total Items</th>
                  <th>Subtotal</th>
                  <th>Discount</th>
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
                  <td>
                     <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $order->user->name ?? 'N/A' }}">
                     {{ \Illuminate\Support\Str::limit($order->user->name ?? 'user', 10) }}
                     </span>
                  </td>
                  <!-- Enable Bootstrap Tooltip -->
                  <script>
                     document.addEventListener("DOMContentLoaded", function() {
                         var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                             return new bootstrap.Tooltip(tooltipTriggerEl);
                         });
                     });
                  </script>
                  <td>{{ $order->total_items }}</td>
                  <td>{{ number_format($order->subtotal_price, 2) }} IQD</td>
                  <td>{{ number_format($order->total_discount, 2) }} IQD</td>
                  <td>{{ number_format($order->delivery_fee, 2) }} IQD</td>
                  <td>{{ number_format($order->grand_total, 2) }} IQD</td>
                  <td>
                     <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-danger' }} badge-lg">
                     {{ ucfirst($order->payment_status) }}
                     </span>
                  </td>
                  <td>
                     <span class="badge {{ $order->order_status === 'delivered' ? 'bg-success' : ($order->order_status === 'pending' ? 'bg-warning' : 'bg-danger') }} badge-lg">
                     {{ ucfirst($order->order_status) }}
                     </span>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') }}</td>
                  <td>
                     <a href="{{ route('warehouse.order.view', base64_encode($order->id)) }}" class="btn btn-info btn-sm">View</a>
                     <a href="{{ route('warehouse.order.edit', base64_encode($order->id)) }}" class="btn btn-warning btn-sm">Edit</a>
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
         <div class="d-flex justify-content-left mt-5">
            {{ $CartOrderSummary->appends(request()->query())->links('pagination::bootstrap-5') }}
         </div>
         @endif
      </div>
   </div>
 </div>
</div>
</main>
@endsection
