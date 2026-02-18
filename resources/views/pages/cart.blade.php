@extends('layouts.app')


@section('title', 'корзина')
@section('content')
<h1>Корзина</h1>

@if($items->isEmpty())
    <p>Корзина пуста. Перейдите в <a href="{{route('catalog')}}">каталог</a> для заказа</p>
@else
<table>
    <thead>
        <tr>
            <th>Товар</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Сумма</th>
            <th>Действие</th>
        </tr>
    </thead>
    <tbody>
       @foreach($items as $item)
<tr>
    <td>{{ $item->product->title }}</td>
    <td>{{ number_format($item->product->price, 2) }} ₽</td>
    <td>
        <form action="{{ route('cart.update', $item) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('PUT')
            <input type="hidden" name="qty" value="{{ $item->qty - 1 }}">
            <button type="submit" @if($item->qty <= 1) disabled @endif>-</button>
        </form>

        {{ $item->qty }}

        <form action="{{ route('cart.update', $item) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('PUT')
            <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
            <button type="submit">+</button>
        </form>
    </td>
    <td>{{ number_format($item->qty * $item->product->price, 2) }} ₽</td>
    <td>
        <form action="{{ route('cart.remove', $item) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Удалить</button>
        </form>
    </td>
</tr>
@endforeach
    </tbody>
     <tfoot>
            <tr>
                <td><strong>Всего товаров:</strong></td>
                <td></td>
                <td>{{ $cart->total_qty }}</td>
                <td>{{ number_format($cart->total_price, 2) }} ₽</td>
            </tr>
        </tfoot>
</table>


<form action="{{ route('cart.clear') }}" method="POST">
    @csrf
    <button type="submit">Очистить корзину</button>
</form>
@if(Auth::check())
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <button type="submit">Оформить заказ</button>
    </form>
@else
    <p>Чтобы оформить заказ, пожалуйста, <a href="{{ route('login') }}">войдите</a>.</p>
@endif
@endif
@endsection