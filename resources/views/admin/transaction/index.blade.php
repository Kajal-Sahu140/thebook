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
    .breadcrumb-item + .breadcrumb-item::before {
        content: '/';
        padding: 0 0.5rem;
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
        .mb-3 .d-flex {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-info {
            margin-top: 0.5rem;
            width: 100%;
        }
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transactions</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Transactions</h1>
        <div class="mb-3 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.transaction') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Transaction ID" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Transaction ID</th>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
                        @endphp
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $transaction->transaction_id }}</td>
                                <td>{{ $transaction->order_id }}</td>
                                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($transaction->payment_method) }}</td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ strtoupper($transaction->currency) }}</td>
                                <td>
                                    <span class="badge {{ $transaction->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($transaction->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($transactions->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $transactions->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
