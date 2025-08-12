@extends('admin.master')

@section('content')
<div class="container">
    <h2>Send WhatsApp Message</h2>

    <form action="{{ route('admin.whatsapp.send') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="users">Phone Numbers (comma-separated)</label>
            <textarea name="users" id="users" class="form-control" rows="3"
                placeholder="e.g. 911234567890, 919876543210"></textarea>
        </div>

        {{-- Hidden field for your fixed marketing message --}}
        <input type="hidden" name="message" value="Hi, I’m Pankaj from THEBOOKDOOR.
We run a book rental service where students can get high-quality books—novels, exam prep, self-help—without buying them.
We’re now partnering with libraries and coaching centers like yours to offer a mini-library inside your space, branded in your name, at no cost to you.
You earn every time a student joins our reading plan — and we manage the books, delivery, and tracking.
I’d love to set up a small reading zone for you, or send you a proposal. Can we talk more about it this week?

Image: https://thebookdoor.in/storage/app/public/assets/website/fav.svg">

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
