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

/* Inner Page Title Section */
.inner-page-title-section {
    background: linear-gradient(135deg, #def3f1, #def3f1);
    color: #fff;
    text-align: center;
    padding: 30px 15px;
}

.inner-page-title-section h2 {
    font-size: 36px;
    margin: 0;
    font-weight: bold;
}

.inner-page-title-section ul {
    padding: 0;
    margin: 15px 0 0;
    list-style: none;
    display: inline-block;
}

.inner-page-title-section ul li {
    display: inline;
    margin-right: 10px;
    font-size: 14px;
    color: #fff;
}

.inner-page-title-section ul li a {
    color: black;
    text-decoration: none;
}

.inner-page-title-section ul li.active a {
    font-weight: bold;
}

/* Blog Page Styles */
.blog-page h2 {
    text-align: center;
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 40px;
    color: #333;
}

.blog-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.blog-box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    position: relative;
}

.blog-box:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

.blog-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
}

.blog-content {
    padding: 15px;
}

.blog-content h3 {
    font-size: 20px;
    margin: 0 0 10px;
    font-weight: bold;
    color: #333;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.blog-content p {
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
}

.blog-content a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.blog-content a:hover {
    color: #0056b3;
}

.blog-content .blog-date {
    font-size: 12px;
    color: #999;
    margin-bottom: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-content h3 {
        font-size: 18px;
    }

    .blog-content p {
        font-size: 12px;
    }

    .inner-page-title-section h2 {
        font-size: 28px;
    }
}

@media (max-width: 576px) {
    .inner-page-title-section h2 {
        font-size: 24px;
    }

    .blog-content h3 {
        font-size: 16px;
    }

    .blog-image img {
        height: 150px;
    }
}
</style>

<?php $currentLang = app()->getLocale(); ?>

<div class="site-bg">
   <!-- Inner Page Title Section -->
   <section class="inner-page-title-section section-padding">
      <div class="container">
         <h2>{{__('messages.blogs')}}</h2>
         <ul>
            <li class="active"><a href="{{ route('website.index') }}">{{__('messages.home')}} -></a></li>
            <li>{{__('messages.blogs')}}</li>
         </ul>
      </div>
   </section>

   <!-- Blog Page -->
   <section class="blog-page section-padding">
      <div class="container">
         <h2>{{__('messages.blogpost')}}</h2>

         <!-- Blog List -->
         <div class="blog-list" id="blog-list">
            @include('website.partials.blog_list')
         </div>

         <!-- Load More Button -->
         @if($blog->hasMorePages())
            <div class="text-center mt-4">
               <button id="load-more" class="btn btn-primary" data-page="2">
                  {{ __('messages.loadmore') }}
               </button>
            </div>
         @endif

      </div>
   </section>
</div>

@include('website.footer')
