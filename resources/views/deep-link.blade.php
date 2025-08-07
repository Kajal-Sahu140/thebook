<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deep Link</title>
    <script>
        window.onload = function () {
            var appSchemeUrl = "{{ $appSchemeUrl }}";
            var storeUrl = "{{ $storeUrl }}";
            window.location.href = appSchemeUrl;
            setTimeout(function () {
                window.location.href = storeUrl;
            }, 20000);
        };
    </script>
</head>
<body>
    <p>Redirecting to the app...</p>
</body>
</html>
