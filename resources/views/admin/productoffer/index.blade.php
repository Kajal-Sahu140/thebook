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
            <li class="breadcrumb-item active" aria-current="page">Product Offers</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Product Offers</h1>
        <!-- Search Form -->
        <div class="mb-2 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.productoffer') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Offer Title & Product Name" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <a href="{{ route('admin.productoffer.create') }}" class="btn btn-info ms-sm-3 mt-2 mt-sm-0">
                <i class="align-middle me-1" data-feather="plus"></i> Add Offer
            </a>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Offer Title</th>
                            <th>Product Name</th>
                            <th>Offer Type</th>
                            <th>Discount Value</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($product_offers->currentPage() - 1) * $product_offers->perPage() + 1;
                        @endphp
                        @forelse($product_offers as $offer)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $offer->offer_title }}</td>
                                <td>{{ $offer->product->product_name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($offer->offer_type) }}</td>
                                <td>
                                    @if($offer->offer_type === 'percentage')
                                        {{ $offer->discount_value }}%
                                    @else
                                        {{ number_format($offer->discount_value, 2) }} IQD
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $offer->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($offer->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{route('admin.productoffer.view',$offer->id)}}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{route('admin.productoffer.edit',base64_encode($offer->id))}}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.productoffer.destory', base64_encode($offer->id)) }}" method="POST" style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No product offers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                @if ($product_offers->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $product_offers->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
<!-- JQuery and SweetAlert2 for delete confirmation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
    });
    $(document).ready(function() {
        $('.delete').click(function() {
            const form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this offer!',
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
