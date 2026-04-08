@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container">

  <div class="checkout">

    <h1 class="section-title">Оформление заказа</h1>

    <div class="checkout-grid">

        <!-- ЛЕВАЯ ЧАСТЬ -->
        <form action="{{ route('order.confirm') }}" method="POST" class="checkout-form"  id="checkout-form">
            @csrf

            <!-- КОНТАКТЫ -->
            <div class="checkout-block">
                <h3>Контактные данные</h3>

                <input type="text" name="name" placeholder="Ваше имя" required>
                <input type="tel" name="phone" placeholder="Телефон" required>
            </div>

            <!-- ДОСТАВКА -->
            <div class="checkout-block">
                <h3>Доставка</h3>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="pickup">
                    Самовывоз
                </label>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="courier">
                    Курьер (Яндекс)
                </label>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="cdek">
                    СДЭК
                </label>

                <label class="radio">
                    <input type="radio" name="delivery_method" value="post">
                    Почта России
                </label>
            </div>

            <!-- ОПЛАТА -->
            <div class="checkout-block">
                <h3>Оплата</h3>

                <label class="radio">
                    <input type="radio" name="payment_method" value="cash">
                    Наличными
                </label>

                <label class="radio">
                    <input type="radio" name="payment_method" value="online">
                    Онлайн
                </label>
            </div>

        </form>

        <!-- ПРАВАЯ ЧАСТЬ -->
        <div class="checkout-summary">

            <h3>Ваш заказ</h3>

            <div class="checkout-items">
                @foreach($cartItems as $item)
                    <div class="checkout-item">
                        <span>{{ $item->product->title }}</span>
                        <span>{{ $item->qty }} × {{ $item->product->price }} ₽</span>
                    </div>
                @endforeach
            </div>

            <div class="checkout-total">
                <span>Итого:</span>
                <strong>{{ number_format($total, 2) }} ₽</strong>
            </div>

            <button type="submit" form="checkout-form" class="btn-primary">
                Подтвердить заказ
            </button>

        </div>

    </div>

</div>
</div>
@endsection