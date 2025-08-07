@extends('warehouse.master')
@section('content')
<style>
/* Breadcrumb Container */
.breadcrumb {
    background-color: #f8f9fa; /* Light gray background */
    padding: 8px 15px;
    border-radius: 5px;
    margin-bottom: 15px;
}

/* Breadcrumb Links */
.breadcrumb-item a {
    color: #007bff; /* Bootstrap's primary color */
    text-decoration: none;
    font-weight: 500; /* Slightly bold text */
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: #0056b3; /* Darker blue on hover */
}

/* Active Breadcrumb Item */
.breadcrumb-item.active {
    color: #6c757d; /* Bootstrap's secondary color */
    font-weight: bold;
}


</style>
 <div class="col-sm-10" style="margin-left:300px;margin-top:50px">

    <!-- Breadcrumbs Section -->
  <nav aria-label="breadcrumb" class="mb-3">
    <div class="row">
        <div class="col-6 col-md-4 offset-md-8">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('warehouse.category') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page" >{{ $category->name }}</li>
            </ol>
        </div>
    </div>
</nav>
<!-- Breadcrumbs Section -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title" style="text-transform: capitalize;">Subcategory List - {{ $category->name }}</h5>
        </div>
        <div class="card-body">
            @if($categories->isEmpty())
                <div class="alert alert-warning">
                    No subcategories available for this category.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Subcategory Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $subcategory)
                                
                                <tr>
                                    <td>{{ $categories->firstItem() + $index }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td><img src="{{ $subcategory->image }}" height="50px" /></td>
                                    <td>{{ Str::limit($subcategory->description, 30) ?? '' }}</td>
                                    <td>
                                        <span class="badge {{ $subcategory->status === 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $subcategory->status === 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('warehouse.category.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <!-- <form action="" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?')">Delete</button>
                                        </form> -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Controls -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                    </div>
                    <div>
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
