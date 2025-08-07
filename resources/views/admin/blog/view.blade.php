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
            <li class="breadcrumb-item"><a href="{{ route('admin.blog') }}">Blogs</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Blog</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">View Blog</h1>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" class="form-control" value="{{ $blog->author }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" value="{{ $blog->title }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea rows="4" class="form-control" disabled>{{ $blog->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Blog Image</label>
                    <div>
                        <img src="{{$blog->image }}" alt="Blog Image" class="img-fluid" style="max-height: 200px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control" value="{{ $blog->status == 'active' ? 'Active' : 'Inactive' }}" disabled>
                </div>

               
            </div>
        </div>
    </div>
</main>
@endsection
