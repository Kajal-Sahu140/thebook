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
    /* Responsive table styles */
    .table-responsive {
        overflow-x: auto;
    }
    /* Responsive adjustments for smaller screens */
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
            width: 100%; /* Full-width on smaller screens */
        }
    }
</style>
<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product Ratings</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Product Ratings</h1>
        <div class="mb-3 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.rating') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Product Name or Rating" value="{{ request()->input('search') }}">
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
                            <th>Product Name</th>
                            <th>Rating</th>
                            <th>Review</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($productRatings->currentPage() - 1) * $productRatings->perPage() + 1;
                        @endphp
                        @forelse($productRatings as $rating)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td> {{$rating->user->name ?? 'User'}}</td>
                                <td>{{ $rating->product->product_name }}</td>
                                <td>
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $rating->rating)
            <i class="fas fa-star text-warning"></i> <!-- Full star -->
        @elseif ($i == floor($rating->rating) + 0.5 && $rating->rating - floor($rating->rating) >= 0.5)
            <i class="fas fa-star-half-alt text-warning"></i> <!-- Half star -->
        @else
            <i class="far fa-star text-warning"></i> <!-- Empty star -->
        @endif
    @endfor
</td>

                                <td>{{ Str::limit($rating->review, 30) ?? '' }}</td>
                                
                                <td>
                                    <a href="{{ route('admin.rating.view', base64_encode($rating->id)) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.rating.edit', base64_encode($rating->id)) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.rating.destory', base64_encode($rating->id)) }}" method="POST" style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm deleted">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No product ratings found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($productRatings->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $productRatings->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
<!-- Include JQuery, SweetAlert2 CSS, and JS for delete confirmation -->
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
                text: 'You will not be able to recover this Rating!',
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
