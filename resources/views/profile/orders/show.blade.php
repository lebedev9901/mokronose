@extends('layouts.app')

@section('title', 'Заказ №' . $order->id)

@section('content')
<div class="container">
    <div class="order-page">

        <div class="order-head">
            <div>
                <a href="{{ route('profile.page', ['page' => 'orders']) }}" class="btn-secondary">
                    ← Назад к заказам
                </a>

                <h1>Заказ №{{ $order->id }}</h1>
                <p>Оформлен {{ $order->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <span class="order-status status-{{ $order->status }}">
                {{ $order->status_label }}
            </span>
            <form method="POST" action="{{ route('orders.repeat', $order->id) }}">
                    @csrf

                    <button type="submit" class="btn-primary">
                        Повторить заказ
                    </button>
                </form>
        </div>

        <div class="order-layout">

            <main class="order-main">

                <section class="order-card">
                    <div class="order-card-head">
                        <div>
                            <h2>Состав заказа</h2>
                            <p>{{ $order->items->sum('qty') }} товаров</p>
                        </div>

                        <strong>
                            {{ number_format($order->total_price ?? $order->total ?? 0, 0, '.', ' ') }} ₽
                        </strong>
                    </div>

                    <div class="order-items">
                        @foreach($order->items as $item)
                            @php
                                $product = $item->product;
                                $image = $product?->images?->where('is_preview', true)->first()
                                    ?? $product?->images?->first();
                            @endphp

                            <div class="order-item">

                                <a
                                    href="{{ $product ? route('product', $product->id) : '#' }}"
                                    class="order-item-img"
                                >
                                    @if($image)
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->title }}">
                                    @else
                                        <span>Нет фото</span>
                                    @endif
                                </a>

                                <div class="order-item-info">
                                    <h3>
                                        @if($product)
                                            <a href="{{ route('product', $product->id) }}">
                                                {{ $product->title }}
                                            </a>
                                        @else
                                            Товар удалён
                                        @endif
                                    </h3>

                                    <p>{{ $item->qty }} шт. × {{ number_format($item->price, 0, '.', ' ') }} ₽</p>
                                </div>

                                <div class="order-item-total">
                                    {{ number_format($item->price * $item->qty, 0, '.', ' ') }} ₽
                                </div>

                            </div>
                        @endforeach
                    </div>
                </section>

                
                <section class="order-card">
                    <div class="order-card-head">
                        <div>
                            <h2>Чат по заказу</h2>
                            <p>Связь с поддержкой по этому заказу</p>
                        </div>
                    </div>
                    

                    @if($order->chat)
                        @php
                            $lastMessage = $order->chat->message->last();
                        @endphp

                        @if($lastMessage)
                            <div class="last-message">
                                <strong>Последнее сообщение</strong>
                                <p>{{ $lastMessage->message }}</p>
                                <span>{{ $lastMessage->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        @else
                            <p class="muted">Сообщений пока нет.</p>
                        @endif

                        <a href="{{ route('support.chat', $order->chat->id) }}" class="btn-primary">
                            Открыть чат
                        </a>
                    @else
                        <div class="empty-block">
                            Чат по заказу пока не создан.
                        </div>
                    @endif
                    
                </section>

            </main>


            <aside class="order-sidebar">

                <section class="order-card order-summary-card">
                    <h2>Итого</h2>

                    <div class="order-summary-row">
                        <span>Товары</span>
                        <strong>
                            {{ number_format($order->total_before_discount ?? $order->total_price, 0, '.', ' ') }} ₽
                        </strong>
                    </div>

                    @if(($order->discount_amount ?? 0) > 0)
                        <div class="order-summary-row order-discount">
                            <span>
                                Скидка
                                @if($order->promocode_code)
                                    <small>({{ $order->promocode_code }})</small>
                                @endif
                            </span>

                            <strong>
                                -{{ number_format($order->discount_amount, 0, '.', ' ') }} ₽
                            </strong>
                        </div>
                    @endif

                    <div class="order-summary-row">
                        <span>Товаров</span>
                        <strong>{{ $order->items->sum('qty') }}</strong>
                    </div>

                    <div class="order-summary-row">
                        <span>Статус</span>
                        <strong>{{ $order->status_label }}</strong>
                    </div>

                    <div class="order-summary-total">
                        <span>Сумма к оплате</span>
                        <strong>
                            {{ number_format($order->total_after_discount ?? $order->total_price, 0, '.', ' ') }} ₽
                        </strong>
                    </div>
                </section>


                <section class="order-card">
                    <h2>Доставка</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            {{ $order->delivery_label ?? '—' }}
                        </p>

                        @if($order->delivery_method === 'courier')
                            <p>
                                <strong>Адрес:</strong>
                                {{ $order->address?->city ?? '' }},
                                {{ $order->address?->street ?? '' }},
                                {{ $order->address?->house ?? '' }}
                                @if($order->address?->apartment)
                                    , кв. {{ $order->address?->apartment }}
                                @endif
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
                </section>


                <section class="order-card">
                    <h2>Оплата</h2>

                    <div class="order-info-list">
                        <p>
                            <strong>Способ:</strong>
                            {{ $order->payment_label ?? '—' }}
                        </p>
                    </div>
                </section>
                

            </aside>

        </div>

    </div>
</div>
@endsection