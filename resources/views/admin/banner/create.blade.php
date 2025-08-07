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
            <li class="breadcrumb-item"><a href="{{ route('admin.banner') }}">Banner</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
        </ol>
    </nav>
</div>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Banner</h1>
        <div class="card">
            <div class="card-body">
                <form id="addBannerForm" action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Banner Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Banner Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                            placeholder="Enter Your Title" value="{{ old('title') }}">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                            rows="4" placeholder="Enter Your Description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                   <div class="mb-3">
                        <label for="banner_link" class="form-label">Banner Link</label>
                        <input type="text" name="banner_link"id="banner_link"class="form-control @error('banner_link') is-invalid @enderror"placeholder="Enter your banner link"value="{{ old('banner_link') }}" >
                        @error('banner_link')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                        <div class="mb-3">
                        <label for="category" class="form-label">Click Status</label>
                        <select name="click_status" id="click_status" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Select a click status --</option>
                            <option value="yes" {{ old('click_status') == 'yes' ? 'selected' : '' }}>yes</option>
                            <option value="no" {{ old('click_status') == 'no' ? 'selected' : '' }}>no</option>
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category_id" id="category" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Select a Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Web Banner Image -->
                    <div class="mb-3">
    <label for="web_banner_image" class="form-label">Web Banner Image</label>
    <input type="file" name="web_banner_image" id="web_banner_image" class="form-control @error('web_banner_image') is-invalid @enderror" 
        onchange="previewMedia(event, 'web')" accept="image/*,video/*" 
        @if(old('web_banner_image')) value="{{ old('web_banner_image') }}" @endif>
    @error('web_banner_image')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    <div id="webPreview" class="media-preview mt-3"></div>
</div>

<!-- App Banner Image -->
<div class="mb-3">
    <label for="app_banner_image" class="form-label">App Banner Image</label>
    <input type="file" name="app_banner_image" id="app_banner_image" class="form-control @error('app_banner_image') is-invalid @enderror" 
        onchange="previewMedia(event, 'app')" accept="image/*,video/*" 
        @if(old('app_banner_image')) value="{{ old('app_banner_image') }}" @endif>
    @error('app_banner_image')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    <div id="appPreview" class="media-preview mt-3"></div>
