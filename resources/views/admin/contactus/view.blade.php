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
            border-radius: 10px; /* Optional: adds rounded corners */
            border: 2px solid #ddd; /* Optional: adds a border around the image */
        }
        /* Ensure the breadcrumb is responsive */
        .breadcrumb {
            flex-wrap: wrap; 
            /* Allow items to wrap on small screens */
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

    </style>

    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb float-end"> <!-- Changed class to float-end for Bootstrap 5 -->
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contactus') }}">Contact Us</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show Contact Us</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-10 mx-auto mt-7">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Contact Us Details</h3>
            </div>
            <input type="hidden" name="category_id" value="{{ request()->id }}">        
            <div class="card-body">
                <div class="form-group row">
                    <label for="question_text" class="col-sm-2 col-form-label">User Name <span class="text-danger">*</span></label>
                    <div class="col-sm-10 error-in-group-fields">
                        <input type="text" name="question_text" class="form-control" value="{{ $Contactus->name ?? 'N/A' }}" readonly id="question_text" placeholder="Enter question">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="question_text" class="col-sm-2 col-form-label">Subject <span class="text-danger">*</span></label>
                    <div class="col-sm-10 error-in-group-fields">
                        <input type="text" name="question_text" class="form-control" value="{{ $Contactus->subject ?? 'N/A' }}" readonly id="question_text" placeholder="Enter question">
                    </div>
                </div>
                  <div class="form-group row">
                    <label for="question_text" class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-10 error-in-group-fields">
                        <input type="text" name="question_text" class="form-control" value="{{ $Contactus->email ?? 'N/A' }}" readonly id="question_text" placeholder="Enter question">
                    </div>
                </div>
                    <div class="form-group row">
                    <label for="question_text" class="col-sm-2 col-form-label">Description <span class="text-danger">*</span></label>
                    <div class="col-sm-10 error-in-group-fields">
                        <textarea name="description" class="form-control" id="question_text" placeholder="Enter description" rows="4" readonly>{{ $Contactus->description ?? 'N/A' }}</textarea>
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="question_text" class="col-sm-2 col-form-label">Replay <span class="text-danger">*</span></label>
                    <div class="col-sm-10 error-in-group-fields">
                        @if(!empty($Contactus->replay))
                        <textarea name="description" class="form-control" id="question_text" placeholder="Enter description" rows="4" readonly>{{ $Contactus->replay ?? 'N/A' }}</textarea>
                        @else
                      <form action="{{route('admin.contactus.replyToContactUs',$Contactus->id) }}" method="POST">
                        @csrf
                        <!-- @method('patch') -->
                        <textarea name="replay" class="form-control" id="question_text" placeholder="Enter Reply" rows="4" maxlength="300" required></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Send Reply</button>
                    </form>
                        @endif
                    </div>
                </div>
                
            <div class="card-footer">
              
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>
@endsection
