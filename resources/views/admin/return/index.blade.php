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
            <li class="breadcrumb-item active" aria-current="page">Return and Refunds</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Return and Refund Requests</h1>

        <div class="mb-3 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.return') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Product Name or Status" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>User Name</th>
                            <th>Order ID</th>
                            <th>Product Name</th>
                            <th>Return Reason</th>
                            <th>Status</th>
                            <th>Comments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($returnOrders->currentPage() - 1) * $returnOrders->perPage() + 1;
                        @endphp
                        @forelse($returnOrders as $return)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $return->user->name ?? 'User'}}</td>
                                <td>{{ $return->order->order_id }}</td>
                                <td>{{ $return->product->product_name }}</td>
                                <td>{{ $return->reason->reason }}</td>
                                <td>
                                    <form action="{{ route('admin.return.updateStatus', $return->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="return_status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                            <option value="pending" {{ $return->return_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $return->return_status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $return->return_status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ Str::limit($return->return_comments, 30) ?? '' }}</td>
                                <td>
                                    <a href="{{ route('admin.return.view', base64_encode($return->id)) }}" class="btn btn-info btn-sm">View</a>
                                    <!-- @if ($return->return_status == 'Approved' && !$return->refund)
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#refundModal-{{ $return->id }}">
                                        Refund
                                    </button>
                                @endif -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No return requests found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($returnOrders->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $returnOrders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@if(!$returnOrders->isEmpty())
<div class="modal fade" id="refundModal-{{ $return->id }}" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.refund.create', $return->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel">Refund Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="refundAmount" class="form-label">Refund Amount</label>
                        <input type="number" name="refund_amount" id="refundAmount" class="form-control" placeholder="Enter refund amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="refundComments" class="form-label">Refund Comments</label>
                        <textarea name="refund_comments" id="refundComments" class="form-control" placeholder="Enter refund comments"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Confirm Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
    });
    $(document).ready(function() {
        $('.deleted').click(function() {
            const form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Return Request!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
