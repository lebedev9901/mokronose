@extends('admin.layouts.app')

@section('title', 'Заказы')
@section('page-title', 'Заказы')
@section('page-subtitle', 'Управление заказами магазина')

@section('content')

<div class="admin-page-head">
    <div>
        <h2>Список заказов</h2>
        <p>Всего заказов: {{ $orders->count() }}</p>
    </div>

    <div class="admin-order-badge">
        🔔 Новых заказов: <strong>{{ $newOrders }}</strong>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Клиент</th>
                <th>Телефон</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
                <th>Подтверждение</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="admin-muted">#{{ $order->id }}</td>

                    <td>
                        <strong>{{ $order->user->name ?? 'Удалён' }}</strong>
                    </td>

                    <td>{{ $order->user->phone ?? '-' }}</td>

                    <td>
                        <strong>{{ number_format($order->total_price, 0, ',', ' ') }} ₽</strong>
                    </td>

                    <td>
                        @if($order->status === 'new')
                            <span class="admin-status admin-status--warning">Новый</span>
                        @elseif($order->status === 'progress')
                            <span class="admin-status admin-status--info">В работе</span>
                        @elseif($order->status === 'done')
                            <span class="admin-status admin-status--success">Завершён</span>
                        @elseif($order->status === 'confirmed')
                            <span class="admin-status admin-status--success">Подтверждён</span>
                        @else
                            <span class="admin-status">{{ $order->status }}</span>
                        @endif
                    </td>

                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>

                    <td>
                        @if($order->status !== 'confirmed')
                            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                                @csrf
                                <button class="admin-btn-light" type="submit">
                                    Подтвердить
                                </button>
                            </form>
                        @else
                            <span class="admin-status admin-status--success">✔ Готово</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="admin-btn-light">
                            Открыть
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="admin-empty">
                        Заказов пока нет
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection