
<div class="container">

    <h1>Мои заказы</h1>

    @forelse($orders as $order)

        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px">

            <h3><a href="{{ route('orders.show', $order->id)}}">Заказ #{{ $order->id }}</a></h3>

            <p>Статус: {{ $order->status }}</p>
            <p>Сумма: {{ $order->total_price }} ₽</p>
            <p>Дата: {{ $order->created_at->format('d.m.Y') }}</p>

            @if($order->chat)
                <a href="{{ route('chat.show', $order->chat->id) }}" class="btn btn-primary">
                    Открыть чат поддержки
                </a>
            @endif
            
        </div>
        {{ $orders->links() }}
    @empty

        <p>У вас пока нет заказов</p>

    @endforelse
    
</div>

