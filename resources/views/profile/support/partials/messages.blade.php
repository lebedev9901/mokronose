@forelse($messages as $message)

    <div class="support-message {{ $message->sender_type === 'user' ? 'user' : 'support' }}">
        <div class="support-message-content">

            <div class="support-message-author">
                {{ $message->user->name ?? 'Система' }}
            </div>

            <div class="support-message-text">
                {{ $message->message }}
            </div>

            <div class="support-message-time">
                {{ $message->created_at->format('d.m.Y H:i') }}
            </div>

        </div>
    </div>

@empty

    <div class="support-empty-chat">
        Сообщений пока нет
    </div>

@endforelse