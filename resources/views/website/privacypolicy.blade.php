@include('website.header')
 <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">

   <!-- Inner Page Title Section -->
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
            <li class="active"><a href="{{ route('website.index') }}">{{__('messages.home')}} -></a></li>  
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
   <!-- Terms and Conditions Section -->
   <section class="about-page-des section-padding">
      <div class="container">
         <div class="row">
            <!-- Terms Content Section -->
            <div class="col-12">
               <div class="terms-content">
                  <!-- Display page description dynamically -->
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
