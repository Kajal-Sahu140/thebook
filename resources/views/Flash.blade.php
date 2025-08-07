<!-- resources/views/view/flash.blade.php -->
<style>
    .alert {
        position: fixed;
        top: 10px;
        right: 10px;
        width: auto;
        max-width: 300px;  /* Controls the maximum width of the alert */
        padding: 10px 20px;
        font-size: 14px;   /* Controls the font size */
        z-index: 9999;     /* Ensures the alert appears above other content */
        border-radius: 5px; /* Optional: rounded corners for the alert */
        opacity: 1;
    }
    .alert-success {
        margin-top:40px;
        background-color: #28a745;
        color: white;
    }
    .alert-danger {
        margin-top:40px;
        background-color: #dc3545;
        color: white;
    }
    .alert ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
</style>
@if (session('success'))
    <div class="alert alert-success" id="flash-message">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="flash-message">
        {{ session('error') }}
    </div>
@endif
{{----- @if ($errors->any())
    <div class="alert alert-danger" id="flash-message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif ----}}
<script>
    // Auto-hide flash message after 5 seconds
    setTimeout(function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.transition = 'opacity 0.5s ease';
            flashMessage.style.opacity = '0';
            setTimeout(function() {
                flashMessage.remove();
            }, 500); // Wait for fade-out transition
        }
    }, 5000); // 5 seconds
</script>
