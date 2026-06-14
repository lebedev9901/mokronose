@extends('admin.layouts.app')

@section('title', 'Заказ #' . $order->id)
@section('page-title', 'Заказ #' . $order->id)
@section('page-subtitle', 'Карточка заказа и чат с клиентом')

@section('content')

<div class="admin-order-layout">

    <div class="admin-form-card">

        <div class="admin-order-top">
            <h3>Информация о заказе</h3>

            @if($order->status === 'confirmed')
                <span class="admin-status admin-status--success">Подтверждён</span>
            @elseif($order->status === 'new')
                <span class="admin-status admin-status--warning">Новый</span>
            @else
                <span class="admin-status">{{ $order->status }}</span>
            @endif
        </div>

        <div class="admin-info-list">
            <div>
                <span>Клиент</span>
                <strong>{{ $order->user->name ?? 'Удалён' }}</strong>
            </div>

            <div>
                <span>Email</span>
                <strong>{{ $order->user->email ?? '-' }}</strong>
            </div>

            <div>
                <span>Телефон</span>
                <strong>{{ $order->user->phone ?? '-' }}</strong>
            </div>

            <div>
                <span>Дата заказа</span>
                <strong>{{ $order->created_at->format('d.m.Y H:i') }}</strong>
            </div>
        </div>

        <h3 class="admin-section-title">Товары</h3>

        <div class="admin-order-products">
            @foreach($order->items as $item)
                <div class="admin-order-product">
                    <div>
                        <strong>{{ $item->product->title ?? 'Удалён товар' }}</strong>
                        <span>x{{ $item->qty }}</span>
                    </div>

                    <strong>{{ number_format($item->price, 0, ',', ' ') }} ₽</strong>
                </div>
            @endforeach
        </div>

        <div class="admin-order-total">
            <span>Итого</span>
            <strong>{{ number_format($order->total_price, 0, ',', ' ') }} ₽</strong>
        </div>

        @if($order->status !== 'confirmed')
            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                @csrf
                <button class="admin-btn">
                    Подтвердить заказ
                </button>
            </form>
        @endif

    </div>

    <div class="admin-chat-panel">

        <div class="admin-chat-panel__head">
            <div>
                <h3>Чат с клиентом</h3>
                <p>Сообщения по заказу #{{ $order->id }}</p>
            </div>
        </div>

        <div class="admin-chat-panel__body"
             id="adminOrderChatMessages"
             data-url="{{ route('admin.orders.messages', $order->id) }}">

            @if($order->chat && $order->chat->message->count())
                @include('admin.orders.partials.messages', [
                    'messages' => $order->chat->message
                ])
            @else
                <div class="admin-chat-empty">
                    Сообщений пока нет
                </div>
            @endif

        </div>

        <form action="{{ route('admin.orders.message', $order->id) }}"
              method="POST"
              class="admin-chat-panel__form"
              id="adminOrderChatForm">

            @csrf

            <textarea name="message" placeholder="Написать клиенту..." required></textarea>

            <button class="admin-btn">
                Отправить
            </button>

        </form>

    </div>

</div>

<script>
const adminChatBox = document.getElementById('adminOrderChatMessages');
const adminChatForm = document.getElementById('adminOrderChatForm');

let lastAdminChatHtml = '';

function scrollAdminChatToBottom() {
    if (!adminChatBox) return;
    adminChatBox.scrollTop = adminChatBox.scrollHeight;
}

function loadAdminOrderMessages() {
    if (!adminChatBox) return;

    const isNearBottom =
        adminChatBox.scrollHeight
        - adminChatBox.scrollTop
        - adminChatBox.clientHeight < 80;

    fetch(adminChatBox.dataset.url, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (lastAdminChatHtml !== data.html) {
                lastAdminChatHtml = data.html;
                adminChatBox.innerHTML = data.html;

                if (isNearBottom) {
                    scrollAdminChatToBottom();
                }
            }
        });
}

if (adminChatForm) {
    adminChatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(adminChatForm);
        const textarea = adminChatForm.querySelector('textarea');

        fetch(adminChatForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(response => response.json())
            .then(() => {
                textarea.value = '';
                loadAdminOrderMessages();
            });
    });
}

scrollAdminChatToBottom();
loadAdminOrderMessages();
setInterval(loadAdminOrderMessages, 3000);
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('{{ route('notifications.markByData') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            type: 'new_order',
            key: 'order_id',
            value: '{{ $order->id }}'
        })
    });
});
</script>

@endsection