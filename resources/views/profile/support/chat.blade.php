@extends('layouts.app')

@section('title', 'Чат поддержки')

@section('content')

<div class="container">

    <div class="support-chat-page">

        {{-- SIDEBAR --}}
        <div class="support-sidebar">

            <div class="support-sidebar-header">
                <h2>Поддержка</h2>

                <a href="{{ route('support.index') }}">
                    ← Назад
                </a>
            </div>

            <div class="support-sidebar-list">

                @foreach($allChats as $item)

                    <a href="{{ route('support.chat', $item->id) }}"
                       class="support-sidebar-item
                       {{ $chat->id === $item->id ? 'active' : '' }}">

                        <div class="support-sidebar-subject">
                            {{ $item->subject ?? 'Без темы' }}
                        </div>

                        <div class="support-sidebar-message">

                            @if($item->message->last())
                                {{ \Illuminate\Support\Str::limit($item->message->last()->message, 40) }}
                            @else
                                Нет сообщений
                            @endif

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

        {{-- CHAT --}}
        <div class="support-chat">

            {{-- HEADER --}}
            <div class="support-chat-header">

                <div>

                    <h2>
                        {{ $chat->subject ?? 'Чат поддержки' }}
                    </h2>

                    <div class="support-chat-status">

                        Статус:

                        <span id="supportChatStatus" class="{{ $chat->status }}">
                            {{ strtoupper($chat->status_label) }}
                        </span>

                    </div>

                </div>

            </div>

            {{-- MESSAGES --}}
            <div class="support-messages"
                id="chat-box"
                data-url="{{ route('support.messages', $chat->id) }}">

                @include('profile.support.partials.messages', [
                    'messages' => $chat->message
                ])

            </div>

            {{-- FORM --}}
            @if($chat->status !== 'closed')

                <form action="{{ route('support.send.ajax', $chat->id) }}"
      method="POST"
      class="support-form"
      id="supportChatForm">

    @csrf

    <textarea name="message"
              placeholder="Введите сообщение..."
              required></textarea>

    <button type="submit">
        Отправить
    </button>

</form>

            @else

                <div class="support-chat-closed">
                    Чат закрыт
                </div>

            @endif

        </div>

    </div>

</div>

@endsection




@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('{{ route('notifications.markByData') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            type: 'support_message',
            key: 'chat_id',
            value: '{{ $chat->id }}'
        })
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatBox = document.getElementById('chat-box');
    const supportChatForm = document.getElementById('supportChatForm');
    const supportChatStatus = document.getElementById('supportChatStatus');

    function scrollSupportChatToBottom() {
        if (!chatBox) return;
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function loadSupportMessages() {
    if (!chatBox) return;

    const isNearBottom =
        chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 80;

    fetch(chatBox.dataset.url, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (chatBox.innerHTML !== data.html) {
                chatBox.innerHTML = data.html;

                if (isNearBottom) {
                    scrollSupportChatToBottom();
                }
            }

            if (supportChatStatus && data.status) {
                supportChatStatus.className = data.status;
                supportChatStatus.innerText = data.status_label;
            }
        });
}

    if (supportChatForm) {
        supportChatForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(supportChatForm);
            const textarea = supportChatForm.querySelector('textarea');

            fetch(supportChatForm.action, {
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
                    loadSupportMessages();
                });
        });
    }

    scrollSupportChatToBottom();
    loadSupportMessages();
    setInterval(loadSupportMessages, 3000);
});
</script>
@endpush