@extends('warehouse.master')
@section('content')

 <div class="col-sm-10" style="margin-left:300px;margin-top:50px">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Categories</h1>
        <a href="{{ route('warehouse.category.create') }}" class="btn btn-primary">Add New Category</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Category List</h5>
        </div>
        <div class="card-body">
            @if($categories->isEmpty())
                <div class="alert alert-warning">
                    No categories available for this warehouse.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ $categories->firstItem() + $index }}</td> <!-- Updated for pagination -->
                                    <td>{{ $category->name }}</td>
                                    <td><img src="{{ $category->image }}" height="50px" /></td>
                                    <td>{{ Str::limit($category->description, 30) ?? '' }}</td>
                                    <td>
                                        <span class="badge {{ $category->status === 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $category->status === 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                    <a href="{{ route('warehouse.category.subcategory', $category->id) }}" class="btn btn-sm btn-info">Subcategory</a>    
                                    <a href="{{ route('warehouse.category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <!-- <form action="" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
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
                        {{ $categories->links('pagination::bootstrap-5') }} <!-- Bootstrap pagination links -->
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
