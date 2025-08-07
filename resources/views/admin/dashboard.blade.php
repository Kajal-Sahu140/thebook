@extends('admin.master')
@section('content')  
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-4"><strong>Analytics</strong> Dashboard</h1>

        <!-- Filters -->
      <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </div>
</form>

        <!-- Statistics Cards -->
        <div class="row">
    <!-- Total Users -->
    <div class="col-lg-2 col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <a href="{{ route('admin.users') }}">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h5 class="card-title text-primary">Total Users</h5>
                <h1 class="mt-1 mb-3">{{ $userCount }}</h1>
            </div>
            </a>
        </div>
    </div>
    
    <!-- Transaction -->
    <div class="col-lg-2 col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <a href="{{ route('admin.transaction') }}">
            <div class="card-body text-center">
                <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                <h5 class="card-title text-success">Transaction</h5>
                <h1 class="mt-1 mb-3">{{$transactionCount}}</h1>
            </div>
            </a>
        </div>
    </div>

    <!-- Product -->
    <div class="col-lg-2 col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <a href="{{ route('admin.product') }}">
            <div class="card-body text-center">
                <i class="fas fa-box-open fa-2x text-primary mb-2"></i>
                <h5 class="card-title text-primary">Product</h5>
                <h1 class="mt-1 mb-3">{{$productCount}}</h1>
            </div>
            </a>
        </div>
    </div>

    <!-- Notification -->
    <div class="col-lg-2 col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <div class="card-body text-center">
                <i class="fas fa-bell fa-2x text-info mb-2"></i>
                <h5 class="card-title text-info">Notification</h5>
                <h1 class="mt-1 mb-3">{{$notificationCount}}</h1>
            </div>
        </div>
    </div>

    <!-- Coupon -->
    <div class="col-lg-2 col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <a href="{{ route('admin.coupon') }}">
            <div class="card-body text-center">
                <i class="fas fa-tags fa-2x text-default mb-2"></i>
                <h5 class="card-title text-default">Coupon</h5>
                <h1 class="mt-1 mb-3">{{$couponCount}}</h1>
            </div>
            </a>
        </div>
    </div>

    <!-- Orders -->
    <div class="col-lg-2 col-md-4 mb-4">
        <div class="card shadow-sm border-light">
            <a href="{{ route('admin.order') }}">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x text-default mb-2"></i>
                <h5 class="card-title text-default">Orders</h5>
                <h1 class="mt-1 mb-3">{{$totalEarnings}}</h1>
            </div>
            </a>
        </div>
    </div>
</div>



        <!-- Charts -->
        <div class="row mt-4">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body">
                        <h5 class="card-title text-dark">Earnings Over Time</h5>
                        <canvas id="earningsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body">
                        <h5 class="card-title text-dark">User Growth Over Time</h5>
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Charts.js Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const earningsChart = new Chart(document.getElementById('earningsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($earningsLabels) !!}, // Add labels from backend
            datasets: [{
                label: 'Earnings',
                data: {!! json_encode($earningsData) !!}, // Add data from backend
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });

    const userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($userGrowthLabels) !!}, // Add labels from backend
            datasets: [{
                label: 'User Growth',
                data: {!! json_encode($userGrowthData) !!}, // Add data from backend
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.2)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>
@endsection
