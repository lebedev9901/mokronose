</x-filament-panels::page>
<div class="flex flex-col h-full">

    {{-- сообщения --}}
    <div class="flex-1 overflow-y-auto p-4" wire:poll.2s>

        @foreach($message->reverse() as $msg)

            <div class="mb-2">

                @if($msg->sender_type == 'support')

                    <div class="text-right">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded">
                            {{ $msg->message }}
                        </span>
                    </div>

                @else

                    <div class="text-left">
                        <span class="bg-gray-200 px-3 py-1 rounded">
                            {{ $msg->message }}
                        </span>
                    </div>

                @endif

            </div>

        @endforeach

    </div>

    {{-- поле ввода --}}
    <div class="p-3 border-t flex">

        <input
            type="text"
            wire:model.defer="message"
            wire:keydown.enter="send"
            class="flex-1 border rounded p-2"
            placeholder="Введите сообщение..."
        >

        <button
            wire:click="send"
            class="ml-2 bg-blue-600 text-white px-4 rounded"
        >
            Отправить
        </button>

    </div>

</div>
</x-filament-panels::page>