</div>


                    <!-- Position -->
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <select name="position" id="position" class="form-control @error('position') is-invalid @enderror">
                            <option value="homepage" {{ old('position') == 'homepage' ? 'selected' : '' }}>Homepage</option>
                            <!-- <option value="sidebar" {{ old('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                            <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Footer</option> -->
                        </select>
                        @error('position')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Discount -->
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control @error('discount') is-invalid @enderror" 
                            placeholder="Enter Discount" step="1" min="0" value="{{ old('discount') }}">
                        @error('discount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" 
                                {{ old('status') === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="de-active" 
                                {{ old('status') === 'de-active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">De-active</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Start Date -->
                   <div class="mb-3">
    <label for="start_date" class="form-label">Start Date</label>
    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" 
        value="{{ old('start_date') }}" min="{{ now()->toDateString() }}">
    @error('start_date')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="end_date" class="form-label">End Date</label>
    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" 
        value="{{ old('end_date') }}" min="{{ now()->toDateString() }}">
    @error('end_date')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>


                    <button type="submit" class="btn btn-primary">Add Banner</button>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let today = new Date().toISOString().split('T')[0];

        // Set minimum date for start date (today)
        document.getElementById("start_date").setAttribute("min", today);

        document.getElementById("start_date").addEventListener("change", function() {
            let startDate = this.value;
            document.getElementById("end_date").setAttribute("min", startDate);
        });

        // Ensure end date can't be before start date
        document.getElementById("end_date").addEventListener("change", function() {
            let startDate = document.getElementById("start_date").value;
            if (this.value < startDate) {
                alert("End date cannot be earlier than start date.");
                this.value = startDate;
            }
        });
    });
</script>

<script>
    function previewMedia(event, type) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById(`${type}Preview`);
        previewContainer.innerHTML = '';

        if (file) {
            const fileType = file.type.split('/')[0];
            const url = URL.createObjectURL(file);

            if (fileType === 'image') {
                previewContainer.innerHTML = `<img src="${url}" alt="Preview Image" style="max-height: 150px;">`;
            } else if (fileType === 'video') {
                previewContainer.innerHTML = `<video controls style="max-height: 150px;"><source src="${url}" type="${file.type}"></video>`;
            }
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        // Custom method to validate image file extensions
        $.validator.addMethod("validImage", function(value, element) {
            if (element.files.length === 0) {
                return false;
            }
            var fileExtension = value.split('.').pop().toLowerCase();
            return ["jpg", "jpeg", "png", "gif", "mp4", "avi", "mov"].includes(fileExtension);
        }, "Only JPG, JPEG, PNG, GIF, MP4, AVI, MOV files are allowed.");

        $("#addBannerForm").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 50,
                },
                description: {
                    required: true,
                    maxlength: 1000,
                },
                banner_link: {
                    required: true,
                    url: true
                },
                category_id: {
                    required: true,
                },
                web_banner_image: {
                    required: true,
                    validImage: true,
                },
                app_banner_image: {
                    required: true,
                    validImage: true,
                },
                position: {
                    required: true,
                },
                discount: {
                    required: true,
                    number: true,
                    min: 0,
                },
                status: {
                    required: true,
                },
                start_date: {
                    required: true,
                    date: true,
                },
                end_date: {
                    required: true,
                    date: true,
                    greaterThan: "#start_date",
                }
            },
            messages: {
                title: {
                    required: "Please enter the banner title.",
                    maxlength: "Title can't exceed 50 characters.",
                },
                description: {
                    required: "Please enter a description.",
                    maxlength: "Description can't exceed 1000 characters.",
                },
                banner_link: {
                    required: "Please enter a banner link.",
                    url: "Please enter a valid URL.",
                },
                category_id: {
                    required: "Please select a category.",
                },
                web_banner_image: {
                    required: "Please upload a web banner image.",
                },
                app_banner_image: {
                    required: "Please upload an app banner image.",
                },
                position: {
                    required: "Please select a position.",
                },
                discount: {
                    required: "Please enter a discount value.",
                    number: "Please enter a valid number.",
                    min: "Discount cannot be negative.",
                },
                status: {
                    required: "Please select a status.",
                },
                start_date: {
                    required: "Please select a start date.",
                    date: "Please enter a valid date.",
                },
                end_date: {
                    required: "Please select an end date.",
                    date: "Please enter a valid date.",
                    greaterThan: "End date must be after the start date.",
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Custom rule to validate that end date is greater than start date
        $.validator.addMethod("greaterThan", function(value, element, param) {
            var startDate = $(param).val();
            return !startDate || new Date(value) > new Date(startDate);
        }, "End date must be after start date.");

        // Image preview function
        function previewMedia(event, type) {
            var file = event.target.files[0];
            if (file) {
                var previewContainer = type === 'web' ? '#webPreview' : '#appPreview';
                var previewElement;
                
                if (file.type.startsWith('image/')) {
                    previewElement = `<img src="${URL.createObjectURL(file)}" class="img-thumbnail" width="150" />`;
                } else if (file.type.startsWith('video/')) {
                    previewElement = `<video width="150" controls><source src="${URL.createObjectURL(file)}" type="${file.type}"></video>`;
                } else {
                    previewElement = `<p>Unsupported file format</p>`;
                }
                $(previewContainer).html(previewElement);
            }
        }

        // Attach event to input fields
        $("#web_banner_image").change(function(event) {
            previewMedia(event, 'web');
        });

        $("#app_banner_image").change(function(event) {
            previewMedia(event, 'app');
        });
    });
</script>

@endsection
