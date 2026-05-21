<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use App\Services\VkMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function checkout()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->whereHas('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function confirm(Request $request, VkMessageService $vk)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'delivery_method' => 'required',
            'payment_method' => 'required',

            'address_id' => 'required_if:delivery_method,courier|exists:addresses,id',
            'pickup_point' => 'required_if:delivery_method,pickup',
            'cdek_point' => 'required_if:delivery_method,cdek',
            'post_address' => 'required_if:delivery_method,post',
        ]);

        if ($request->delivery_method === 'courier') {
            $address = auth()->user()
                ->addresses()
                ->where('id', $request->address_id)
                ->first();

            if (!$address) {
                abort(403);
            }
        }

        auth()->user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->whereHas('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $order = DB::transaction(function () use ($cartItems, $request) {
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

            $orderData = [
                'user_id' => auth()->id(),
                'total_price' => $total,
                'delivery_method' => $request->delivery_method,
                'payment_method' => $request->payment_method,
                'status' => 'new',
            ];

            switch ($request->delivery_method) {
                case 'courier':
                    $orderData['address_id'] = $request->address_id;
                    break;

                case 'pickup':
                    $orderData['pickup_point'] = $request->pickup_point;
                    break;

                case 'cdek':
                    $orderData['cdek_point'] = $request->cdek_point;
                    break;

                case 'post':
                    $orderData['post_address'] = $request->post_address;
                    break;
            }

            $order = Order::create($orderData);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'qty' => $item->qty,
                ]);
            }

            $chat = SupportChat::create([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'status' => 'open',
                'subject' => 'Заказ #' . $order->id,
            ]);

            SupportMessage::create([
                'user_id' => auth()->id(),
                'chat_id' => $chat->id,
                'sender_type' => 'system',
                'message' => 'Заказ создан и передан в поддержку',
            ]);

            CartItem::where('user_id', auth()->id())->delete();

            return $order;
        });

        $user = auth()->user();

        if ($user->vk_id) {
            $vk->sendToUser(
                $user->vk_id,
                "Здравствуйте, {$user->first_name}!\n\n" .
                "Ваш заказ №{$order->id} успешно оформлен и передан в поддержку.\n" .
                "Сумма заказа: {$order->total_price} ₽\n\n" .
                "Мы свяжемся с вами в ближайшее время."
            );
        }

        return redirect()->route('order.confirm')->with('success', 'Заказ оформлен');
    }

    public function success()
    {
        return view('orders.confirm');
    }

    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('chat')
            ->latest()
            ->get();

        return view('profile.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('chat.message', 'items.product.images', 'address');

        return view('profile.orders.show', compact('order'));
    }
}