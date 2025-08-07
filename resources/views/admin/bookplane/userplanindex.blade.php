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
            <li class="breadcrumb-item active" aria-current="page">Plan</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"> User Plan List</h1>

        <div class="mb-3 d-flex justify-content-end flex-wrap">
            <form action="{{ route('admin.plan.index') }}" method="GET" class="d-flex flex-grow-1 flex-sm-grow-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by Name" value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!--<a href="{{ route('admin.plan.create') }}" class="btn btn-info ms-sm-3 mt-2 mt-sm-0">-->
            <!--    <i class="align-middle me-1" data-feather="plus"></i> Add-->
            <!--</a>-->
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Plan</th>
                               <th>Created At</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = ($PlanUser->currentPage() - 1) * $PlanUser->perPage() + 1;
                        @endphp
                        @forelse($PlanUser as $raw)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $raw->name }}</td>
                                <td>{{ $raw->mobile }}</td>
                                <td>{{ $raw->address }}</td>
                              
                                   @if($raw->plan_id == 1)
                                    <td>Basic Plan</td>
                                @elseif($raw->plan_id == 2)
                                    <td>Reader Plan</td>
                                @elseif($raw->plan_id == 3)
                                    <td>Scholar Plan</td>
                                @else
                                    <td>N/A</td>
                                @endif
                                
                              <td>{{ $raw->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No plan found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($PlanUser->isNotEmpty())
                    <div class="d-flex justify-content-left mt-3">
                        {{ $PlanUser->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
