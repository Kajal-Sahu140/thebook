@extends('admin.master')
@section('content')
<style>
    /* Image container styles */
    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 200px;
        height: 200px;
        margin: 0 auto;
    }
    .profile-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ddd;
    }
    /* Responsive form styling */
    .form-group {
        margin-bottom: 15px;
    }
    @media (max-width: 768px) {
        .profile-image {
            max-width: 150px;
            max-height: 150px;
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
            <li class="breadcrumb-item active" aria-current="page">Edit Users</li>
        </ol>
    </nav>
</div>
<div class="col-md-10 mx-auto mt-6">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <form id="editUserForm" action="{{ route('admin.users.addwallet', $wallet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="wallet">User wallet</label>
                    <input type="text" name="wallet" class="form-control" id="wallet" value="{{ old('wallet', $wallet->wallet) }}" >
                @error('wallet')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
                </div>
                <!-- Phone -->
              
             
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
