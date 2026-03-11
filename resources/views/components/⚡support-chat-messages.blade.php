<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="flex flex-col h-[400px] border rounded p-2">
    <div class="flex-1 overflow-y-auto mb-2" id="chat-box" wire:poll.2s>
        @foreach($message->reverse() as $msg)
            <div class="mb-1 {{ $msg->sender_type === 'support' ? 'text-right text-blue-600' : 'text-left text-gray-700' }}">
                <span class="inline-block p-1 rounded {{ $msg->sender_type === 'support' ? 'bg-blue-100' : 'bg-gray-200' }}">
                    {{ $msg->message }}
                </span>
            </div>
        @endforeach
    </div>

    <div class="flex">
        <input
            type="text"
            wire:model.defer="newMessage"
            wire:keydown.enter="sendMessage"
            class="flex-1 border rounded p-2"
            placeholder="Напишите сообщение..."
        />
        <button wire:click="sendMessage" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">
            Отправить
        </button>
    </div>
</div>

<script>
    // Автоскролл вниз при обновлении сообщений
    Livewire.hook('message.processed', (message, component) => {
        let chatBox = document.getElementById('chat-box');
        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>