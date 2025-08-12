@extends('admin.master')

@section('content')
<div class="container">
    <h2>Create Template</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="ckeditor" class="form-control" rows="6" placeholder="Write your long text..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Template</button>
    </form>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
