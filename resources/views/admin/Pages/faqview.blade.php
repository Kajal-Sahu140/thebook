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
            <li class="breadcrumb-item"><a href="{{ route('admin.faq') }}">FAQs</a></li>
            <li class="breadcrumb-item active" aria-current="page">View FAQ</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">View FAQ</h1>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" name="question" id="question" class="form-control" 
                           value="{{ $faq->question }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="answer" class="form-label">Answer</label>
                    <textarea name="answer" id="answer" rows="4" class="form-control" disabled>{{ $faq->answer }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status_active" value="1" 
                               {{ $faq->status == 'active' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="status_active">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" 
                               {{ $faq->status == '' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="status_inactive">Inactive</label>
                    </div>
                </div>

                <!--  -->
            </div>
        </div>
    </div>
</main>
@endsection
