@extends('website.master')

@section('content')
<style>
/* === Blog Detail Page Styles === */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 15px;
}
.blog-detail-section {
    padding: 50px 20px;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    border-radius: 12px;
    margin-top: 30px;
}
.blog-title {
    font-size: 32px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 15px;
    color: #333;
}
.blog-meta {
    text-align: center;
    font-size: 14px;
    color: #777;
    margin-bottom: 25px;
}
.blog-image {
    width: 100%;
    max-height: 450px;
    margin-bottom: 30px;
    border-radius: 12px;
    overflow: hidden;
}
.blog-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.blog-content {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    text-align: justify;
}
.blog-content h2,
.blog-content h3 {
    margin-top: 20px;
    font-weight: bold;
    color: #333;
}
.blog-content a {
    color: #007bff;
    text-decoration: none;
}
.blog-content a:hover {
    text-decoration: underline;
}

/* === Related Posts === */
.related-posts {
    margin-top: 60px;
}
.related-posts h3 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
}
.related-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}
.related-item {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
    overflow: hidden;
}
.related-item:hover {
    transform: translateY(-5px);
}
.related-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.related-content {
    padding: 15px;
}
.related-content h4 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.related-content a {
    font-weight: 600;
    color: #007bff;
    text-decoration: none;
}
.related-content a:hover {
    color: #0056b3;
}

/* Responsive */
@media (max-width: 768px) {
    .blog-title { font-size: 26px; }
    .blog-content { font-size: 14px; }
    .related-item img { height: 150px; }
}
</style>

@php
    $currentLang = app()->getLocale();
@endphp

<div class="container">
    <!-- Blog Detail -->
    <section class="blog-detail-section">
        <h1 class="blog-title">
            @if($currentLang == 'ar')
                {{ $blog->title_ar }}
            @elseif($currentLang == 'cku')
                {{ $blog->title_cku }}
            @else
                {{ $blog->title }}
            @endif
        </h1>

        <p class="blog-meta">
            {{ __('messages.publishedon') }} {{ $blog->created_at->format('F d, Y') }}
        </p>

        @if($blog->image)
            <div class="blog-image">
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}">
            </div>
        @endif

        <div class="blog-content">
            @if($currentLang == 'ar')
                {!! $blog->description_ar !!}
            @elseif($currentLang == 'cku')
                {!! $blog->description_cku !!}
            @else
                {!! $blog->description !!}
            @endif
        </div>
    </section>

    <!-- Related Posts -->
    @if($relatedblog->count())
    <section class="related-posts">
        <h3>{{ __('messages.relatedposts') }}</h3>
        <div class="related-list">
            @foreach($relatedblog as $related)
            <div class="related-item">
                <img src="{{ $related->image }}" alt="{{ $related->title }}">
                <div class="related-content">
                    <h4>
                        @if($currentLang == 'ar')
                            {{ $related->title_ar }}
                        @elseif($currentLang == 'cku')
                            {{ $related->title_cku }}
                        @else
                            {{ $related->title }}
                        @endif
                    </h4>
                    <a href="{{ route('website.blogdetail', base64_encode($related->id)) }}">
                        {{ __('messages.readmore') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
