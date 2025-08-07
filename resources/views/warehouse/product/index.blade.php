@extends('warehouse.master')
@section('content')
<style>
.button_td_action {
    gap: 10px;
}
.product-image {
    transition: transform 0.3s ease-in-out;
    cursor: zoom-in;
}
.product-image:hover {
    transform: scale(2);
}
.badge-lg {
    font-size: 14px;
    padding: 8px 15px;
    font-weight: bold;
    border-radius: 5px;
}
</style>
<div class="content-body">
 <div class="container-fluid mt-3">
    <!-- Breadcrumb -->
    <div aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">Inventory Management</li>
        </ol>
    </div>
    <h1 class="h3 mb-4">Inventory Management</h1>
    <!-- Search and Add Product Buttons -->
    <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
        <form action="{{ route('warehouse.product') }}" method="GET" class="d-flex flex-grow-1 flex-md-grow-0">
            <input type="text" name="search" class="form-control me-3" placeholder="Search by Product Name" value="{{ request()->input('search') }}" maxlength="50">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <a href="{{ route('warehouse.product.create') }}" class="btn btn-info ms-md-3 mt-3 mt-md-0">
            <i class="align-middle me-1" data-feather="plus"></i> Add Product
        </a>
        <button type="button" class="btn btn-info ms-md-3 mt-3 mt-md-0" onclick="location.href='{{ route('warehouse.product') }}'">Reset</button>
    </div>
    <!-- Products Table -->
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
                            <td>
                                {{ Str::limit($product->description, 50) }}
                                @if(strlen($product->description) > 50)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#descModal-{{ $product->product_id }}">View More</a>
                                @endif
                            </td>
                            <!-- Bootstrap Modal for Description -->
                            <div class="modal fade" id="descModal-{{ $product->product_id }}" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Product Description</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $product->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <td>
                                @if(!empty($productImages[$product->product_id]->image_url))
                                    <img src="{{ $productImages[$product->product_id]->image_url }}" height="50px" alt="Product Image" 
                                         class="zoomable-image" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $product->id }}" 
                                         onclick="showImage('{{ $productImages[$product->product_id]->image_url }}', '{{ $product->id }}')">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <!-- Bootstrap Modal for Image Zoom -->
                            <div class="modal fade" id="imageModal-{{ $product->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Product Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">*</button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalImage-{{ $product->id }}" src="{{ $productImages[$product->product_id]->image_url }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <td>{{ $product->base_price }} IQD</td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $product->status === 1 ? 'bg-success' : 'bg-danger' }} badge-lg">
                                    {{ $product->status === 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2 button_td_action">
                                    <a href="{{ route('warehouse.product.view', base64_encode($product->product_id)) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('warehouse.product.edit', base64_encode($product->product_id)) }}" class="btn btn-warning btn-sm">Edit</a>
                                </div>
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
                <div class="d-flex justify-content-center mt-3">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
 </div>
</div>
<!-- JavaScript for Image Zoom -->
<script>
    function showImage(imgSrc, productId) {
        document.getElementById("modalImage-" + productId).src = imgSrc;
    }
</script>

<!-- JQuery and SweetAlert2 for delete confirmation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
