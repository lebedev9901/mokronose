<div class="orders">

    <h1 class="section-title">Мои заказы</h1>

    @forelse($orders as $order)

        <div class="order-card">

            <div class="order-card__top">
                <div>
                    <h3 class="order-id">
                        Заказ #{{ $order->id }}
                    </h3>
                    <span class="order-date">
                        {{ $order->created_at->format('d.m.Y') }}
                    </span>
                </div>

                <span class="order-status status-{{ $order->status }}">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="order-card__body">
                <div class="order-price">
                    {{ $order->total_price }} ₽
                </div>

                <div class="order-actions">
                    <a href="{{ route('orders.show', $order->id)}}" class="btn-outline">
                        Подробнее
                    </a>

                    @if($order->chat)
                        <a href="{{ route('support.chat', $order->chat->id) }}" class="btn-primary">
                            Чат
                        </a>
                    @endif
                </div>
            </div>

        </div>
        {{ $orders->links() }}
    @empty

        <div class="empty-block">
            📦 У вас пока нет заказов
        </div>

    @endforelse

    <div class="pagination">
        {{ $orders->links() }}
    </div>

</div>
