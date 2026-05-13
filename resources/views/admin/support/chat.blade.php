@extends('admin.layouts.app')

@section('title', 'Чат поддержки')

@section('content')

<div style="display:flex; gap:20px;">

    {{-- LEFT --}}
    <div style="width:320px; border-right:1px solid #ddd;">

        @foreach($allChats as $item)

            <a href="{{ route('admin.support.chat', $item->id) }}"
               style="display:block;
                      padding:15px;
                      border-bottom:1px solid #eee;
                      text-decoration:none;">

                <strong>
                    {{ $item->user->name }}
                </strong>

                <div>
                    #{{ $item->id }}
                </div>

            </a>

        @endforeach

    </div>

    {{-- RIGHT --}}
    <div style="flex:1;">

        <h2>
            Чат #{{ $chat->id }}
        </h2>

        <div style="
            height:500px;
            overflow-y:auto;
            border:1px solid #ddd;
            padding:20px;
            margin-bottom:20px;
            border-radius:12px;
        ">

            @foreach($chat->message as $message)

                <div style="
                    margin-bottom:15px;
                    display:flex;
                    justify-content:
                        {{ $message->sender_type === 'support'
                            ? 'flex-end'
                            : 'flex-start' }};
                ">

                    <div style="
                        max-width:70%;
                        padding:12px;
                        border-radius:12px;
                        background:
                            {{ $message->sender_type === 'support'
                                ? '#2563eb'
                                : '#f3f4f6' }};
                        color:
                            {{ $message->sender_type === 'support'
                                ? 'white'
                                : 'black' }};
                    ">

                        <div>
                            {{ $message->message }}
                        </div>

                        <small>
                            {{ $message->created_at->format('d.m H:i') }}
                        </small>

                    </div>

                </div>

            @endforeach

        </div>

        <form method="POST"
              action="{{ route('admin.support.send', $chat->id) }}">

            @csrf

            <div style="display:flex; gap:10px;">

                <input type="text"
                       name="message"
                       placeholder="Введите сообщение..."
                       style="flex:1;">

                <button>
                    Отправить
                </button>

            </div>

        </form>

    </div>

</div>

@endsection