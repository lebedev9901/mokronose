@extends('emails.layout')

@section('content')
@php
    $deliveryLabels = [
        'courier' => 'Курьерская доставка',
        'pickup' => 'Самовывоз',
        'cdek' => 'СДЭК',
        'post' => 'Почта России',
    ];

    $paymentLabels = [
        'cash' => 'Наличными',
        'card' => 'Картой',
        'online' => 'Онлайн-оплата',
        'sbp' => 'СБП',
    ];
@endphp
<h2 style="margin:0 0 15px;font-size:24px;">
    Заказ №{{ $order->id }} оформлен
</h2>

<p style="font-size:16px;line-height:1.6;">
    Спасибо за заказ! Мы получили вашу заявку и передали её в поддержку.
</p>

<div style="background:#FAF7F2;border-radius:14px;padding:18px;margin:25px 0;">
    <p><strong>Статус:</strong> {{ $order->status_label }}</p>
    <p><strong>Сумма:</strong> {{ $order->total_after_discount ?? $order->total_price }} ₽</p>
    <p><strong>Способ доставки:</strong> {{ $deliveryLabels[$order->delivery_method] ?? $order->delivery_method ?? 'Не указано' }}</p>
    <p><strong>Способ оплаты:</strong> {{ $paymentLabels[$order->payment_method] ?? $order->payment_method ?? 'Не указано' }}</p>
</div>

<h3 style="margin:25px 0 12px;">
    Состав заказа
</h3>

@foreach($order->items as $item)
    <div style="border-bottom:1px solid #eee;padding:10px 0;">
        <strong>{{ $item->product->title ?? 'Товар удалён' }}</strong><br>
        {{ $item->qty }} шт. × {{ $item->price }} ₽
    </div>
@endforeach

<a href="{{ route('orders.show', $order->id) }}"
   style="display:inline-block;background:#A86E2C;color:#fff;text-decoration:none;padding:14px 22px;border-radius:12px;margin-top:25px;">
    Открыть заказ
</a>

@endsection