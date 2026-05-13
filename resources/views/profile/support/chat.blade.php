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

                        <span class="{{ $chat->status }}">
                            {{ strtoupper($chat->status) }}
                        </span>

                    </div>

                </div>

            </div>

            {{-- MESSAGES --}}
            <div class="support-messages"
                 id="chat-box">

                @forelse($chat->message as $message)

                    <div class="support-message
                        {{ $message->sender_type === 'user'
                            ? 'user'
                            : 'support' }}">

                        <div class="support-message-content">

                            <div class="support-message-author">

                                {{ $message->user->name }}

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

            </div>

            {{-- FORM --}}
            @if($chat->status !== 'closed')

                <form action="{{ route('support.send', $chat->id) }}"
                      method="POST"
                      class="support-form">

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

const chatBox = document.getElementById('chat-box');

if(chatBox){
    chatBox.scrollTop = chatBox.scrollHeight;
}

</script>

@endpush