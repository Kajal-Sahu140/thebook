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
            <li class="breadcrumb-item active" aria-current="page">Edit FAQ</li>
        </ol>
    </nav>
</div>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit FAQ</h1>
        <div class="card">
            <div class="card-body">
                <form id="editFaqForm" action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror" 
                               value="{{ old('question', $faq->question) }}" placeholder="Enter the FAQ question">
                        @error('question')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="question_ar" class="form-label">Question (AR)</label>
                        <input type="text" name="question_ar" id="question_ar" class="form-control @error('question') is-invalid @enderror" 
                               value="{{ old('question_ar', $faq->question_ar) }}" placeholder="Enter the FAQ question">
                        @error('question_ar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="question_cku" class="form-label">Question (CKU)</label>
                        <input type="text" name="question_cku" id="question_cku" class="form-control @error('question') is-invalid @enderror" 
                               value="{{ old('question_cku', $faq->question_cku) }}" placeholder="Enter the FAQ question">
                        @error('question_cku')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea name="answer" id="answer" rows="4" class="form-control @error('answer') is-invalid @enderror" 
                                  placeholder="Enter the FAQ answer">{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                        <div class="mb-3">
                        <label for="answer_ar" class="form-label">Answer (AR)</label>
                        <textarea name="answer_ar" id="answer_ar" rows="4" class="form-control @error('answer_ar') is-invalid @enderror" 
                                  placeholder="Enter the FAQ answer">{{ old('answer_ar', $faq->answer_ar) }}</textarea>
                        @error('answer_ar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                      <div class="mb-3">
                        <label for="answer_cku" class="form-label">Answer (CKU)</label>
                        <textarea name="answer_cku" id="answer_cku" rows="4" class="form-control @error('answer_cku') is-invalid @enderror" 
                                  placeholder="Enter the FAQ answer">{{ old('answer_cku', $faq->answer_cku) }}</textarea>
                        @error('answer_cku')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" 
                               value="{{ old('category', $faq->category) }}" placeholder="Enter the FAQ category">
                        @error('category')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div> -->

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" 
                                   {{ old('status', $faq->status) == 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" 
                                   {{ old('status', $faq->status) == 'inactive' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">Inactive</label>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
<!-- Validation Script -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(function () {
        $("#editFaqForm").validate({
            rules: {
                question: {
                    required: true,
                    maxlength: 255,
                },
                question_ar: {
                    required: true,
                    maxlength: 255,
                },
                answer_ar: {
                    required: true,
                    maxlength: 1000,
                },
                question_cku: {
                    required: true,
                    maxlength: 255,
                },
                answer_cku: {
                    required: true,
                    maxlength: 1000,
                },

                answer: {
                    required: true,
                    maxlength: 1000,
                },
                category: {
                    required: true,
                    maxlength: 255,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                question: {
                    required: "Please enter the FAQ question.",
                    maxlength: "Question can't exceed 255 characters.",
                },
                question_ar: {
                    required: "Please enter the FAQ question (AR).",
                    maxlength: "Question can't exceed 255 characters.",
                },
                question_cku: {
                    required: "Please enter the FAQ question (CKU).",
                    maxlength: "Question can't exceed 255 characters.", 
                    },
                answer: {
                    required: "Please provide an answer.",
                    maxlength: "Answer can't exceed 1000 characters.",
                },
                answer_ar: {
                    required: "Please provide an answer (AR).",
                    maxlength: "Answer can't exceed 1000 characters.",
                },
                answer_cku: {
                    required: "Please provide an answer (CKU).",
                    maxlength: "Answer can't exceed 1000 characters.",
                },
                category: {
                    required: "Please provide a category for the FAQ.",
                    maxlength: "Category can't exceed 255 characters.",
                },
                status: {
                    required: "Please select the status.",
                }
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
