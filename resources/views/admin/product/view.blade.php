@extends('admin.master')
@section('content')
    <style>
        /* Card and form styling */
        .card {
            margin: 20px;
        }
        /* Form controls are full-width on small screens */
        @media (max-width: 768px) {
            .form-control {
                width: 100%;
            }
        }
        /* Breadcrumb styling */
        .breadcrumb {
            background-color: #e9eef2;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
        }
        .breadcrumb li a {
            text-decoration: none;
        }
        /* Image styling for product images */
        .product-image {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .product-image-container {
        width: 100%;
        height: 200px; /* You can adjust the height as needed */
        overflow: hidden;
        border-radius: 5px; /* Optional: to give rounded corners */
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures the image covers the area without distortion */
    }
    </style>
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Products List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product Details</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-10 mx-auto mt-7">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Product Details</h3>
            </div>
            <form class="form-horizontal">
                @csrf
                <div class="card-body">
                    <!-- Product Name -->
                    <div class="form-group row">
                        <label for="productName" class="col-sm-3 col-form-label">Product Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" readonly id="productName">
                        </div>
                    </div>
                    <!-- Product Description -->
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" readonly id="description">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <!-- Product Base Price -->
                    <div class="form-group row">
                        <label for="basePrice" class="col-sm-3 col-form-label">Base Price</label>
                        <div class="col-sm-9">
                            <input type="text" name="base_price" class="form-control" value="{{ $product->base_price}} IQD" readonly id="basePrice">
                        </div>
                    </div>
                    <!-- Product Brand -->
                    <div class="form-group row">
                        <label for="brandId" class="col-sm-3 col-form-label">Brand</label>
                        <div class="col-sm-9">
                            <input type="text" name="brand_id" class="form-control" value="{{ $product->brand->name ?? 'N/A' }}" readonly id="brandId">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brandId" class="col-sm-3 col-form-label">Discount</label>
                        <div class="col-sm-9">
                            <input type="text" name="brand_id" class="form-control" value="{{ $product->discount ?? 'N/A' }}" readonly id="brandId">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label for="brandId" class="col-sm-3 col-form-label">Quantity</label>
                        <div class="col-sm-9">
                            <input type="text" name="brand_id" class="form-control" value="{{ $product->quantity ?? 'N/A' }}" readonly id="brandId">
                        </div>
                    </div>
                    <!-- Product Images -->
                    <div class="form-group row mt-3">
    <label for="productImages" class="col-sm-3 col-form-label">Product Images</label>
    <div class="col-sm-9">
        @if($productImages && $productImages->count() > 0)
            <div class="row">
                @foreach($productImages as $image)
                    <div class="col-4 col-md-3 col-lg-2 mb-3">
                        <div class="product-image-container">
                            <img src="{{$image->image_url}}" alt="Product Image" class="img-fluid product-image">
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No images available</p>
        @endif
    </div>
</div>
<!-- Product Variants -->
                    <div class="form-group row">
                        <label for="productVariants" class="col-sm-3 col-form-label">Product Variants</label>
                        <div class="col-sm-9">
    @if($productVariants && $productVariants->count() > 0)
        <div class="row">
            @foreach($productVariants as $variant)
                <div class="col-12 col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Variant</h5>
                            <p><strong>Color:</strong> {{ $variant->color_name }}</p>
                            <p><strong>Size:</strong> {{ $variant->size_name }}</p>
                            <p><strong>Price:</strong> {{ number_format($variant->price, 2) }} IQD</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No variants available</p>
    @endif
</div>
 </div>
   <!-- Created At and Updated At -->
                    <div class="form-group row">
                        <label for="createdAt" class="col-sm-3 col-form-label">Created At</label>
                        <div class="col-sm-9">
                            <input type="text" name="created_at" class="form-control" value="{{ $product->created_at->format('Y-m-d H:i:s') }}" readonly id="createdAt">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updatedAt" class="col-sm-3 col-form-label">Updated At</label>
                        <div class="col-sm-9">
                            <input type="text" name="updated_at" class="form-control" value="{{ $product->updated_at->format('Y-m-d H:i:s') }}" readonly id="updatedAt">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="updatedAt" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <input type="text" name="status" class="form-control" value="{{ $product->status === 1 ? 'Active' : 'Inactive' }}" readonly id="status">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Optional: Include buttons for further actions if needed -->
                </div>
            </form>
        </div>
    </div>
@endsection
