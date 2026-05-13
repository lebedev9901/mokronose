

<div class="container">

    <div class="support-page">

        {{-- HEADER --}}
        <div class="support-header">

            <div>
                <h1>Поддержка</h1>
                <p>Ваши обращения и чаты с поддержкой</p>
            </div>

            <a href="{{ route('support.create') }}"
               class="support-create-btn">
                + Новый чат
            </a>

        </div>

        {{-- CHAT LIST --}}
        <div class="support-list">

            @forelse($chats as $chat)

                <a href="{{ route('support.chat', $chat->id) }}"
                   class="support-item">

                    <div class="support-item-top">

                        <div class="support-subject">
                            {{ $chat->subject ?? 'Без темы' }}
                        </div>

                        <div class="support-status {{ $chat->status }}">
                            {{ strtoupper($chat->status) }}
                        </div>

                    </div>

                    <div class="support-last-message">

                        @if($chat->message->last())
                            {{ Str::limit($chat->message->last()->message, 80) }}
                        @else
                            Сообщений пока нет
                        @endif

                    </div>

                    <div class="support-meta">

                        <span>
                            #{{ $chat->id }}
                        </span>

                        <span>
                            {{ $chat->updated_at->format('d.m.Y H:i') }}
                        </span>

                    </div>

                </a>

            @empty

                <div class="support-empty">
                    У вас пока нет обращений
                </div>

            @endforelse

        </div>

    </div>

</div>

