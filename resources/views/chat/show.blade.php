@extends('layouts.app')

@section('title', 'Чат поддержки')

@section('content')

<div class="container">

    <h2>Чат поддержки (заказ #{{ $chat->order_id }})</h2>

    <div class="chat-container" style="max-width:600px; margin:auto;">
    @foreach($chat->message as $msg)
        <div style="margin:10px 0; display:flex; {{ $msg->sender_type === 'support' ? 'justify-content:flex-start' : 'justify-content:flex-end' }}">
            <div style="padding:10px 15px; border-radius:15px; background: {{ $msg->sender_type === 'support' ? '#003566' : '#FFD60A' }}; color:{{ $msg->sender_type === 'support' ? 'white' : 'black' }}">
                {{ $msg->message }}
                <div style="font-size:10px; text-align:right; margin-top:5px;">
                    {{ $msg->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
        </div>
    @endforeach
</div>


    <form action="{{ route('chat.send', $chat->id) }}" method="POST">
        @csrf

        <textarea name="message" rows="3" style="width:100%" required></textarea>

        <button type="submit" class="btn btn-primary" style="margin-top:10px">
            Отправить
        </button>

    </form>

</div>

@endsection