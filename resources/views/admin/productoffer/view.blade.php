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
    .card {
        margin-top: 1rem;
    }
    .form-control {
        background-color: #f8f9fa; /* Light grey for readonly fields */
        border: 1px solid #ced4da;
    }
    .form-control[readonly] {
        cursor: not-allowed;
    }
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .breadcrumb {
            font-size: 0.9rem;
        }
        .card h5 {
            font-size: 1.1rem;
        }
        .form-control {
            font-size: 0.9rem;
        }
    }
</style>

<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.productoffer') }}">Product Offers</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Offer</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">View Product Offer</h1>
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <!-- Offer Title -->
                        <div class="col-md-6 mb-3">
                            <label for="offer_title" class="form-label"><strong>Offer Title:</strong></label>
                            <input type="text" id="offer_title" class="form-control" value="{{ $offer->offer_title }}" readonly>
                        </div>

                        <!-- Product Name -->
                        <div class="col-md-6 mb-3">
                            <label for="product_name" class="form-label"><strong>Product Name:</strong></label>
                            <input type="text" id="product_name" class="form-control" 
                                   value="{{ $offer->product->product_name ?? 'N/A' }}" readonly>
                        </div>

                        <!-- Offer Type -->
                        <div class="col-md-6 mb-3">
                            <label for="offer_type" class="form-label"><strong>Offer Type:</strong></label>
                            <input type="text" id="offer_type" class="form-control" 
                                   value="{{ ucfirst($offer->offer_type) }}" readonly>
                        </div>

                        <!-- Discount Value -->
                        <div class="col-md-6 mb-3">
                            <label for="discount_value" class="form-label"><strong>Discount Value:</strong></label>
                            <input type="text" id="discount_value" class="form-control" 
                                   value="{{ $offer->offer_type === 'percentage' ? $offer->discount_value . '%' : '$' . number_format($offer->discount_value, 2) }}" readonly>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label"><strong>Status:</strong></label>
                            <input type="text" id="status" class="form-control" 
                                   value="{{ ucfirst($offer->status) }}" readonly>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label"><strong>Start Date:</strong></label>
                            <input type="text" id="start_date" class="form-control" 
                                   value="{{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('d M Y') : 'N/A' }}" readonly>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label"><strong>End Date:</strong></label>
                            <input type="text" id="end_date" class="form-control" 
                                   value="{{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('d M Y') : 'N/A' }}" readonly>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label"><strong>Description:</strong></label>
                            <textarea id="description" class="form-control" rows="4" readonly>{{ $offer->description ?? 'N/A' }}</textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                  
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
