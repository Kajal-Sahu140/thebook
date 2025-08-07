<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy & policy</title>
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
     <?php $currentLang = app()->getLocale(); ?>
    <div class="container">
        <h1>
            @if($lang=='en')    
        {{ $page->title ?? 'privacy policy' }}
        @elseif($lang == 'ar')
        {{ $page->title_ar ?? 'privacy policy' }}
        @elseif($lang == 'cku')
        {{ $page->title_cku ?? 'privacy policy' }}
        @endif
    </h1>

        <!-- Display the page content -->
        <div class="aboutus-content">
           @if($lang == 'en')
            {!! $page->description ?? 'Content not available' !!}
            @elseif($lang == 'ar')
            {!! $page->description_ar ?? 'Content not available' !!}
            @elseif($lang == 'cku')
            {!! $page->description_cku ?? 'Content not available' !!}
            @else
            {!! $page->description ?? 'Content not available' !!}
            @endif
        </div>
    </div>
</body>
</html>
