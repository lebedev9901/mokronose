@extends('admin.layouts.app')

@section('title', 'Чат поддержки')
@section('page-title', 'Чат поддержки #' . $chat->id)
@section('page-subtitle', $chat->user->name ?? 'Пользователь удалён')

@section('content')

<div class="admin-support-chat-layout">

    <aside class="admin-support-sidebar">

        <div class="admin-support-sidebar__head">
            <h3>Все чаты</h3>
        </div>

        <div class="admin-support-sidebar__list">
            @foreach($allChats as $item)

                <a href="{{ route('admin.support.chat', $item->id) }}"
                   class="admin-support-sidebar__item {{ $chat->id === $item->id ? 'active' : '' }}">

                    <strong>{{ $item->user->name ?? 'Удалён' }}</strong>

                    <span>
                        Чат #{{ $item->id }}
                    </span>

                    @if($item->message->last())
                        <p>{{ \Illuminate\Support\Str::limit($item->message->last()->message, 35) }}</p>
                    @endif

                </a>

            @endforeach
        </div>

    </aside>

    <section class="admin-chat-panel">

        <div class="admin-chat-panel__head">
            <div>
                <h3>{{ $chat->user->name ?? 'Удалён' }}</h3>
                <p>Чат #{{ $chat->id }}</p>
            </div>

            @if($chat->status === 'open')
                <span class="admin-status admin-status--success">Открыт</span>
            @elseif($chat->status === 'waiting')
                <span class="admin-status admin-status--warning">Ждёт ответа</span>
            @elseif($chat->status === 'answered')
                <span class="admin-status admin-status--info">Ответили</span>
            @elseif($chat->status === 'closed')
                <span class="admin-status admin-status--danger">Закрыт</span>
            @else
                <span class="admin-status">{{ $chat->status }}</span>
            @endif
        </div>

        <div class="admin-chat-panel__body" id="adminSupportChatBox">

            @forelse($chat->message as $message)

                <div class="admin-chat-msg admin-chat-msg--{{ $message->sender_type }}">
                    <div class="admin-chat-msg__bubble">
                        <div class="admin-chat-msg__name">
                            {{ $message->user->name ?? 'Система' }}
                        </div>

                        <div class="admin-chat-msg__text">
                            {{ $message->message }}
                        </div>

                        <div class="admin-chat-msg__time">
                            {{ $message->created_at->format('d.m.Y H:i') }}
                        </div>
                    </div>
                </div>

            @empty

                <div class="admin-chat-empty">
                    Сообщений пока нет
                </div>

            @endforelse

        </div>

        <form method="POST"
              action="{{ route('admin.support.send', $chat->id) }}"
              class="admin-chat-panel__form">

            @csrf

            <textarea name="message" placeholder="Введите сообщение..." required></textarea>

            <button class="admin-btn">
                Отправить
            </button>

        </form>

    </section>

</div>

<script>
const adminSupportChatBox = document.getElementById('adminSupportChatBox');

if (adminSupportChatBox) {
    adminSupportChatBox.scrollTop = adminSupportChatBox.scrollHeight;
}
</script>

@endsection