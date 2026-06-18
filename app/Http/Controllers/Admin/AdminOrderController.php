<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewOrderMail;
use App\Mail\OrderStatusMail;
use App\Mail\SupportMessageMail;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            

            $message = $chat->message()->create([
                'user_id' => auth()->id(),
                'message' => $request->message,
                'sender_type' => auth()->user()->role === 'support'
                    ? 'support'
                    : 'system',
            ]);

         
            
          

            try {
                if ($chat->user && $chat->user->email) {
                    Mail::to($chat->user->email)->send(
                        new SupportMessageMail(
                            $chat,
                            $message,
                            'Новое сообщение от поддержки'
                        )
                    );
                }
            } catch (\Throwable $e) {
                Log::error('Ошибка отправки email поддержки из заказа', [
                    'chat_id' => $chat->id,
                    'order_id' => $order->id,
                    'user_id' => $chat->user_id,
                    'error' => $e->getMessage(),
                ]);
            }

            return response()->json([
                'success' => true,
            ]);
    }

    public function confirm($id)
    {
        $order = Order::with('user')->findOrFail($id);

        $order->update([
            'status' => 'confirmed',
        ]);

        if ($order->user) {
            $order->user->notify(
                new OrderStatusNotification(
                    $order,
                    'Заказ подтверждён',
                    'Ваш заказ №' . $order->id . ' подтверждён'
                )
            );
        }
        $order->refresh();
        $order->load('user', 'items.product', 'address');

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(
                    new OrderStatusMail(
                        $order,
                        'Статус заказа изменён',
                        'Статус вашего заказа №' . $order->id . ' изменён на: ' . $order->status_label
                    )
                );
            }
        } catch (\Throwable $e) {
            Log::error('Ошибка отправки email при смене статуса заказа', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'error' => $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Заказ подтверждён');
    }

    public function messages(Order $order)
    {
        $order->load('chat.message.user');

        if (!$order->chat) {
            return response()->json([
                'html' => '<div class="admin-chat-empty">Сообщений пока нет</div>',
                'count' => 0,
            ]);
        }

        

        return response()->json([
            'html' => view('admin.orders.partials.messages', [
                'messages' => $order->chat->message,
            ])->render(),
            'count' => $order->chat->message->count(),
        ]);

        
    }
}
