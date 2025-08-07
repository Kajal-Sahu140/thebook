@include('website.header')
 <?php $currentLang = app()->getLocale(); ?>
<style>

   .accordion-button {
      font-size: 1rem;
      padding: 0.75rem 1.25rem;
   }
   .accordion-body {
      font-size: 0.95rem;
      line-height: 1.5;
   }
   @media (max-width: 768px) {
      .inner-page-title-section h2 {
         font-size: 1.5rem;
         text-align: center;
      }
      .inner-page-title-section ul {
         text-align: center;
         padding: 0;
      }
      .accordion-button {
         font-size: 0.9rem;
         padding: 0.5rem 1rem;
      }
      .accordion-body {
         font-size: 0.85rem;
      }
   }
</style>
<div class="site-bg">
   <section class="inner-page-title-section section-padding">
      <div class="container">
         <h2>{{__('messages.Frequently_Asked_Questions')}}</h2>
         <ul>
            <li class="active"><a href="{{ route('website.index') }}">{{__('messages.home')}} -></a></li>
            <li>{{__('messages.Frequently_Asked_Questions')}}</li>
         </ul>
      </div>
   </section>
   <section class="frequently-page-des section-padding">
      <div class="container">
         <div class="accordion" id="accordionExample">
    @if($faq && count($faq) > 0)
        @foreach($faq as $index => $faqs)
            @php
                // Determine the text direction
                $textDirection = in_array($currentLang, ['ar', 'cku']) ? 'rtl' : 'ltr';
            @endphp
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button 
                        class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse{{ $index }}" 
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                        aria-controls="collapse{{ $index }}" 
                        style="text-align: {{ $textDirection == 'rtl' ? 'right' : 'left' }}; direction: {{ $textDirection }};">
                        
                        @if($currentLang == 'en')   
                            {{ $faqs->question }}
                        @elseif($currentLang == 'ar')
                            {{ $faqs->question_ar }}
                        @elseif($currentLang == 'cku')
                            {{ $faqs->question_cku }}
                        @else
                            {{ $faqs->question }}
                        @endif
                    </button>
                </h2>
                <div 
                    id="collapse{{ $index }}" 
                    class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                    aria-labelledby="heading{{ $index }}" 
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body" style="direction: {{ $textDirection }}; text-align: {{ $textDirection == 'rtl' ? 'right' : 'left' }};">
                        <p>
                            @if($currentLang == 'en')   
                                {{ $faqs->answer }}
                            @elseif($currentLang == 'ar')
                                {{ $faqs->answer_ar }}
                            @elseif($currentLang == 'cku')
                                {{ $faqs->answer_cku }}
                            @else
                                {{ $faqs->answer }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="accordion-item">
            <h2 class="accordion-header">
                Data not Found
            </h2>
        </div>
    @endif
</div>

      </div>
   </section>
</div>
@include('website.footer')
