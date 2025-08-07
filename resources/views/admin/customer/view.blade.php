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
.breadcrumb li a{
    text-decoration:none;
}
    </style>
    <div class="col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb float-end"> <!-- Changed class to float-end for Bootstrap 5 -->
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show Users</li>
        </ol>
    </nav>
</div>
    <div class="col-md-10 mx-auto mt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">User Details</h3>
            </div>
            <form class="form-horizontal" action=" " method="post" id="editCategory" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="category_id" value="{{ request()->id }}">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-12 image-container error-in-group-fields">
                         @if($user->profile && $user->profile->image)
    <img src="{{ url('storage/' . $user->profile->image) }}" class="profile-image" alt="User Profile Image"/>
@else
    <img src="https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg" class="profile-image" alt="Default Profile Image"/>
@endif
  </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">User Name</label>
                        <div class="col-sm-10 error-in-group-fields">
                            <input type="text" name="first_name" class="form-control"
                                value="{{ $user->name  ?? 'N/A' }}" readonly id="username"
                                placeholder="Enter user name">
                        </div>
                    </div>
                    <div class="form-group row">
    <label for="username" class="col-sm-2 col-form-label">Phone</label>
    <div class="col-sm-10 error-in-group-fields">
        <input type="text" name="first_name" class="form-control"
            value="{{ ($user->country_code && $user->phone) ? $user->country_code . '-' . $user->phone : 'N/A' }}" 
            readonly id="username"
            placeholder="Enter user name">
    </div>
</div>

                    <div class="form-group row">
    <label for="username" class="col-sm-2 col-form-label">Whatsapp</label>
    <div class="col-sm-10 error-in-group-fields">
        <input type="text" name="first_name" class="form-control"
            value="{{ ($user->whatsapp_country_code && $user->whatsapp) ? $user->whatsapp_country_code . '-' . $user->whatsapp : 'N/A' }}"
            readonly id="username"
            placeholder="Enter user name">
    </div>
</div>

                    @if (isset($user->email))
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10 error-in-group-fields">
                                <input type="text" name="email" class="form-control" value="{{ $user->email  ?? 'N/A' }}"
                                    readonly id="email" placeholder="Enter email">
                            </div>
                        </div>
                    @endif
                   <div class="form-group row">
                        <label for="firstName" class="col-sm-2 col-form-label">created at</label>
                        <div class="col-sm-10 error-in-group-fields">
                            <input type="text" name="first_name" class="form-control"
                                value="{{ $user->created_at->format('Y-m-d') }}" readonly id="firstName"
                                placeholder="Enter first name">
                        </div>
                    </div>
                    <!--  <div class="form-group row">
                        <label for="lastName" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10 error-in-group-fields">
                            <input type="text" name="last_name" class="form-control"
                                value="{{ $user->profile->last_name ?? 'N/A' }}" readonly id="lastName"
                                placeholder="Enter last name">
                        </div>
                    </div>
                   <div class="form-group row">
                        <label for="lastName" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10 error-in-group-fields">
                            <input type="text" name="last_name" class="form-control"
                                value="{{ $user->profile->address ?? 'N/A' }}" readonly id="lastName"
                                placeholder="Enter last name">
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10 error-in-group-fields">
                            <?php $status = ucfirst($user->status); ?>
                            <input type="text" name="status" class="form-control capitalize-first" readonly
                                value="{{ $status }}" id="status">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <!-- <button type="submit" class="btn btn-success">Submit</button> -->
                    </div>
                    <!-- /.card-footer -->
            </form>
        </div>
    </div>
@endsection
