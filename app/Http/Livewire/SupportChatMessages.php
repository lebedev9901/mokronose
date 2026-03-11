<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SupportChat;
use Illuminate\Support\Facades\Auth;

class SupportChatMessages extends Component
{
    public $chat;
    public $message = '';

    public function send()
    {
        if (!$this->message) return;

        $this->chat->messages()->create([
            'message' => $this->message,
            'user_id' => Auth::id(),
            'sender_type' => 'support',
        ]);

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.support-chat-messages', [
            'messages' => $this->chat->messages()->latest()->get()
        ]);
    }
}