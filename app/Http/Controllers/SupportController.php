<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
   public function confirmOrder(Order $order) {
        $order->update(['status' => 'confirmed']);
        SupportMessage::create([
            'chat_id' => $order->chat->id,
            'sender_type' => 'support',
            'message' => 'Заказ подтверждён поддержкой',
        ]);
    }

}
