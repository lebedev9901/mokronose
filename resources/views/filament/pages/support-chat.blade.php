<x-filament::page>

<div class="flex gap-4 h-[70vh]">

    {{-- список чатов --}}
    <div class="w-1/3 border rounded p-3 overflow-y-auto">

        @foreach(\App\Models\SupportChat::latest()->get() as $chat)

            <div
                wire:click="selectChat({{ $chat->id }})"
                class="p-3 mb-2 cursor-pointer rounded hover:bg-gray-100
                {{ $selectedChat?->id == $chat->id ? 'bg-gray-200' : '' }}">

                <div class="font-bold">
                    Чат #{{ $chat->id }}
                </div>

                <div class="text-xs text-gray-500">
                    {{ $chat->created_at->format('d.m H:i') }}
                </div>

            </div>

        @endforeach

    </div>


    {{-- окно чата --}}
    <div class="flex-1 flex flex-col border rounded">

        @if($selectedChat)

            {{-- сообщения --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-2">

                @foreach($selectedChat->message as $message)

                    <div class="max-w-xs p-2 rounded
                        {{ $message->sender_type == 'support'
                            ? 'bg-blue-100 ml-auto'
                            : 'bg-gray-200'
                        }}">

                        {{ $message->message }}

                        <div class="text-xs text-gray-500">
                            {{ $message->created_at->format('H:i') }}
                        </div>

                    </div>

                @endforeach

            </div>


            {{-- поле ввода --}}
            <div class="border-t p-3 flex gap-2">

                <input
                    type="text"
                    wire:model="newMessage"
                    wire:keydown.enter="sendMessage"
                    placeholder="Введите сообщение..."
                    class="flex-1 border rounded px-3 py-2"
                >

                <button
                    wire:click="sendMessage"
                    class="bg-blue-600 text-white px-4 rounded">

                    Отправить

                </button>

            </div>

        @else

            <div class="flex items-center justify-center h-full text-gray-500">
                Выберите чат
            </div>

        @endif

    </div>

</div>

</x-filament::page>