<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public Order $order;
    public string $titleText;
    public string $messageText;

    public function __construct(Order $order, string $titleText, string $messageText)
    {
        $this->order = $order;
        $this->titleText = $titleText;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this
            ->subject($this->titleText)
            ->view('emails.order-status');
    }
}
