<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->get();

            $newOrders = Order::where('status', 'new')->count();

        return view('admin.orders.index', compact('orders', 'newOrders'));
    }

    public function show(Order $order)
    {
        $order->load([
            'user',
            'items.product',
            'chat.message.user'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    public function sendMessage(Request $request, Order $order)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $chat = $order->chat;

        if (!$chat) {

            $chat = $order->chat()->create([
                'user_id' => $order->user_id,
            ]);
        }

        $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => auth()->user()->role === 'support'
                ? 'support'
                : 'system',
        ]);

        return back();
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'confirmed';
        $order->save();

        return back()->with('success', 'Заказ подтверждён');
    }
}
