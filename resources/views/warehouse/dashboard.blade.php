@extends('warehouse.master')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="content-body">
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Products Sold -->
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-1 h-100">
                    <div class="card-body">
                        <a href="{{ route('warehouse.product') }}" class="text-white">
                        <h3 class="text-white">Products Sold</h3>
                        <h2 class="text-white">{{ $bestSellingProducts->sum('total_quantity') }}</h2>
                        <i class="fa fa-shopping-cart display-5 opacity-5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- New Customers -->
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-3 h-100">
                    <div class="card-body">
                       
                        <h3 class="text-white">New Customers</h3>
                        <h2 class="text-white">{{ $userCount }}</h2>
                        <i class="fa fa-users display-5 opacity-5"></i>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders Section -->
        <div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3">Pending Orders</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Date Placed</th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Estimated Delivery</th>
                    </tr>
                </thead>
                        <tbody>
                            @forelse($pendingOrders as $order)
                                @foreach($order->cartItems as $cartItem)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                        <td>{{ $cartItem->product->product_name ?? 'N/A' }}</td>
                                       <td>{{ json_decode($cartItem->size)->name ?? 'N/A' }}</td>

                                        <td>{{ number_format($cartItem->price, 2) }} IQD</td>
                                        <td>
                                            {{ optional(\Carbon\Carbon::parse($order->delivery_date))->format('d M Y') ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No pending orders</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>

@endsection
