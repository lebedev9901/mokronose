@extends('admin.layouts.app')

@section('title', 'Заказ #' . $order->id)

@section('content')

<div class="order-layout">

    {{-- LEFT --}}
    <div class="order-info card">

        <div class="order-top">

            <h1>
                Заказ #{{ $order->id }}
            </h1>

            <span class="status status-new">
                {{ $order->status }}
            </span>

        </div>

        <div class="info-group">
            <label>Клиент</label>
            <div>{{ $order->user->name }}</div>
        </div>

        <div class="info-group">
            <label>Email</label>
            <div>{{ $order->user->email }}</div>
        </div>

        <div class="info-group">
            <label>Телефон</label>
            <div>{{ $order->user->phone }}</div>
        </div>

        <hr>

        <h3>Товары</h3>

        <div class="order-products">

            @foreach($order->items as $item)

                <div class="product-row">

                    <div>
                        {{ $item->product->title ?? 'Удалён товар' }}
                    </div>

                    <div>
                        x{{ $item->qty }}
                    </div>

                    <div>
                        {{ $item->price }} ₽
                    </div>

                </div>

            @endforeach

        </div>

        <hr>

        <div class="order-total">
            Итого:
            <strong>
                {{ $order->total_price }} ₽
            </strong>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="chat-box card">

        <div class="chat-header">
            Чат заказа
        </div>

        <div class="chat-messages">

            @if($order->chat)

                @foreach($order->chat->message as $message)

                    <div class="message {{ $message->sender_type }}">

                        <div class="message-user">
                            {{ $message->user->name }}
                        </div>

                        <div class="message-text">
                            {{ $message->message }}
                        </div>

                        <div class="message-date">
                            {{ $message->created_at->format('H:i') }}
                        </div>

                    </div>

                @endforeach

            @else

                <div class="empty-chat">
                    Сообщений пока нет
                </div>

            @endif

        </div>

        <form action="{{ route('admin.orders.message', $order->id) }}"
              method="POST"
              class="chat-form">

            @csrf

            <textarea name="message"
                      placeholder="Введите сообщение"></textarea>

            <button class="btn btn-primary">
                Отправить
            </button>

        </form>

    </div>

</div>

@endsection