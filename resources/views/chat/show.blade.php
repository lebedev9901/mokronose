@extends('layouts.app')

@section('title', 'Чат поддержки')

@section('content')

<div class="container">

    <div class="chat-page">

        {{-- HEADER --}}
        <div class="chat-header">
            <button class="back-btn" onclick="window.history.back()">
                ← Назад
            </button>

            <h2>Чат поддержки</h2>

            <div class="chat-subtitle">
                Заказ #{{ $chat->order_id ?? '—' }}
            </div>
        </div>

        {{-- CHAT BOX --}}
        <div class="chat-box" id="chatBox">

            @forelse($chat->message as $msg)

                <div class="msg {{ $msg->sender_type === 'support' ? 'support' : 'user' }}">

                    <div class="bubble">

                        <div class="text">
                            {{ $msg->message }}
                        </div>

                        <div class="time">
                            {{ $msg->created_at->format('d.m.Y H:i') }}
                        </div>

                    </div>

                </div>

            @empty
                <div class="empty">
                    Сообщений пока нет
                </div>
            @endforelse

        </div>

        {{-- INPUT --}}
        <form class="chat-form" action="{{ route('chat.send', $chat->id) }}" method="POST">
            @csrf

            <textarea name="message" placeholder="Напишите сообщение..." required></textarea>

            <button type="submit">Отправить</button>
        </form>

    </div>

</div>

@endsection




@push('scripts')
<script>
const box = document.getElementById('chatBox');
if(box){
    box.scrollTop = box.scrollHeight;
}
</script>
@endpush