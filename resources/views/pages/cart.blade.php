@extends('layouts.app')


@section('title', 'Корзина товаров')
@section('content')
<div class="container">

    <div class="cart flex">

    <h1 class="section-title">Корзина</h1>

    @if($items->isEmpty())
        <div class="cart-empty">
            <p>Корзина пуста</p>
            <a href="{{route('catalog')}}" class="btn-primary">Перейти в каталог</a>
        </div>
        @if($recommendedProducts->count())
    <section class="cart-recommendations">

        <div class="profile-section-head">
            <div>
                <h2>🐾 Возможно, вам подойдёт</h2>
                <p>Подборка товаров для быстрого старта</p>
            </div>
        </div>

        <div class="recommendations-grid">
            @foreach($recommendedProducts as $product)
                @php
                    $preview = $product->images->where('is_preview', true)->first()
                        ?? $product->images->first();
                @endphp

                <a href="{{ route('product', $product->id) }}" class="recommendation-card">
                    <img
                        src="{{ $preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png') }}"
                        alt="{{ $product->title }}"
                    >

                    <div>
                        <h3>{{ $product->title }}</h3>
                        <p>{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                    </div>
                </a>
            @endforeach
        </div>

    </section>
@endif
    @else

    <div class="cart-grid">

        <!-- ТОВАРЫ -->
        <div class="cart-items">

            @foreach($items as $item)
            <div class="cart-item" id="cart-item-{{$item->id}}">

                <div class="cart-item__info">
                    <h3>{{ $item->product->title }}</h3>
                    <p>{{ number_format($item->product->price, 2) }} ₽</p>
                </div>

                <!-- КОЛИЧЕСТВО -->
              <div class="cart-qty" data-item-id="{{ $item->id }}">
    <button
        type="button"
        class="cart-qty__btn cart-qty__minus"
        data-url="{{ route('cart.update', $item) }}"
        data-qty="{{ $item->qty - 1 }}"
        @if($item->qty <= 1) disabled @endif
    >
        −
    </button>

    <span class="cart-qty__value" id="cart-qty-{{ $item->id }}">
        {{ $item->qty }}
    </span>

    <button
        type="button"
        class="cart-qty__btn cart-qty__plus"
        data-url="{{ route('cart.update', $item) }}"
        data-qty="{{ $item->qty + 1 }}"
    >
        +
    </button>
</div>

                <!-- СУММА -->
                <div class="cart-sum" id="cart-item-total-{{ $item->id }}">
                    {{ number_format($item->qty * $item->product->price, 2, '.', ' ') }} ₽
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
                <span id="cart-total-count">{{ $cart->total_qty }}</span>
            </div>

            <div class="cart-summary__row">
                <span>Сумма:</span>
               <span id="cart-total-price">{{ number_format($cart->total_price, 2, '.', ' ') }} ₽</span>
            </div>

            @if(session('promocode'))
                <div class="cart-summary__row cart-summary__row--discount">
                    <span>Скидка:</span>
                    <span>-{{ number_format(session('promocode.discount'), 2) }} ₽</span>
                </div>

                <div class="cart-summary__row cart-summary__row--total">
                    <span>К оплате:</span>
                    <span id="cart-pay-total">
                        {{ number_format(max($cart->total_price - session('promocode.discount'), 0), 2, '.', ' ') }} ₽
                    </span>
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
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.cart-qty__btn');

    if (!btn) return;

    const qtyBox = btn.closest('.cart-qty');
    const itemId = qtyBox.dataset.itemId;

    fetch(btn.dataset.url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            _method: 'PUT',
            qty: btn.dataset.qty,
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById(`cart-qty-${itemId}`).innerText = data.qty;

        const minusBtn = qtyBox.querySelector('.cart-qty__minus');
        const plusBtn = qtyBox.querySelector('.cart-qty__plus');

        minusBtn.dataset.qty = data.next_minus_qty;
        plusBtn.dataset.qty = data.next_plus_qty;
        minusBtn.disabled = data.minus_disabled;

        document.getElementById(`cart-item-total-${itemId}`).innerText = data.item_total;
        document.getElementById('cart-total-count').innerText = data.count;
        document.getElementById('cart-total-price').innerText = data.total;

        const payTotal = document.getElementById('cart-pay-total');

        if (payTotal && data.pay_total !== undefined) {
            payTotal.innerText = data.pay_total;
        }

        if (typeof updateCartIcon === 'function') {
            updateCartIcon(data.count);
        }
    });
});
</script>
@endsection