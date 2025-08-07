@include('website.header')
 <?php $currentLang = app()->getLocale(); ?>
<div class="site-bg">
<section class="inner-page-title-section section-padding">
      <div class="container">
         <h2>{{__('messages.brands')}}</h2>
         <ul>
            <li class="active"><a href="{{route('website.index')}}">Home -></a></li>
            <li>{{__('messages.brands')}}</li>
         </ul>
      </div>
   </section>
   <section class="after-login-pages-bg brand-page-des section-padding">
      <div class="container">
         <h2>{{__('messages.brands')}}</h2>
         <div class="brands-list">
            <ul>
                @if($brand)
                @foreach($brand as $brands)
                  @if($currentLang == 'en')
               <li><a href="{{route('website.branddetail', base64_encode($brands->id))}}"><img src="{{$brands->image }}" alt="brand"/></a></li>
               @elseif($currentLang == 'ar')
               <li><a href="{{route('website.branddetail', base64_encode($brands->id))}}"><img src="{{$brands->image_ar }}" alt="brand"/></a></li>
               @elseif($currentLang == 'cku')
               <li><a href="{{route('website.branddetail', base64_encode($brands->id))}}"><img src="{{$brands->image_cku }}" alt="brand"/></a></li>
               @else
               <li><a href="{{route('website.branddetail', base64_encode($brands->id))}}"><img src="{{$brands->image }}" alt="brand"/></a></li>
               @endif   
               @endforeach
               @else
               <li>Data Not Found</li>
               @endif
            </ul>
         </div>
      </div>
   </section>
</div>
@include('website.footer')