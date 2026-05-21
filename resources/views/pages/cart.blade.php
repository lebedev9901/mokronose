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