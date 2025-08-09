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


        </div>
    </div>
</div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
