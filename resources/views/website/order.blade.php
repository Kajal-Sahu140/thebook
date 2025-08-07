@include('website.header')
<style>

.order-date span {
    font-size: 15px;
    font-weight: 600;
    color: var(--heading);
}
</style>
<div class="site-bg">
    <div class="dashborad-page-warper section-padding">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="dashborad-sidebar">
                        <div class="dashborad-sidebar-head text-center">
                            <h3>{{ auth()->user()->name }}</h3>
                            <p>{{ auth()->user()->phone }}</p>
                        </div>
                        <div class="sidebar-menu">
                            <ul>
                                <li>
                                    <a href="{{ route('website.myprofile') }}">
                                        <i class="ti ti-user"></i>
                                        <span>{{ __('messages.my_profile') }}</span>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="{{ route('website.order') }}">
                                        <i class="ti ti-package"></i>
                                        <span>{{ __('messages.my_orders') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.myaddress') }}">
                                        <i class="ti ti-map-pin"></i>
                                        <span>{{ __('messages.my_address') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.mysavecard') }}">
                                        <i class="ti ti-credit-card"></i>
                                        <span>{{ __('messages.saved_cards') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.rating') }}">
                                        <i class="ti ti-star"></i>
                                        <span>{{ __('messages.reviews_ratings') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.signOut') }}">
                                        <i class="ti ti-rotate-clockwise"></i>
                                        <span>{{ __('messages.logout') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="dashborad-content-des">
                        <div class="dashborad-title-head d-flex justify-content-between align-items-center">
                            <h2>{{__('messages.myorder')}}</h2>
                           <div class="order-filter dropdown">
    <a href="javascript:;" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ti ti-adjustments"></i>  
        <span>Filter</span>  
    </a> 

    <div class="dropdown-menu">
        <div class="filter-drop-bg"> 
            <div class="filter-list">  
               <!-- <div class="form-check">
    <input class="form-check-input" type="checkbox" value="delivered" id="filterCheck01">
    <label class="form-check-label" for="filterCheck01">Delivered</label>
</div> -->

<div class="form-check">
    <input class="form-check-input" type="checkbox" value="cancelled" id="filterCheck02">
    <label class="form-check-label" for="filterCheck02">{{__('messages.cancelled')}}</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" value="return" id="filterCheck03">
    <label class="form-check-label" for="filterCheck03">{{__('messages.return')}}</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" value="pending" id="filterCheck04">
    <label class="form-check-label" for="filterCheck04">{{__('messages.pending')}}</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" value="delivered" id="filterCheck07">
    <label class="form-check-label" for="filterCheck07">{{__('messages.delivered')}}</label>
</div>


            <div class="filter-save-btn">
                <button class="btn" id="filter-save-btn">{{__('messages.save')}}</button>  
            </div>
        </div> 
    </div>
             </div>
                  </div>
                        </div>
                        <!-- Orders List -->
                        <div class="order-list-bg mt-4">
                            <ul class="list-unstyled">
                               @if ($orders->isNotEmpty())
    @foreach($orders as $order)
        @if($order->cartItems->isNotEmpty()) <!-- Check if cartItems is not empty -->
            @foreach($order->cartItems as $index => $item)
                <li class="d-flex flex-wrap align-items-center mb-4 border-bottom pb-3">
                    <div class="order-product d-flex flex-wrap align-items-center col-md-8">
                        <figure class="me-3 mb-0">
                            <a href="{{ route('website.orderDetail', ['order_id' => $order->id, 'product_id' => $item->product->product_id]) }}">
                                <img src="{{ $item->product->images->first()->image_url ?? asset('images/default-product.png') }}" 
                                     alt="{{ $item->product->product_name }}" 
                                     class="img-fluid rounded" 
                                     width="80" 
                                     height="80" />
                            </a>
                        </figure>
                        <figcaption>
                            <h3 class="mb-1">{{ $item->product->product_name }}</h3>
                            <p>{{__('messages.quantity')}}: <strong>{{ $item->quantity }}</strong></p>
                            <p>{{__('messages.price')}}: <strong> RS. {{ number_format($item->price, 2) }}</strong></p>
                        </figcaption>
                    </div>
                    <div class="order-status col-md-2 text-center">
                        <h5>{{__('messages.status')}}</h5>

                        @php
                            // Check if all cart items are cancelled
                            $allCartItemsCancelled = $order->cartItems->isNotEmpty() && 
                                                     $order->cartItems->every(fn($cartItem) => $cartItem->order_status === 'cancelled');

                            // Check individual cart item status first
                            if (!empty($item->order_status) && $item->order_status === 'cancelled') {
                                $badgeClass = 'bg-danger';
                                $statusText = 'Cancelled';
                            } else {
                                // Determine badge class based on order status if not all cart items are cancelled
                                if ($allCartItemsCancelled) {
                                    $badgeClass = 'bg-danger';
                                    $statusText = 'Cancelled';
                                } else {
                                    switch ($order->order_status) {
                                        case 'delivered':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'cancelled':
                                            $badgeClass = 'bg-danger';
                                            break;
                                        case 'pending':
                                            $badgeClass = 'bg-secondary';
                                            break;
                                        case 'processing':
                                            $badgeClass = 'bg-info';
                                            break;
                                        case 'shipped':
                                            $badgeClass = 'bg-primary';
                                            break;
                                        case 'return':
                                            $badgeClass = 'bg-success';
                                            break;
                                        default:
                                            $badgeClass = 'bg-warning';
                                    }
                                    $statusText = ucfirst($order->order_status);
                                }
                            }
                        @endphp

                        <span class="badge {{ $badgeClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                    <div class="order-date col-md-2 text-center" style="flex:8px;">
                        <h5>{{__('messages.delivery_by')}}</h5>
                        <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-Y') ?? 'TBA' }} </span>
                    </div>
                </li>
            @endforeach
        @else
            <!-- If cartItems is empty, show no items found message for this order -->
            <li class="d-flex flex-wrap align-items-center mb-4">
                <div class="order-product d-flex flex-wrap align-items-center col-md-8">
                    <figcaption>
                        <h3 class="mb-1">No items in this order</h3>
                    </figcaption>
                </div>
            </li>
        @endif
    @endforeach
@else
    <!-- If no orders exist, show the no orders message -->
    <li class="d-flex flex-wrap align-items-center mb-4">
        <div class="order-product d-flex flex-wrap align-items-center col-md-8">
            <figcaption>
                <h3 class="mb-1 text-center">No orders found</h3>
            </figcaption>
        </div>
    </li>
@endif


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.footer')
<script>
document.getElementById('filter-save-btn').addEventListener('click', function() {
    // Get the selected filter values (checkboxes)
    var selectedStatuses = [];
    document.querySelectorAll('.filter-list input[type="checkbox"]:checked').forEach(function(checkbox) {
        selectedStatuses.push(checkbox.value);
    });

    // If no filters are selected, we don't apply any filters (fetch all orders)
    if (selectedStatuses.length === 0) {
        selectedStatuses = ['']; // Fetch all orders as fallback
    }

    // Join the selected statuses with commas
    var statusQuery = selectedStatuses.join(',');

    // Create the new URL with query parameters
    var newUrl = window.location.pathname + '?status=' + statusQuery;

    // Update the URL without refreshing the page
    window.history.pushState({ path: newUrl }, '', newUrl);

    // Make an AJAX request to the backend with the selected filters
    fetch('/myorder?' + 'status=' + statusQuery)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            window.location.reload();
            return response.json();  // Parse the JSON response
        })
        .then(data => {
            // Assuming the backend returns the filtered orders in `data.orders`
            var orderContainer = document.getElementById('order-container'); // Ensure this element exists
            orderContainer.innerHTML = ''; // Clear existing orders

            if (!data.orders || data.orders.length === 0) {
                // No orders found, show a message
                orderContainer.innerHTML = '<p>No orders found for the selected filters.</p>';
                return;
            }

            // Populate the order container with filtered orders
            data.orders.forEach(function(order) {
                var orderItem = document.createElement('div');
                orderItem.classList.add('order-item');
                orderItem.innerHTML = `
                    <h4>Order #${order.order_id}</h4>
                    <p>Status: ${order.order_status}</p>
                    <p>Grand Total: $${order.grand_total}</p>
                    <p>Order Date: ${order.created_at}</p>
                `;
                orderContainer.appendChild(orderItem);
            });
        })
        .catch(error => {
            console.error('Error fetching filtered orders:', error);
        });
});


    </script>
