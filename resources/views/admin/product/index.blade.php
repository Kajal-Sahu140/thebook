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
            <li class="breadcrumb-item active" aria-current="page">Products</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Product Management</h1>
        <!-- Search Form -->
        <div class="mb-2 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.product') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Product Name" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
           <a href="{{ route('admin.product.create') }}" class="btn btn-info ms-sm-3 mt-2 mt-sm-0">
                <i class="align-middle me-1" data-feather="plus"></i> Add Product
            </a>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Brand</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($products->currentPage() - 1) * $products->perPage() + 1;
                        @endphp
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ Str::limit($product->product_name, 20) ?? '' }}</td>
                                <td>{{ Str::limit($product->description, 50) }}</td>
                               <td>
                               
                                @if($productImages[$product->product_id] !== null)
                                    <img src="{{ $productImages[$product->product_id]->image_url ?? '' }}" height="50px" alt="Product Image">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td> 
                                <td>{{ $product->base_price }} IQD </td>
                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $product->status === 1 ? 'bg-success' : 'bg-danger' }}">{{ $product->status === 1 ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.product.view', base64_encode($product->product_id)) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.product.edit', base64_encode($product->product_id)) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- <form action="{{ route('admin.product.destory', base64_encode($product->product_id)) }}" method="POST" style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                                    </form> -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                @if ($products->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                text: 'This will permanently delete the product!',
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
