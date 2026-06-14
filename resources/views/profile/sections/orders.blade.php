<div class="orders">

    <div class="profile-section-head">
        <div>
            <h1 class="section-title">📦 Мои заказы</h1>
            <p>История ваших покупок в Мокроносе</p>
        </div>
    </div>

    @forelse($orders as $order)

        <div class="order-card">

            <div class="order-card__top">
                <div>
                    <div class="order-id">Заказ №{{ $order->id }}</div>
                    <div class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                </div>

                <span class="order-status status-{{ $order->status }}">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="order-products-preview">

                @foreach($order->items->take(3) as $item)
                    @php
                        $product = $item->product;
                        $preview = $product?->images->where('is_preview', true)->first()
                            ?? $product?->images->first();
                    @endphp

                    <div class="order-preview-item">
                        <div class="order-preview-img">
                            @if($preview)
                                <img src="{{ asset('storage/' . $preview->image) }}" alt="{{ $product->title }}">
                            @else
                                <span>Нет фото</span>
                            @endif
                        </div>

                        <div>
                            <strong>{{ $product->title ?? 'Товар удалён' }}</strong>
                            <p>{{ $item->qty }} шт. × {{ number_format($item->price, 0, '.', ' ') }} ₽</p>
                        </div>
                    </div>
                @endforeach

                @if($order->items->count() > 3)
                    <div class="order-more-products">
                        + ещё {{ $order->items->count() - 3 }} товара
                    </div>
                @endif

            </div>

            <div class="order-card__body">
                <div>
                    <div class="muted">Итого</div>
                    <div class="order-total">
                        {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-secondary">
                        Подробнее
                    </a>

                    @if($order->chat)
                        <a href="{{ route('support.chat', $order->chat->id) }}" class="btn-primary">
                            Чат
                        </a>
                    @endif
                </div>
                <form method="POST" action="{{ route('orders.repeat', $order->id) }}">
                    @csrf

                    <button type="submit" class="btn-primary">
                        Повторить заказ
                    </button>
                </form>
            </div>

        </div>

    @empty
        <div class="empty-block">
            <h3>📦 У вас пока нет заказов</h3>
            <p>После оформления заказа он появится здесь.</p>
            <a href="{{ route('catalog') }}" class="btn-primary">Перейти в каталог</a>
        </div>
    @endforelse

    @if($orders->hasPages())
        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @endif

</div>