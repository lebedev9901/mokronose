<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Product $product)
    {
        $sessionId = session()->getId();
        $userId = Auth::id();



             // Получаем или создаём корзину
        $cart = Cart::firstOrCreate(
            $userId ? ['user_id' => $userId] : ['session_id' => $sessionId],
            ['user_id' => $userId ?: null, 'session_id' => $userId ? null : $sessionId]
        );


        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        
        if($cartItem){
            $cartItem->increment('qty');
        }else{
            CartItem::create([
                'cart_id' => $cart->id,
                'user_id' => $userId ?: null,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $product->id,
                'qty' => 1,
            ]);
        }
        
        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function index()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $cart = Cart::where(function($q) use ($userId, $sessionId){
            if($userId){
                $q->where('user_id', $userId);
            }else{
                $q->where('session_id', $sessionId);
            }
        })->first();

        $items = $cart ? $cart->items()->with('product')->get() : collect();

        return view('pages.cart', compact('items', 'cart'));
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Товар удален из корзины');
    }

    public function update(Request $request, CartItem $item)
    {
        $qty = max(1, (int)$request->qty); // минимум 1
        $item->update(['qty' => $qty]);

        return back()->with('success', 'Количество обновлено');
    }

    public function clear()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $cart = Cart::where(function($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with('success', 'Корзина очищена');
    }

    public static function mergeGuestCart()
    {
        if(!Auth::check()) return;

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $guestCart = Cart::where('session_id', session()->getId())->first();

        if ($guestCart) {
            foreach ($guestCart->items as $item) {
                $existingItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('qty', $item->qty);
                } else {
                    $item->cart_id = $userCart->id;
                    $item->user_id = Auth::id();
                    $item->session_id = null;
                    $item->save();
                }
            }
            $guestCart->delete();
        }
    }

    public function addAjax(Product $product)
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $cart = Cart::firstOrCreate(
            $userId ? ['user_id' => $userId] : ['session_id' => $sessionId],
            ['user_id' => $userId ?: null, 'session_id' => $userId ? null : $sessionId],
        );

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if($cartItem ){
            $cartItem->increment('qty');
        }else{
            CartItem::create([
                'cart_id' => $cart->id,
                'user_id' => $userId ?: null,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $product->id,
                'qty' => 1
            ]);
        }

        $count = $cart->items()->sum('qty');

        return response()->json([
            'success' => true,
            'count' => $count 
        ]);

    }

    public function count()
{
    $sessionId = session()->getId();
    $userId = Auth::id();

    $cart = Cart::where(function($q) use ($userId, $sessionId){
        if($userId){
            $q->where('user_id', $userId);
        } else {
            $q->where('session_id', $sessionId);
        }
    })->first();

    $count = $cart ? $cart->items()->sum('qty') : 0;

    return response()->json(['count' => $count]);
}

}
