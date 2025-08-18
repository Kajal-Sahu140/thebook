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
    /* Media query adjustments */
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
        /* Stack form elements and add full width for the Add button */
        .mb-2 .d-flex {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-info {
            width: 100%; /* Full-width Add button on smaller screens */
            margin-top: 0.5rem;
        }
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Users</h1>
        <!-- Search Form -->
        <div class="mb-2 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.users') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
            <!-- Status Filter -->
            <select name="status" id="status" class="form-select">
                    <option value="">All</option>
                    <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="de-active" {{ request()->input('status') == 'de-active' ? 'selected' : '' }}>Inactive</option>
                </select>
            <input type="text" name="search" class="form-control me-2" placeholder="Search by Name & phone" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
            <table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>User</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Transaction Type</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = ($histories->currentPage() - 1) * $histories->perPage() + 1;
        @endphp
        @forelse($histories as $history)
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $history->user->name ?? 'N/A' }}</td>
                <td>{{ number_format($history->amount, 2) }}</td>
                <td>
                    @if($history->type == 'credit')
                        <span class="badge bg-success">Credit</span>
                    @else
                        <span class="badge bg-danger">Debit</span>
                    @endif
                </td>
                <td>{{ ucfirst(str_replace('_', ' ', $history->transaction_type)) }}</td>
                <td>{{ $history->created_at->format('d-m-Y h:i A') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No transactions found</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if ($histories->isNotEmpty())
    <div class="d-flex justify-content-left mt-3">
        {{ $histories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
@endif

        
            </div>
        </div>
    </div>
</main>
<!-- JQuery and SweetAlert2 for delete confirmation -->

@endsection
