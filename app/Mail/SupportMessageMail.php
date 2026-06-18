<?php

namespace App\Mail;

use App\Models\SupportChat;
use App\Models\SupportMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public SupportChat $chat;
    public SupportMessage $supportMessage;
    public string $titleText;

    public function __construct(
        SupportChat $chat,
        SupportMessage $message,
        string $titleText
    ) {
        $this->chat = $chat;
        $this->supportMessage = $message;
        $this->titleText = $titleText;
    }

    public function build()
    {
        return $this
            ->subject($this->titleText)
            ->view('emails.support-message');
    }
}