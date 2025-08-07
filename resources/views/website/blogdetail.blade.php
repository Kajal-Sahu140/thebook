@include('website.header')

<style>
/* Base Styles */
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

.section-padding {
    padding: 60px 15px;
}

/* Blog Detail Section */
.blog-detail-section {
    padding: 60px 15px;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    margin-top: 30px;
}

.blog-title {
    font-size: 36px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.blog-meta {
    text-align: center;
    color: #777;
    font-size: 14px;
    margin-bottom: 30px;
}

.blog-image {
    width: 100%;
    max-height: 400px;
    overflow: hidden;
    border-radius: 10px;
    margin-bottom: 30px;
}

.blog-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
    border-radius: 10px;
}

.blog-content {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 40px;
    text-align: justify;
}

.blog-content p {
    margin-bottom: 20px;
}

.blog-content h2,
.blog-content h3 {
    font-weight: bold;
    color: #333;
    margin-top: 20px;
}

.blog-content a {
    color: #007bff;
    text-decoration: none;
}

.blog-content a:hover {
    text-decoration: underline;
    color: #0056b3;
}

/* Related Posts Section */
.related-posts {
    margin-top: 60px;
    padding: 15px;
}

.related-posts h3 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 30px;
    color: #333;
    text-align: center;
}

.related-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.related-item {
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.related-item:hover {
    transform: translateY(-5px);
}

.related-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.related-item .related-content {
    padding: 15px;
}

.related-item h4 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.related-item a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.related-item a:hover {
    color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-title {
        font-size: 28px;
    }

    .blog-meta {
        font-size: 12px;
    }

    .blog-content {
        font-size: 14px;
    }

    .related-item img {
        height: 150px;
    }
}

@media (max-width: 576px) {
    .blog-title {
        font-size: 24px;
    }

    .related-list {
        grid-template-columns: 1fr;
    }
}
</style>
 <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
   <!-- Blog Detail Section -->
   <div class="container">
      <section class="blog-detail-section">
         <!-- Blog Title -->
         <h1 class="blog-title">
            <!-- {{$blog->description_ar}} -->
            @if($currentLang == 'en')   
            {{ $blog->title }}
            @elseif($currentLang == 'ar')
            {{ $blog->title_ar }}
            @elseif($currentLang == 'cku')
            {{ $blog->title_cku }}
            @else
            {{ $blog->title }}
            @endif
         </h1>
         <!-- Meta Information -->
         <p class="blog-meta">Published on {{ $blog->created_at->format('F d, Y') }}</p>
         <!-- Blog Image -->
         <div class="blog-image">
            <img src="{{ $blog->image }}" alt="{{ $blog->title }}">
         </div>
         <!-- Blog Content -->
         <div class="blog-content">
            @if($currentLang == 'en')   
                     {!! ($blog->description) !!}
                     @elseif($currentLang == 'ar')
                     {!! ($blog->description_ar) !!}
                     @elseif($currentLang == 'cku')
                     {!! ($blog->description_cku) !!}
                     @else
                     {!! ($blog->description) !!}
                     @endif
                     <!-- //{{ $blog->description }} -->
         </div>
      </section>

      <!-- Related Posts Section -->
      <section class="related-posts">
         <h3>Related Posts</h3>
         <div class="related-list">
            @foreach($relatedblog as $related)
            <div class="related-item">
               <img src="{{ $related->image }}" alt="{{ $related->title }}">
               <div class="related-content">
                  <h4>
                     @if($currentLang == 'en')  
                  {{ $related->title }}
                  @elseif($currentLang == 'ar')
                  {{ $related->title_ar }}
                  @elseif($currentLang == 'cku')
                  {{ $related->title_cku }}
                  @else
                  {{ $related->title }}
                  @endif
                </h4>
                  <a href="{{ route('website.blogdetail', base64_encode($related->id)) }}">{{__('messages.readmore')}}</a>
               </div>
            </div>
            @endforeach
         </div>
      </section>
   </div>
</div>

@include('website.footer')
