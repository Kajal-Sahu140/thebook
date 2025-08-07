<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" href="{{ asset('storage/app/public/assets/website/fav.svg')}}" type="image/x-icon">
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <title>The Book door</title>
    <!-- Include Font Awesome CDN here -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/storage/app/public/assets/css/app.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Loader styles */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Optional: You can adjust the size of the loader GIF if needed */
        #loader img {
            width: 100px;
            height: 100px;
        }

        /* Flash message styles */
        #flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 250px;
            padding: 15px;
            border-radius: 5px;
            opacity: 1;
            transition: opacity 0.5s ease;
        }
    </style>
</head>

<body>
    @include('Flash') 
    <div id="loader">
        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif?20170503175831" alt="Loading...">
    </div>

    <!-- Page content starts here -->
    <div class="main-content">
        @include('admin.layout.sidebar')
        @include('admin.layout.header')

        <main class="content">
            @yield('content')
        </main>

        @include('admin.layout.footer')
    </div>

    <!-- JavaScript to hide the loader after page load -->
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loader').style.display = 'none';
        });
    </script>

    <!-- JavaScript to auto-close flash alert after 5 seconds -->
    <script>
        setTimeout(() => {
            // Check if flash message exists and close it after 5 seconds
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.opacity = '0';  // Fade out the flash message
                setTimeout(function() {
                    flashMessage.remove();  // Remove flash message after fade-out
                }, 500);  // Wait for fade-out transition
            }
        }, 5000);  // Wait 5 seconds before starting the fade-out
    </script>
    <script>
    setInterval(function () {
        fetch('{{ route("admin.dashboard") }}', { method: 'GET' })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url; // Redirect to login if session expired
                }
            })
            .catch(error => {
                console.error('Session check failed:', error);
                window.location.reload(); // Reload the page if there's an error
            });
    }, 60000); // Check session every 60 seconds
</script>
<!-- Add this just before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoFvZLLjHVYl+R0Zh+hhYRC1Ih+V5F3PbnX0p3EG5nknLPM" crossorigin="anonymous"></script>

</body>
</html>
