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

    public static function mergeGuestCart(?string $oldSessionId = null): void
{
    if (!Auth::check()) {
        return;
    }

    $oldSessionId = $oldSessionId ?: session()->getId();

    $guestCart = Cart::where('session_id', $oldSessionId)
        ->whereNull('user_id')
        ->first();

    if (!$guestCart) {
        return;
    }

    $userCart = Cart::firstOrCreate(
        ['user_id' => Auth::id()],
        ['session_id' => null]
    );

    foreach ($guestCart->items as $item) {
        $existingItem = $userCart->items()
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
    private static function currentCart()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        if ($userId) {
            return Cart::firstOrCreate(
                ['user_id' => $userId],
                ['session_id' => null]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    public function ajaxAdd(Product $product)
{
    $cart = self::currentCart();

    $item = CartItem::firstOrCreate(
        [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ],
        [
            'user_id' => Auth::id(),
            'session_id' => Auth::check() ? null : session()->getId(),
            'qty' => 0,
        ]
    );

    $item->increment('qty');

    return response()->json([
        'ok' => true,
        'qty' => $item->fresh()->qty,
        'cart_count' => $cart->items()->sum('qty'),
    ]);
}

public function ajaxIncrease(Product $product)
{
    $cart = self::currentCart();

    $item = $cart->items()
        ->where('product_id', $product->id)
        ->firstOrFail();

    $item->increment('qty');

    return response()->json([
        'ok' => true,
        'qty' => $item->fresh()->qty,
        'cart_count' => $cart->items()->sum('qty'),
    ]);
}

public function ajaxDecrease(Product $product)
{
    $cart = self::currentCart();

    $item = $cart->items()
        ->where('product_id', $product->id)
        ->firstOrFail();

    if ($item->qty <= 1) {
        $item->delete();

        return response()->json([
            'ok' => true,
            'qty' => 0,
            'cart_count' => $cart->items()->sum('qty'),
        ]);
    }

    $item->decrement('qty');

    return response()->json([
        'ok' => true,
        'qty' => $item->fresh()->qty,
        'cart_count' => $cart->items()->sum('qty'),
    ]);
}

public function count()
{
    $cart = self::currentCart();

    return response()->json([
        'count' => $cart->items()->sum('qty'),
    ]);
}

}
