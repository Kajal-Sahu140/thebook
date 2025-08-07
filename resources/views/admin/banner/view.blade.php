@extends('admin.master')
@section('content')
    <style>
        /* Centered image container with responsive design */
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 200px;
            height: 200px;
            margin: 10px auto;
        }

        .profile-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ddd;
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            background-color: #e9eef2;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            flex-wrap: wrap;
        }

        .breadcrumb li a {
            text-decoration: none;
        }

        /* Card and Form Spacing */
        .card {
            margin: 20px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        /* Input Responsiveness */
        .form-control {
            width: 100%;
        }

        /* Responsive Design for Mobile Screens */
        @media (max-width: 768px) {
            .image-container {
                max-width: 150px;
                height: 150px;
            }
        }
    </style>

    <div class="col-sm-12">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.banner') }}">Banner</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show Banner</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-10 mx-auto mt-7">
        <!-- Banner Details Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Banner Details</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal">
                    @csrf
                    <!-- Hidden Banner ID -->
                    <input type="hidden" name="banner_id" value="{{ request()->id }}">

                    <!-- Banner Image Section -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-center flex-wrap">
                                <!-- Web Banner Image -->
                                @if($banner && $banner->web_banner_image)
                                    <div class="image-container">
                                        <img src="{{ $banner->web_banner_image }}" class="profile-image" alt="Web Banner Image"/>
                                        <!-- <p class="text-center mt-2">Web Banner Image</p> -->
                                    </div>
                                @endif

                                <!-- App Banner Image -->
                                @if($banner && $banner->app_banner_image)
                                    <div class="image-container">
                                        <img src="{{ $banner->app_banner_image }}" class="profile-image" alt="App Banner Image"/>
                                        <!-- <p class="text-center mt-10">App Banner Image</p> -->
                                    </div>
                                @endif

                                <!-- Fallback for Missing Images -->
                                @if(!$banner || (!$banner->web_banner_image && !$banner->app_banner_image))
                                    <p class="text-center">No banner images available.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Banner Title -->
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" value="{{ $banner->title ?? 'N/A' }}" readonly id="title">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" readonly id="description">{{ $banner->description ?? 'N/A' }}</textarea>
                        </div>
                    </div>

                    <!-- Discount -->
                    <div class="form-group row">
                        <label for="discount" class="col-sm-2 col-form-label">Discount</label>
                        <div class="col-sm-10">
                            <input type="text" name="discount" class="form-control" value="Flat {{ $banner->discount ?? 'N/A' }}% OFF" readonly id="discount">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input type="text" name="status" class="form-control" value="{{ ucfirst($banner->status ?? 'N/A') }}" readonly id="status">
                        </div>
                    </div>

                    <!-- Position -->
                    <div class="form-group row">
                        <label for="position" class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-10">
                            <input type="text" name="position" class="form-control" value="{{ ucfirst($banner->position ?? 'N/A') }}" readonly id="position">
                        </div>
                    </div>

                    <!-- Start Date -->
                    <div class="form-group row">
                        <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="start_date" class="form-control" value="{{ $banner->start_date ?? 'N/A' }}" readonly id="start_date">
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="form-group row">
                        <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-10">
                            <input type="text" name="end_date" class="form-control" value="{{ $banner->end_date ?? 'N/A' }}" readonly id="end_date">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
