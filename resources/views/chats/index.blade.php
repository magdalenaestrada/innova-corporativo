@extends('admin.layout')

@section('content')

<h2>Comienza un nuevo chat</h2>
<form action="{{ route('chats.start') }}" method="POST">
    @csrf
    <label for="recipient">Seleccione un usuario para chatear:</label>
    <select name="recipient_id" id="recipient" class="buscador" required>
        @foreach($users as $user)
            @if($user->id !== auth()->id()) <!-- Exclude the logged-in user -->
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endif
        @endforeach
    </select>
    <button class="btn btn-light" type="submit">Comenzar Chat</button>
</form>

<hr>

<h2>Tus Chats</h2>
@foreach($chats as $chat)
    @php
        // Determine the correct recipient name
        $recipient = ($chat->user_id === auth()->id()) ? $chat->recipient : $chat->user;
        $lastMessage = $chat->messages->first(); // Get the last message (already fetched in the query)

        // Determine if the last message is from the logged-in user or the recipient
        $lastMessageSender = $lastMessage && $lastMessage->user_id === auth()->id() ? 'Tú' : $recipient->name;
    @endphp

    @if($lastMessage)
        <a href="{{ route('chats.show', $chat) }}">
            <div class="card pl-3 pt-2">
                Chat con {{ $recipient->name }}
                <p style="color:black">
                    <strong>{{ $lastMessageSender }}:</strong> {{ $lastMessage->body }} 
                    <small style="color: #999">{{ $lastMessage->created_at->format('d M Y, H:i') }}</small>
                </p>
            </div>
        </a>    
    @endif

@endforeach

<hr>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.buscador').select2({theme: "classic"});
        $('.buscador2').select2({theme: "classic"});
    });
</script>

@endpush
