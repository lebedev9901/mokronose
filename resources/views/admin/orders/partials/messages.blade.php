@forelse($messages as $message)

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