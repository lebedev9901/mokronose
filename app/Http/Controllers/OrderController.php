<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
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

    public function store()
    {

        $userId = Auth::id();

        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();

        if($cartItems->isEmpty())
        {
            return redirect()->back()->with('error', 'Корзина пуста');
        }

        DB::transaction(function() use($cartItems, $userId){

            $order = Order::create([
                'user_id' => $userId,
                'status' => 'new',
                'total_price' => $cartItems->sum(fn($item) => $item->product->price * $item->qty),
            ]);
            
            foreach($cartItems as $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' =>$item->product_id,
                    'price' => $item->product->price,
                    'qty' => $item->qty,
                ]);

            }

            Cart::where('user_id', $userId)->delete();
        });
        return redirect()->route('order.success');
    }
}
