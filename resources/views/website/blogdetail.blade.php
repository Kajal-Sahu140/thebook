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
    margin: 40px auto;
    padding: 15px;
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

/* Main Blog Card */
.main-blog {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    padding: 25px;
}

.main-blog h1 {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #2c257f;
}

.main-blog .author {
    font-size: 14px;
    color: #777;
    margin-bottom: 20px;
}

.main-blog p {
    font-size: 15px;
    line-height: 1.7;
    color: #555;
}

.main-blog a {
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    color: #2c257f;
    display: inline-block;
    margin-top: 15px;
}

/* Sidebar Blog List */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.sidebar-card {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    padding: 10px;
    gap: 15px;
    transition: transform 0.3s ease;
}

.sidebar-card:hover {
    transform: translateY(-3px);
}

.sidebar-card img {
    width: 80px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
}

.sidebar-info h4 {
    font-size: 16px;
    margin: 0;
    color: #2c257f;
    line-height: 1.3;
}

.sidebar-info p {
    font-size: 13px;
    color: #666;
    margin: 5px 0 0 0;
}

/* Responsive */
@media(max-width: 900px) {
    .container {
        grid-template-columns: 1fr;
    }
}
</style>

<?php $currentLang = app()->getLocale(); ?>

<div class="container">
    
    <!-- Main Featured Blog -->
    <div class="main-blog">
        <h1>
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
        
        <p class="author">
            {{ $blog->author ?? 'Admin' }} • {{ $blog->created_at->format('F d, Y') }}
        </p>
        
       <p>
            @if($currentLang == 'en')   
                {!! $blog->description !!}
            @elseif($currentLang == 'ar')
                {!! $blog->description_ar !!}
            @elseif($currentLang == 'cku')
                {!! $blog->description_cku !!}
            @else
                {!! $blog->description !!}
            @endif
        </p>

        
     
    </div>

    <!-- Sidebar Blogs -->
   <!-- Sidebar Blogs -->
<div class="sidebar">
    @foreach($relatedblog as $related)
    <a href="{{ route('website.blogdetail', base64_encode($related->id)) }}" class="sidebar-card" style="text-decoration:none;">
        <img src="{{ $related->image }}" alt="{{ $related->title }}">
        <div class="sidebar-info">
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
            <p>{{ $related->author ?? 'Guest' }} • {{ $related->created_at->format('h:i A') }}</p>
        </div>
    </a>
    @endforeach
</div>


</div>

@include('website.footer')
