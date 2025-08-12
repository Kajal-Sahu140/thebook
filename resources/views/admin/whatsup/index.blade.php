@extends('admin.master')

@section('content')
<div class="container">
    <h2>Send WhatsApp Message</h2>

    <form action="{{ route('admin.whatsapp.send') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="users">Phone Numbers (comma-separated)</label>
            <textarea name="users" id="users" class="form-control" rows="3" placeholder="e.g. 911234567890, 919876543210"></textarea>
        </div>

        <div class="mb-3">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" rows="3" placeholder="Type your message"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Generate WhatsApp Links</button>
    </form>

    @if(!empty($waLinks))
        <hr>
        <h4>Click to Send</h4>
        <ul>
            @foreach($waLinks as $link)
                <li><a href="{{ $link }}" target="_blank">{{ $link }}</a></li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
