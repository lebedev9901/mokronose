<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    


    public function create ()
    {
        return view('orders.create');
    }

    public function checkout()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->whereHas('product')
            ->get();

        if($cartItems->isEmpty()){
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

        return view('orders.checkout', compact('cartItems', 'total'));
    }


    public function confirm(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required',
            'payment_method'  => 'required',
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if($cartItems->isEmpty()){
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        DB::transaction(function () use ($cartItems, $request)
        {

        

            $total = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

            // 1. order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'delivery_method' => $request->delivery_method,
                'payment_method' => $request->payment_method,
                'status' => 'new',
            ]);

            // 2. order_items
            foreach($cartItems as $item){
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
            ]);

            SupportMessage::create([
                'user_id' => auth()->id(),
                'chat_id' => $chat->id,
                'sender_type' => 'system',
                'message' => 'Заказ создан и передан в поддержку',
            ]);

            // 3. очистка корзины в БД
            CartItem::where('user_id', auth()->id())->delete();
        });
        return redirect()->route('order.confirm')->with('success', 'Заказ оформлен');
    }
    
    public function success()
    {
        return view('orders.confirm');
    }

      public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('chat') // ВАЖНО
            ->latest()
            ->get();

        return view('profile.orders', compact('orders'));
    }
}
