@extends('admin.layout')


@push('css')
   <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
    
@endpush

@section('content')
    @php
        // Determine the correct recipient name based on the logged-in user
        $recipient = ($chat->user_id === auth()->id()) ? $chat->recipient : $chat->user;
    @endphp
    <div class="col-md-6 mt-2 d-flex justify-content-end">
        <a href="{{ route('chats.index') }}">
            <button class="ui-btn btn-light btn">
                <span>
                    Volver
                </span>
            </button>
        </a>
    </div>

    <h2>Chat con {{ $recipient->name }}</h2>

    <!-- Make this container scrollable with a max height -->
    <div class="messages" id="messagesContainer" style="max-height: 400px; overflow-y: auto; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        @foreach($messages as $message)
            <p>
                <strong>{{ $message->user->name }}:</strong> {{ $message->body }} <br>
                <small>{{ $message->created_at->format('d M Y, H:i') }}</small> <!-- Display the date and time -->
            </p>
        @endforeach
    </div>

    <form action="{{ route('chats.storeMessage', $chat) }}" method="POST" style="margin-top: 10px;">
        @csrf
        <textarea class="form-control form-control-sm" name="message" rows="3" required style="width: 100%; margin-bottom: 5px"></textarea>
        <button class="btn btn-sm btn-secondary" type="submit">Enviar</button>
    </form>
@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Scroll the messages container to the bottom
        var messagesContainer = document.getElementById('messagesContainer');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });
</script>
@endsection
