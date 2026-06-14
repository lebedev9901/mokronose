@extends('admin.layouts.app')

@section('title', 'Поддержка')
@section('page-title', 'Поддержка')
@section('page-subtitle', 'Чаты пользователей с поддержкой')

@section('content')

<div class="admin-page-head">
    <div>
        <h2>Чаты поддержки</h2>
        <p>Всего чатов: {{ $chats->count() }}</p>
    </div>
</div>

<div class="admin-support-list">

    @forelse($chats as $chat)

        <a href="{{ route('admin.support.chat', $chat->id) }}"
           class="admin-support-item">

            <div class="admin-support-item__main">
                <strong>{{ $chat->user->name ?? 'Удалён' }}</strong>

                <span>
                    Чат #{{ $chat->id }}
                </span>

                @if($chat->message->last())
                    <p>
                        {{ \Illuminate\Support\Str::limit($chat->message->last()->message, 80) }}
                    </p>
                @else
                    <p>Нет сообщений</p>
                @endif
            </div>

            <div class="admin-support-item__side">
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

                <small>
                    {{ $chat->updated_at->format('d.m.Y H:i') }}
                </small>
            </div>

        </a>

    @empty

        <div class="admin-form-card">
            <p class="admin-empty-text">Чатов пока нет</p>
        </div>

    @endforelse

</div>

@endsection