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
</style>

<div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.rating') }}">Product Ratings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Product Rating</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Product Rating</h1>
        <div class="card">
            <div class="card-body">
                <form id="editProductRatingForm" action="{{ route('admin.rating.update', $rating->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Specify PATCH request for updating -->

                    <!-- Rating Field -->
                     <div class="mb-3">
                        <label for="rating" class="form-label">User Name</label>
                        <input type="text"  id="rating" class="form-control" 
                            value="{{ old('rating', $rating->user->name ?? 'User') }}" placeholder="Enter User Name" readonly>
                        
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Product Name</label>
                        <input type="text"  id="rating" class="form-control" 
                            value="{{ old('rating', $rating->product->product_name) }}" placeholder="Enter User Name" readonly>
                        
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <input type="number" name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" 
                            value="{{ old('rating', $rating->rating) }}" placeholder="Enter Rating (1-5)" min="1" max="5">
                        @error('rating')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Review Field -->
                    <div class="mb-3">
                        <label for="review" class="form-label">Review</label>
                        <textarea name="review" id="review" rows="4" class="form-control @error('review') is-invalid @enderror" 
                            placeholder="Enter a brief review about the product" required>{{ old('review', $rating->review) }}</textarea>
                        @error('review')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Product Image Field -->
                   

                    <!-- Status Field -->
                    

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Rating</button>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Preview Image Script -->
<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
    }
</script>

<!-- Validation Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
$('#editProductRatingForm').submit(function(event) {
    // Trim leading and trailing spaces from the review field
    var reviewField = $('#review');
    reviewField.val(reviewField.val().trim());
    
    // Ensure the field is not empty or just spaces after trimming
    if (reviewField.val() === '') {
        event.preventDefault();
        // alert("Review cannot be empty or just spaces.");
        return false; // Prevent form submission if empty after trimming
    }
    
    // Proceed with form submission if the review is valid
});


    $(function () {
        $("#editProductRatingForm").validate({
                rules: {
                    rating: {
                        required: true,
                        min: 1,
                        max: 5,
                    },
                    review: {
                        required: true,
                        maxlength: 500,
                        notspace: true
                    },
                    image: {
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    rating: {
                        required: "Please enter the product rating.",
                        min: "Rating should be between 1 and 5.",
                        max: "Rating should be between 1 and 5.",
                    },
                    review: {
                        required: "Please provide a review.",
                        maxlength: "Review can't exceed 500 characters.",
                        notspace: "Review should not contain spaces."
                    },
                    image: {
                        extension: "Only JPG, JPEG, and PNG formats are allowed.",
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.mb-3').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection

