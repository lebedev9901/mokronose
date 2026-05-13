@extends('admin.layouts.app')

@section('title', 'Поддержка')

@section('content')

<h1>Чаты поддержки</h1>

<div class="admin-support-list">

    @forelse($chats as $chat)

        <a href="{{ route('admin.support.chat', $chat->id) }}"
           class="support-chat-item">

            <div>

                <strong>
                    {{ $chat->user->name }}
                </strong>

                <div>
                    Чат #{{ $chat->id }}
                </div>

            </div>

            <div>

                <div>
                    {{ $chat->status }}
                </div>

                @if($chat->message->last())
                    <small>
                        {{ \Illuminate\Support\Str::limit(
                            $chat->message->last()->message,
                            40
                        ) }}
                    </small>
                @endif

            </div>

        </a>

    @empty

        <p>Чатов пока нет</p>

    @endforelse

</div>

@endsection