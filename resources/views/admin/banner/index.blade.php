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
            <li class="breadcrumb-item active" aria-current="page">Banner</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Banner Management</h1>
        <!-- Search Form -->
        <div class="mb-2 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.banner') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Title" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
           <a href="{{route('admin.banner.create')}}" class="btn btn-info ms-sm-3 mt-2 mt-sm-0">
                <i class="align-middle me-1" data-feather="plus"></i> Add
            </a>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($users->currentPage() - 1) * $users->perPage() + 1;
                        @endphp
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $user->title }}</td>
                               <td><img src="{{ $user->web_banner_image }}" height="50px" alt="Image"></td>
                                <td>{{$user->discount}}%</td>
                                <td>{{ \Carbon\Carbon::parse($user->start_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->end_date)->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.banner.view', base64_encode($user->id)) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.banner.edit', base64_encode($user->id)) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- <form action="{{ route('admin.banner.destory', base64_encode($user->id)) }}" method="POST" style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete">Delete</button>
                                    </form> -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No banner found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
          <!-- Pagination -->
                @if ($users->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                text: 'You will not be able to recover this user!',
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
