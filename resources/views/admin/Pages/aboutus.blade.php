@extends('admin.master')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3">Edit Page</h1>
    <form action="{{ route('admin.pages.update', $page->slug) }}" method="POST" id="editPageForm">
        @csrf
        @method('PUT') <!-- Change this to PUT -->
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title"placeholder="Enter the title of the page" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
        @error('title')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        </div>
         <div class="form-group">
            <label for="title_ar">Title (AR)</label>
            <input type="text" name="title_ar" id="title_ar"placeholder="Enter the title of the page" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $page->title_ar) }}" required>
            @error('title_ar')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
         <div class="form-group">
            <label for="title_cku">Title (CKU)</label>
            <input type="text" name="title_cku" id="title_cku"placeholder="Enter the title of the page" class="form-control @error('title_cku') is-invalid @enderror" value="{{ old('title_cku', $page->title_cku) }}" required>
            @error('title_cku')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug"placeholder="Enter the slug of the page"  class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $page->slug) }}" readonly>
        </div>
       <div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" placeholder="Provide a detailed description of the page" class="form-control @error('description') is-invalid @enderror" rows="10" required>{{ old('description', $page->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="description_ar">Description (AR)</label>
    <textarea name="description_ar" id="description_ar" placeholder="Provide a detailed description of the page" class="form-control @error('description_ar') is-invalid @enderror" rows="10" required>{{ old('description_ar', $page->description_ar ?? '') }}</textarea>
    @error('description_ar')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="description_cku">Description (CKU)</label>
    <textarea name="description_cku" id="description_cku" placeholder="Provide a detailed description of the page" class="form-control @error('description_cku') is-invalid @enderror" rows="10" required>{{ old('description_cku', $page->description_cku ?? '') }}</textarea>
    @error('description_cku')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        height: 300,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
            { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ],
        on: {
            instanceReady: function(evt) {
                var editor = evt.editor;
                var placeholderText = 'Provide a detailed description of the page';
                var wysiwygarea = editor.ui.space('contents').$;

                if (!editor.getData()) {
                    wysiwygarea.classList.add('placeholder');
                    editor.setData('<p>' + placeholderText + '</p>');
                }

                editor.on('focus', function() {
                    if (editor.getData().trim() === '<p>' + placeholderText + '</p>') {
                        editor.setData('');
                        wysiwygarea.classList.remove('placeholder');
                    }
                });

                editor.on('blur', function() {
                    if (!editor.getData()) {
                        wysiwygarea.classList.add('placeholder');
                        editor.setData('<p>' + placeholderText + '</p>');
                    }
                });
            }
        }
    });
    CKEDITOR.replace('description_ar', {
        height: 300,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
            { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ],
        on: {
            instanceReady: function(evt) {
                var editor = evt.editor;
                var placeholderText = 'Provide a detailed description of the page';
                var wysiwygarea = editor.ui.space('contents').$;

                if (!editor.getData()) {
                    wysiwygarea.classList.add('placeholder');
                    editor.setData('<p>' + placeholderText + '</p>');
                }

                editor.on('focus', function() {
                    if (editor.getData().trim() === '<p>' + placeholderText + '</p>') {
                        editor.setData('');
                        wysiwygarea.classList.remove('placeholder');
                    }
                });

                editor.on('blur', function() {
                    if (!editor.getData()) {
                        wysiwygarea.classList.add('placeholder');
                        editor.setData('<p>' + placeholderText + '</p>');
                    }
                });
            }
        }
    });

    CKEDITOR.replace('description_cku', {
        height: 300,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
            { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ],
        on: {
            instanceReady: function(evt) {
                var editor = evt.editor;
                var placeholderText = 'Provide a detailed description of the page';
                var wysiwygarea = editor.ui.space('contents').$;

                if (!editor.getData()) {
                    wysiwygarea.classList.add('placeholder');
                    editor.setData('<p>' + placeholderText + '</p>');
                }

                editor.on('focus', function() {
                    if (editor.getData().trim() === '<p>' + placeholderText + '</p>') {
                        editor.setData('');
                        wysiwygarea.classList.remove('placeholder');
                    }
                });

                editor.on('blur', function() {
                    if (!editor.getData()) {
                        wysiwygarea.classList.add('placeholder');
                        editor.setData('<p>' + placeholderText + '</p>');
                    }
                });
            }
        }
    });

    // Style for the placeholder
    CKEDITOR.on('instanceReady', function(evt) {
        var editor = evt.editor;
        var css = 'p {color: #888;} .cke_wysiwyg_frame .placeholder p {color: #888;}';
        var style = document.createElement('style');
        style.type = 'text/css';
        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }
        editor.document.getHead().$.appendChild(style);
    });
</script>


<style>
    @media (max-width: 768px) {
        .form-control {
            font-size: 0.9rem; /* Smaller font size for mobile */
        }
        .h3.mb-3 {
            font-size: 1.5rem; /* Adjust title size for smaller screens */
        }
    }
</style>

@endsection

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>

        $('#editPageForm').submit(function(event) {
    // Trim leading and trailing spaces from the review field
    var reviewField = $('#description', '#description_ar', '#description_cku');
    reviewField.val(reviewField.val().trim());
    
    // Ensure the field is not empty or just spaces after trimming
    if (reviewField.val() === '') {
        event.preventDefault();
        // alert("Review cannot be empty or just spaces.");
        return false; // Prevent form submission if empty after trimming
    }

});

        $(function () {
        $("#editPageForm").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 255,  // Set a reasonable max length for title
                    },
                    slug: {
                        required: true,
                        maxlength: 255,  // Set a reasonable max length for slug
                    },
                    description: {
                        required: true,
                        minlength: 10,  // Set a min length for description
                        maxlength: 1000,  // Set a max length for description
                    },
                },
                messages: {
                    title: {
                        required: "Please enter the title.",
                        maxlength: "Title can't exceed 255 characters.",
                    },
                    slug: {
                        required: "Please enter the slug.",
                        maxlength: "Slug can't exceed 255 characters.",
                    },
                    description: {
                        required: "Please provide a description.",
                        minlength: "Description must be at least 10 characters long.",
                        maxlength: "Description can't exceed 1000 characters.",
                    },
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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

