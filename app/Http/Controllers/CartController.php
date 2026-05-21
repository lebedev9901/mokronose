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
        if (!Auth::check()) {
            return;
        }

        $sessionId = session()->getId();

        $userCart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $guestCart = Cart::where('session_id', $sessionId)->first();

        if (!$guestCart) {
            return;
        }

        foreach ($guestCart->items as $item) {
            $existingItem = CartItem::where('cart_id', $userCart->id)
                ->where('product_id', $item->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->increment('qty', $item->qty);
                $item->delete();
            } else {
                $item->update([
                    'cart_id' => $userCart->id,
                    'user_id' => Auth::id(),
                    'session_id' => null,
                ]);
            }
        }

        $guestCart->delete();
    }

    public function ajaxAdd(Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $item = CartItem::firstOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ],
            [
                'user_id' => auth()->id(),
                'qty' => 0,
            ]
        );

        $item->increment('qty');

        return response()->json([
            'ok' => true,
            'qty' => $item->fresh()->qty,
            'cart_count' => CartItem::where('cart_id', $cart->id)->sum('qty'),
        ]);
    }

    public function ajaxIncrease(Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        $item->increment('qty');

        return response()->json([
            'ok' => true,
            'qty' => $item->fresh()->qty,
            'cart_count' => CartItem::where('cart_id', $cart->id)->sum('qty'),
        ]);
    } 

   public function ajaxDecrease(Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        if ($item->qty <= 1) {
            $item->delete();

            return response()->json([
                'ok' => true,
                'qty' => 0,
                'cart_count' => CartItem::where('cart_id', $cart->id)->sum('qty'),
            ]);
        }

        $item->decrement('qty');

        return response()->json([
            'ok' => true,
            'qty' => $item->fresh()->qty,
            'cart_count' => CartItem::where('cart_id', $cart->id)->sum('qty'),
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
