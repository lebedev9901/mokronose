<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
   private static function currentCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => null]
            );
        }

        $sessionId = session()->getId();

        $cart = Cart::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'session_id' => $sessionId,
                'user_id' => null,
            ]);
        }

        return $cart;
    }

    public function add(Product $product)
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $cart = self::currentCart();

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('qty');
        } else {
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


        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId)->whereNull('user_id');
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
        $qty = max(1, (int) $request->qty);

        $item->update(['qty' => $qty]);

        return back()->with('success', 'Количество обновлено');
    }

    public function clear()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId)->whereNull('user_id');
            }
        })->first();

        Log::info('CART CLEAR', [
            'auth' => Auth::check(),
            'user_id' => $userId,
            'session_id' => $sessionId,
            'cart_exists' => (bool) $cart,
            'cart_id' => $cart?->id,
        ]);

        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with('success', 'Корзина очищена');
    }

    public static function mergeGuestCart(?string $oldSessionId = null): void
    {
        if (!Auth::check()) {
            Log::info('MERGE STOP: NOT AUTH');
            return;
        }

        $searchSessionId = $oldSessionId ?: session()->getId();

        $guestCart = Cart::where('session_id', $searchSessionId)->first();

        if (!$guestCart) {
            $guestCartId = CartItem::where('session_id', $searchSessionId)->value('cart_id');

            if ($guestCartId) {
                $guestCart = Cart::find($guestCartId);
            }
        }

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => null]
        );

        foreach ($guestCart->items as $item) {
            Log::info('MERGING ITEM', [
                'item_id' => $item->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
            ]);

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

        if ($guestCart->id !== $userCart->id) {
            $guestCart->delete();
        }

    }

    public static function mergeGuestCartById(?int $guestCartId): void
    {

        if (!Auth::check() || !$guestCartId) {
            return;
        }

        $guestCart = Cart::with('items')->find($guestCartId);

        Log::info('MERGE BY ID FOUND', [
            'guest_cart_exists' => (bool) $guestCart,
            'guest_cart_id' => $guestCart?->id,
            'items_count' => $guestCart ? $guestCart->items->count() : 0,
        ]);

        if (!$guestCart) {
            return;
        }

        $guestCart->update([
            'user_id' => Auth::id(),
            'session_id' => null,
        ]);

        CartItem::where('cart_id', $guestCart->id)->update([
            'user_id' => Auth::id(),
            'session_id' => null,
        ]);

    }

    public static function mergeGuestCartBeforeLogin(?int $guestCartId, int $userId): void
    {
        if (! $guestCartId) {
            return;
        }

        $guestCart = Cart::with('items')->find($guestCartId);

        if (! $guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            ['user_id' => $userId],
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
                    'user_id' => $userId,
                    'session_id' => null,
                ]);
            }
        }

        if ($guestCart->id !== $userCart->id) {
            $guestCart->delete();
        }
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
