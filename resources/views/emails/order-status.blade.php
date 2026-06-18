@extends('emails.layout')

@section('content')

<h2 style="margin:0 0 15px;font-size:24px;">
    {{ $titleText }}
</h2>

<p style="font-size:16px;line-height:1.6;">
    {{ $messageText }}
</p>

<div style="background:#FAF7F2;border-radius:14px;padding:18px;margin:25px 0;">
    <p><strong>Заказ:</strong> №{{ $order->id }}</p>
    <p><strong>Статус:</strong> {{ $order->status_label }}</p>
    <p><strong>Сумма:</strong> {{ $order->total_price }} ₽</p>
</div>

<a href="{{ route('orders.show', $order->id) }}"
   style="display:inline-block;background:#A86E2C;color:#fff;text-decoration:none;padding:14px 22px;border-radius:12px;">
    Открыть заказ
</a>

@endsection