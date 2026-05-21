{{-- resources/views/dashboard/orders/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="order-page">

        <button onclick="history.back()" class="btn btn-secondary">
            ← Назад
        </button>

        <div class="order-head">
            <div>
                <h1>Заказ #{{ $order->id }}</h1>
                <p>от {{ $order->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="order-status">
                {{ $order->status_label }}
            </div>
        </div>

        <div class="order-layout">

            <div class="order-main">

                <div class="order-card">
                    <h2>Состав заказа</h2>

                    <div class="order-items">
                        @foreach($order->items as $item)
                            @php
                                $product = $item->product;
                                $image = $product?->images?->first();
                            @endphp

                            <div class="order-item">
                                <div class="order-item-img">
                                    @if($image)
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->title }}">
                                    @else
                                        <span>Нет фото</span>
                                    @endif
                                </div>

                                <div class="order-item-info">
                                    <h3>{{ $product?->title ?? 'Товар удалён' }}</h3>
                                    <p>Количество: {{ $item->qty }}</p>
                                    <p>Цена: {{ number_format($item->price, 0, '.', ' ') }} ₽</p>
                                </div>

                                <div class="order-item-total">
                                    {{ number_format($item->price * $item->qty, 0, '.', ' ') }} ₽
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="order-card">
                    <h2>Чат по заказу</h2>

                    @if($order->chat)
                        @php
                            $lastMessage = $order->chat->message->last();
                        @endphp

                        @if($lastMessage)
                            <div class="last-message">
                                <strong>Последнее сообщение:</strong>
                                <p>{{ $lastMessage->message }}</p>
                                <span>{{ $lastMessage->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        @else
                            <p class="muted">Сообщений пока нет</p>
                        @endif

                        <a href="{{ route('support.chat', $order->chat->id) }}" class="btn btn-primary">
                            Открыть чат
                        </a>
                    @else
                        <p class="muted">Чат не найден</p>
                    @endif
                </div>

            </div>

            <aside class="order-sidebar">

                <div class="order-card">
                    <h2>Итого</h2>

                    <div class="order-total">
                        {{ number_format($order->total_price ?? $order->total ?? 0, 0, '.', ' ') }} ₽
                    </div>
                </div>

                <div class="order-card">
                    <h2>Доставка</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            {{ $order->delivery_label }}
                        </p>

                        @if($order->delivery_method === 'courier')
                            <p>
                                <strong>Адрес:</strong>
                                {{ $order->address?->city }},
                                {{ $order->address?->street }},
                                {{ $order->address?->house }},
                                {{ $order->address?->apartment }}
                            </p>
                        @endif

                        @if($order->delivery_method === 'pickup')
                            <p>
                                <strong>Пункт самовывоза:</strong>
                                {{ $order->pickup_point ?? '—' }}
                            </p>
                        @endif

                        @if($order->delivery_method === 'cdek')
                            <p>
                                <strong>Пункт СДЭК:</strong>
                                {{ $order->cdek_point ?? '—' }}
                            </p>
                        @endif

                        @if($order->delivery_method === 'post')
                            <p>
                                <strong>Почтовый адрес:</strong>
                                {{ $order->post_address ?? '—' }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="order-card">
                    <h2>Оплата</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            {{ $order->payment_label }}
                        </p>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</div>
@endsection