@extends('admin.master')

@section('content')
    <style>
        /* Responsive image container */
        .image-container {
            display: flex;
            justify-content: center; /* Centers horizontally */
            align-items: center; /* Centers vertically */
            width: 100%; /* Allows the container to adjust width */
            max-width: 200px; /* Maximum width for the image container */
            height: 200px;
            margin: 0 auto; /* Center container in its parent */
        }

        .profile-image {
            width: 100%; /* Makes image responsive */
            height: auto; /* Maintains aspect ratio */
            object-fit: cover; /* Ensures the image covers the area without distortion */
            border-radius: 50%; /* Makes the image circular */
            border: 2px solid #ddd; /* Optional: adds a border around the image */
        }

        /* Ensure the breadcrumb is responsive */
        .breadcrumb {
            flex-wrap: wrap; /* Allow items to wrap on small screens */
        }

        /* Style for the card */
        .card {
            margin: 20px; /* Adds margin for better spacing */
        }

        /* Make form inputs full-width on small screens */
        @media (max-width: 768px) {
            .form-control {
                width: 100%; /* Full width on small screens */
            }
        }

        .breadcrumb {
            background-color: #e9eef2; /* Light gray background similar to bg-body-tertiary */
            margin-bottom: 1rem; /* Space below the breadcrumb */
            padding: 0.75rem 1rem; /* Add some padding for better spacing */
            border-radius: 0.25rem; /* Optional: adds rounded corners */
        }

        .breadcrumb li a {
            text-decoration: none;
        }

        .star-rating {
            color: #f39c12; /* Golden color for stars */
            font-size: 20px;
        }
        /* Ensure full width and dynamic height for textarea */
textarea.form-control {
    width: 100%; /* Make it responsive to the container width */
    min-height: 100px; /* Set minimum height */
    max-height: 300px; /* Set a maximum height to avoid excessive growth */
    resize: vertical; /* Allow users to resize vertically */
}

/* Make text area more responsive on smaller screens */
@media (max-width: 768px) {
    textarea.form-control {
        font-size: 0.9rem; /* Adjust font size */
        padding: 0.75rem; /* Adjust padding for smaller screens */
    }
}

/* Adjust textarea styling for larger screens */
@media (min-width: 769px) {
    textarea.form-control {
        font-size: 1rem; /* Larger font size for larger screens */
    }
}
    </style>

    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rating') }}">Product Ratings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show Rating</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-10 mx-auto mt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Product Rating Details</h3>
            </div>

            <form class="form-horizontal" action=" " method="post" id="viewProductRating">
                @method('patch')
                @csrf
                <input type="hidden" name="rating_id" value="{{ request()->id }}">
                <div class="card-body">
                    <!-- Product Image -->
                    <div class="form-group row">
                        <div class="col-sm-12 image-container">
                            @if($rating->product && $rating->product->images)
                                <img src="{{ url($rating->product->images->first()->image_url) }}" class="profile-image" alt="Product Image"/>
                            @else
                                <img src="https://via.placeholder.com/150" class="profile-image" alt="Default Product Image"/>
                            @endif
                        </div>
                    </div>

                    <!-- Product Name -->
                    <div class="form-group row">
                        <label for="productName" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="product_name" class="form-control" value="{{ $rating->product->product_name ?? 'User' }}" readonly id="productName" placeholder="Product name">
                        </div>
                    </div>

                    <!-- User Name -->
                    <div class="form-group row">
                        <label for="userName" class="col-sm-2 col-form-label">User Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="user_name" class="form-control" value="{{ $rating->user->name ?? 'User' }}" readonly id="userName" placeholder="User name">
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="form-group row">
                        <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                        <div class="col-sm-10">
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= $rating->rating ? 'fa-star' : 'fa-star-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Review -->
                   <div class="form-group row">
    <label for="review" class="col-sm-2 col-form-label">Review</label>
    <div class="col-sm-10">
        <textarea name="review" class="form-control" readonly>{{ $rating->review ?? 'No review' }}</textarea>
    </div>
</div>

</div>
                    <!-- Status -->
                    

                <div class="card-footer">
                    <!-- Optional footer buttons can be added here -->
                </div>
            </form>
        </div>
    </div>
@endsection
