@extends('admin.layouts.app')

@section('title', 'Заказы')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Заказы</h1>
        <p class="page-subtitle">
            Всего заказов: {{ $orders->count() }}
        </p>
    </div>

    <div class="order-badge">
        🔔 Новых заказов:
        <span>{{ $newOrders }}</span>
    </div>

</div>

<div class="card">

    <table class="admin-table">

        <thead>
        <tr>
            <th>#</th>
            <th>Клиент</th>
            <th>Телефон</th>
            <th>Сумма</th>
            <th>Статус</th>
            <th>Дата</th>
            <th>Действия</th>
            <th></th>
        </tr>
        </thead>

        <tbody>

        @foreach($orders as $order)

            <tr>

                <td>
                    #{{ $order->id }}
                </td>

                <td>
                    {{ $order->user->name ?? 'Удалён' }}
                </td>

                <td>
                    {{ $order->user->phone ?? '-' }}
                </td>

                <td class="price">
                    {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                </td>

                <td>

                    @if($order->status == 'new')
                        <span class="status status-new">
                            Новый
                        </span>
                    @endif

                    @if($order->status == 'progress')
                        <span class="status status-progress">
                            В работе
                        </span>
                    @endif

                    @if($order->status == 'done')
                        <span class="status status-done">
                            Завершён
                        </span>
                    @endif

                </td>

                <td>
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </td>

                 <td>

                @if($order->status !== 'confirmed')

                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit">
                            Подтвердить
                        </button>
                    </form>

                @else
                    ✔ подтверждён
                @endif

            </td>

                <td>

                    <a href="{{ route('admin.orders.show', $order->id) }}"
                       class="btn btn-primary">
                        Открыть
                    </a>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection