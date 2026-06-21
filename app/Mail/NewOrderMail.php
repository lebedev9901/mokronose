<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable 
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items.product', 'address');
    }

    public function build()
    {
        return $this
            ->subject('Ваш заказ №' . $this->order->id . ' оформлен')
            ->view('emails.new-order');
    }
}