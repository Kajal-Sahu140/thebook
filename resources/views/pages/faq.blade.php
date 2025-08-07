 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('public/storage/assets/img/icons/favicon-32x32.png') }}" />
    <title>My Babe || About Us </title>
    <style>
        /* Reset body and html margins and padding */
        body, html {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        /* Container styling */
        .container {
            width: 100%;
            max-width: 900px;
            text-align: center;
            padding: 20px;
            margin: 0 auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: white;
        }

        /* Heading and content styling */
        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .aboutus-content {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }
            .aboutus-content {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }
            .aboutus-content {
                font-size: 0.9rem;
            }
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
 <section class="frequently-page-des section-padding">
      <div class="container">
         <div class="accordion" id="accordionExample">
            @if($page && count($page) > 0)
               @foreach($page as $index => $faqs)
               <div class="accordion-item">
                  <h2 class="accordion-header" id="heading{{ $index }}">
                     <button 
                        class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse{{ $index }}" 
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                        aria-controls="collapse{{ $index }}">
                        @if($lang == 'en')   
                        {{ $faqs->question }}
                        @elseif($lang == 'ar')
                        {{ $faqs->question_ar }}
                        @elseif($lang == 'cku')
                        {{ $faqs->question_cku }}
                        @endif
                     </button>
                  </h2>
                  <div 
                     id="collapse{{ $index }}" 
                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                     aria-labelledby="heading{{ $index }}" 
                     data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                        <p>
                            @if($lang == 'en')   
                            {{ $faqs->answer }}
                            @elseif($lang == 'ar')
                            {{ $faqs->answer_ar }}
                            @elseif($lang == 'cku')
                            {{ $faqs->answer_cku }}
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
</body>
</html>