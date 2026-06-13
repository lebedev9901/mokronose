@extends('layouts.app')


@section('title', 'Корзина товаров')
@section('content')
<div class="container">

    <div class="cart">

    <h1 class="section-title">Корзина</h1>

    @if($items->isEmpty())
        <div class="cart-empty">
            <p>Корзина пуста</p>
            <a href="{{route('catalog')}}" class="btn-primary">Перейти в каталог</a>
        </div>
    @else

    <div class="cart-grid">

        <!-- ТОВАРЫ -->
        <div class="cart-items">

            @foreach($items as $item)
            <div class="cart-item">

                <div class="cart-item__info">
                    <h3>{{ $item->product->title }}</h3>
                    <p>{{ number_format($item->product->price, 2) }} ₽</p>
                </div>

                <!-- КОЛИЧЕСТВО -->
                <div class="cart-qty">

                    <form action="{{ route('cart.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="qty" value="{{ $item->qty - 1 }}">
                        <button @if($item->qty <= 1) disabled @endif>−</button>
                    </form>

                    <span>{{ $item->qty }}</span>

                    <form action="{{ route('cart.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                        <button>+</button>
                    </form>

                </div>

                <!-- СУММА -->
                <div class="cart-sum">
                    {{ number_format($item->qty * $item->product->price, 2) }} ₽
                </div>

                <!-- УДАЛИТЬ -->
                <form action="{{ route('cart.remove', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="cart-remove">✕</button>
                </form>

            </div>
            @endforeach

        </div>

        <!-- ИТОГ -->
        <div class="cart-summary">

            <h3>Итого</h3>

            <div class="cart-summary__row">
                <span>Товаров:</span>
                <span>{{ $cart->total_qty }}</span>
            </div>

            <div class="cart-summary__row">
                <span>Сумма:</span>
                <span>{{ number_format($cart->total_price, 2) }} ₽</span>
            </div>

            @if(session('promocode'))
                <div class="cart-summary__row cart-summary__row--discount">
                    <span>Скидка:</span>
                    <span>-{{ number_format(session('promocode.discount'), 2) }} ₽</span>
                </div>

                <div class="cart-summary__row cart-summary__row--total">
                    <span>К оплате:</span>
                    <span>{{ number_format(max($cart->total_price - session('promocode.discount'), 0), 2) }} ₽</span>
                </div>
            @endif
            <div class="cart-promocode">
                <label for="promocode">Промокод</label>

                <form action="{{ route('cart.promocode.apply') }}" method="POST" class="cart-promocode__form">
                    @csrf

                    <input
                        type="text"
                        id="promocode"
                        name="code"
                        placeholder="Введите промокод"
                        value="{{ session('promocode.code') }}"
                    >

                    <button type="submit">Применить</button>
                </form>

                @if(session('promocode'))
                    <div class="cart-promocode__success">
                        Промокод {{ session('promocode.code') }} применён

                        <form action="{{ route('cart.promocode.remove') }}" method="POST">
                            @csrf
                            <button type="submit">убрать</button>
                        </form>
                    </div>
                @endif

                @if(session('promocode_error'))
                    <div class="cart-promocode__error">
                        {{ session('promocode_error') }}
                    </div>
                @endif
            </div>
            @if(Auth::check())
                <a href="{{ route('order.checkout') }}" class="btn-primary">
                    Оформить заказ
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    Войти и оформить
                </a>
            @endif

            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button class="cart-clear">Очистить корзину</button>
            </form>

        </div>

    </div>

    @endif
</div>
</div>
@endsection