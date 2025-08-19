@foreach($blog as $blogs)
<div class="blog-box">
   <!-- Blog Image -->
   <div class="blog-image">
      <a href="{{ route('website.blogdetail', base64_encode($blogs->id)) }}">
         <img src="{{ $blogs->image }}" alt="{{ $blogs->title }}" loading="lazy">
      </a>
   </div>

   <!-- Blog Content -->
   <div class="blog-content">
      <h3>
         <a href="{{ route('website.blogdetail', base64_encode($blogs->id)) }}">
            @if($currentLang == 'en')  
               {{ $blogs->title }}
            @elseif($currentLang == 'ar')
               {{ $blogs->title_ar }}
            @elseif($currentLang == 'cku')
               {{ $blogs->title_cku }}
            @endif
         </a>
      </h3>

      <p class="blog-date">{{ $blogs->created_at->format('F d, Y') }}</p>

      <p>
         @if($currentLang == 'en')   
            {!! Str::limit(strip_tags($blogs->description), 150) !!}
         @elseif($currentLang == 'ar')
            {!! Str::limit(strip_tags($blogs->description_ar), 150) !!}
         @elseif($currentLang == 'cku')
            {!! Str::limit(strip_tags($blogs->description_cku), 150) !!}
         @endif
      </p>

      <a href="{{ route('website.blogdetail', base64_encode($blogs->id)) }}" 
         class="btn btn-info">{{ __('messages.readmore') }}</a>
   </div>
</div>
@endforeach
