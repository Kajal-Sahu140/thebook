@extends('admin.master')

@section('content')

<div class="col-md-10">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Refund Professional WhatsApp</h3>
        </div>

        <div class="card-body">

            {{-- Form --}}
            <form method="POST" action="{{ route('admin.sendMultipleWhatsApp') }}">
                @csrf

                <label>Enter WhatsApp Numbers (comma separated):</label><br>
                <textarea name="users" class="form-control" placeholder="Ex: 919999999999,918888888888" rows="3" required></textarea><br><br>

                <label>Message:</label><br>
                <textarea name="message" id="summernote" class="form-control" placeholder="Type your message here" required></textarea><br><br>

                <button type="submit" class="btn btn-success">Send WhatsApp</button>
            </form>

            {{-- WhatsApp Links Display --}}
            @if(isset($waLinks))
                <hr>
                <h4>Click each link below to send message:</h4>
                <ul id="wa-links">
                    @foreach ($waLinks as $index => $link)
                        <li style="margin-bottom: 10px;">
                            <a href="{{ $link }}" target="_blank" onclick="markDone({{ $index }})" id="link-{{ $index }}">
                                {{ $link }}
                            </a>
                            <span id="status-{{ $index }}" style="margin-left: 10px;"></span>
                        </li>
                    @endforeach
                </ul>

                {{-- Optional: Auto open all links one-by-one --}}
                <!-- <script>
                    // Auto-open the first link
                    window.open("{{ $waLinks[0] }}", "_blank");
                    markDone(0);

                    function markDone(index) {
                        const link = document.getElementById('link-' + index);
                        const status = document.getElementById('status-' + index);

                        if (!status.innerHTML.includes('✅')) {
                            status.innerHTML = '✅ Done';
                            link.style.color = 'gray';
                        }
                    }

                    // Optional: Auto-open all links one by one (set to true to enable)
                    const autoOpenAll = false;
                    if (autoOpenAll) {
                        let links = @json($waLinks);
                        let delay = 2500; // milliseconds

                        function openNext(index = 0) {
                            if (index >= links.length) return;
                            window.open(links[index], '_blank');
                            markDone(index);
                            setTimeout(() => openNext(index + 1), delay);
                        }

                        window.onload = () => openNext(1); // Starts from second since first is already opened
                    }
                </script> -->
                <script>
    // Auto-open the first link
    window.open("{{ $waLinks[0] }}", "_blank");
    markDone(0);

    function markDone(index) {
        const link = document.getElementById('link-' + index);
        const status = document.getElementById('status-' + index);
        const listItem = link.closest('li');

        if (!status.innerHTML.includes('✅')) {
            status.innerHTML = '✅ Done';
            link.style.color = 'gray';

            // Optional: remove the item after a short delay
            setTimeout(() => {
                listItem.remove();
            }, 1000); // delay (ms) before removing the item
        }
    }

    // Optional: Auto-open all links one by one (set to true to enable)
    const autoOpenAll = false;
    if (autoOpenAll) {
        let links = @json($waLinks);
        let delay = 2500; // milliseconds

        function openNext(index = 0) {
            if (index >= links.length) return;
            window.open(links[index], '_blank');
            markDone(index);
            setTimeout(() => openNext(index + 1), delay);
        }

        window.onload = () => openNext(1); // Start from second link
    }
</script>

            @endif

        </div>
    </div>
</div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Summernote library -->


<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>

@endsection
