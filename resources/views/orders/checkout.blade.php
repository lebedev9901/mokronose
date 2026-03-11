@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container">

    <h1>Оформление заказа</h1>

    {{-- Состав заказа --}}
    <div class="order-summary">
        <h3>Ваш заказ</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>{{ number_format($item->product->price, 2) }} ₽</td>
                        <td>{{ number_format($item->product->price * $item->qty, 2) }} ₽</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Итого: {{ number_format($total, 2) }} ₽</h3>
    </div>

    <hr>

    <form action="{{ route('order.confirm') }}" method="POST">
        @csrf

        <h3>Способ доставки</h3>
        <label><input type="radio" name="delivery_method" value="pickup"> Самовывоз</label><br>
       <label><input type="radio" name="delivery_method" value="courier" required> Янекс.Маркет</label><br>
        <label><input type="radio" name="delivery_method" value="post"> СДЭК</label><br>
        <label><input type="radio" name="delivery_method" value="post"> Почта россии</label>

        <hr>

        <h3>Способ оплаты</h3>
        <label><input type="radio" name="payment_method" value="cash"> Наличные при получении (Самовывоз)</label><br>
        <label><input type="radio" name="payment_method" value="online"> Онлайн-оплата (Перевод)</label>

        <hr>

        <button type="submit" class="btn btn-primary">
            Подтвердить заказ
        </button>
    </form>

</div>
@endsection