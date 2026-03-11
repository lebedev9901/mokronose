@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')

<div class="container">

    <h1>Мои заказы</h1>

    @forelse($orders as $order)

        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px">

            <h3>Заказ #{{ $order->id }}</h3>

            <p>Статус: {{ $order->status }}</p>
            <p>Сумма: {{ $order->total_price }} ₽</p>
            <p>Дата: {{ $order->created_at }}</p>

            @if($order->chat)
                <a href="{{ route('chat.show', $order->chat->id) }}" class="btn btn-primary">
                    Открыть чат поддержки
                </a>
            @endif

        </div>

    @empty

        <p>У вас пока нет заказов</p>

    @endforelse

</div>

@endsection