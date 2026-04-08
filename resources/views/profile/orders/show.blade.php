{{-- resources/views/dashboard/orders/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">


<div class="dashboard">
    <button onclick="history.back()" class="btn btn-secondary">
    ← Назад
</button>
    <h1>Заказ #{{ $order->id }}</h1>

    <div class="order-detail">
        <p><strong>Дата:</strong> {{ $order->created_at }}</p>
        <p><strong>Статус:</strong> {{ $order->status }}</p>
        <p><strong>Сумма:</strong> {{ $order->total ?? '—' }}</p>
    </div>

    <hr>

    <div class="order-chat">
    <h3>Чат по заказу</h3>

    @if($order->chat)

        @php
            $lastMessage = $order->chat->message->last();
        @endphp

        <div class="last-message" style="margin-bottom:10px;">
            <strong>Последнее сообщение:</strong><br>

            @if($lastMessage)
                <div style="padding:10px; background:#f5f5f5; border-radius:10px; margin-top:5px;">
                    {{ $lastMessage->message }}

                    <div style="font-size:10px; text-align:right;">
                        {{ $lastMessage->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            @else
                <p>Сообщений пока нет</p>
            @endif
        </div>

        <a href="{{ route('chat.show', $order->chat->id) }}" class="btn btn-primary">
            Открыть чат
        </a>

    @else
        <p>Чат не найден</p>
    @endif
</div>

</div>
</div>
@endsection