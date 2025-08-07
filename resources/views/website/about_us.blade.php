@include('website.header')
 <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
   <!-- Page Title Section -->
   <section class="inner-page-title-section section-padding">
      <div class="container">
         <h2>
         @if($currentLang == 'en')   
         {{ \Illuminate\Support\Str::title($page->title) }}
         @elseif($currentLang == 'ar')
         {{ \Illuminate\Support\Str::title($page->title_ar) }}
         @elseif($currentLang == 'cku')
         {{ \Illuminate\Support\Str::title($page->title_cku) }}
         @else
         {{ \Illuminate\Support\Str::title($page->title) }}
         @endif
      </h2> 
         <ul class="breadcrumb">
            <li class="active">
               <a href="{{ route('website.index') }}">Home -></a>
            </li>  
            <li>
                @if($currentLang == 'en')   
         {{ \Illuminate\Support\Str::title($page->title) }}
         @elseif($currentLang == 'ar')
         {{ \Illuminate\Support\Str::title($page->title_ar) }}
         @elseif($currentLang == 'cku')
         {{ \Illuminate\Support\Str::title($page->title_cku) }}
      @else
         {{ \Illuminate\Support\Str::title($page->title) }}
         @endif
            </li>  
         </ul>
      </div>
   </section>
   <!-- About Page Section -->
   <section class="about-page-des section-padding">
      <div class="container">
         <div class="row">
            <!-- About Banner -->
            <div class="col-12">
               <div class="about-banner mb-4">
                  <img src="{{ asset('/storage/app/public/assets/website/images/about-banner.png') }}" alt="About Us Banner" class="img-fluid" />
               </div>
            </div>
            
            <!-- About Us Description -->
            <div class="col-12">
               <div class="about-description">
                  <!-- Display description dynamically with HTML tags intact -->
                  @if($currentLang == 'en')
                  {!! $page->description !!}
                  @elseif($currentLang == 'ar')
                  {!! $page->description_ar !!}
                  @elseif($currentLang == 'cku')
                  {!! $page->description_cku !!}
                  @else
                  {!! $page->description !!}
                  @endif
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@include('website.footer')
