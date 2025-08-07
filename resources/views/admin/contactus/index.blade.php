@extends('admin.master')
@section('content')
<style>
    /* Breadcrumb styles */
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
            white-space: nowrap; /* Prevent text wrapping */
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
            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Contact Us</h1>

        <div class="mb-3 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.contactus') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Name and username" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                 <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>User Name</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Reply</th>
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
                    <td>{{ $user->name ?? 'N/A' }}</td>
                    <td>{{ $user->user->name ?? 'N/A' }}</td>
                    <td>{{ $user->subject ?? 'N/A' }}</td>
                    <td>{{ $user->email ?? 'N/A' }}</td>
                    <td style="width:40%;">{{ $user->replay ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.contactus.view', $user->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No contact requests found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
                @if ($users->isNotEmpty())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
<!-- Include JQuery and SweetAlert2 for delete confirmation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace(); // Initialize Feather icons
    });

    $(document).ready(function() {
        // Handle delete confirmation
        $('.deleted').click(function() {
            const form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
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
