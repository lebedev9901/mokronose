<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public static function currentCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => null]
            );
        }

        return Cart::firstOrCreate(
            [
                'session_id' => session()->getId(),
                'user_id' => null,
            ]
        );
    }

    public function index()
    {
        $cart = self::currentCart();

        $items = $cart->items()
            ->with('product.images')
            ->get();

        $firstPet = auth()->check()
            ? auth()->user()->pets()->first()
            : null;

        $recommendedProducts = Product::with(['images', 'categories']);

        if ($firstPet) {
            $recommendedProducts->where(function ($query) use ($firstPet) {
                if (!empty($firstPet->age_group)) {
                    $query->orWhereJsonContains('age_group', $firstPet->age_group);
                }

                if (!empty($firstPet->breed_size)) {
                    $query->orWhereJsonContains('breed_size', $firstPet->breed_size);
                }

                $query->orWhereNull('age_group')
                    ->orWhereJsonLength('age_group', 0)
                    ->orWhereNull('breed_size')
                    ->orWhereJsonLength('breed_size', 0);
            });
        }

        $recommendedProducts = $recommendedProducts
            ->latest()
            ->take(4)
            ->get();

        return view('pages.cart', compact('items', 'cart', 'recommendedProducts'));
    }

    public function add(Product $product)
    {
        $cart = self::currentCart();

        $item = CartItem::firstOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ],
            [
                'qty' => 0,
            ]
        );

        $item->increment('qty');

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function addById(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ]);

        $cart = self::currentCart();

        $item = CartItem::firstOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $data['product_id'],
            ],
            [
                'qty' => 0,
            ]
        );

        $item->increment('qty', $data['quantity'] ?? 1);
        $item->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'qty' => $item->qty,
                'cart_count' => $cart->items()->sum('qty'),
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
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
                'qty' => 0,
            ]
        );

        $item->increment('qty');
        $item->refresh();

        return response()->json([
            'ok' => true,
            'qty' => $item->qty,
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
        $item->refresh();

        return response()->json([
            'ok' => true,
            'qty' => $item->qty,
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
        $item->refresh();

        return response()->json([
            'ok' => true,
            'qty' => $item->qty,
            'cart_count' => $cart->items()->sum('qty'),
        ]);
    }

    public function update(Request $request, CartItem $item)
    {
        $qty = max(1, (int) $request->qty);

        $item->update([
            'qty' => $qty,
        ]);

        $item->refresh();

        $cart = $item->cart;
        $cart->load('items.product');

        $total = $cart->items->sum(function ($cartItem) {
            return $cartItem->qty * $cartItem->product->price;
        });

        $count = $cart->items->sum('qty');

        if ($request->expectsJson()) {
            $discount = session('promocode.discount', 0);
            $payTotal = max($total - $discount, 0);

            return response()->json([
                'qty' => $item->qty,
                'minus_disabled' => $item->qty <= 1,
                'next_minus_qty' => $item->qty - 1,
                'next_plus_qty' => $item->qty + 1,
                'item_total' => number_format($item->qty * $item->product->price, 2, '.', ' ') . ' ₽',
                'total' => number_format($total, 2, '.', ' ') . ' ₽',
                'pay_total' => number_format($payTotal, 2, '.', ' ') . ' ₽',
                'count' => $count,
            ]);
        }

        return back()->with('success', 'Количество обновлено');
    }

    public function remove(CartItem $item)
    {
        $item->delete();

        return back()->with('success', 'Товар удален из корзины');
    }

    public function clear()
    {
        $cart = self::currentCart();

        $cart->items()->delete();

        return back()->with('success', 'Корзина очищена');
    }

    public function count()
    {
        $cart = self::currentCart();

        return response()->json([
            'count' => $cart->items()->sum('qty'),
        ]);
    }

    public static function mergeGuestCartById(?int $guestCartId): void
    {
        if (!Auth::check() || !$guestCartId) {
            return;
        }

        $guestCart = Cart::with('items')->find($guestCartId);

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
                ]);
            }
        }

        if ($guestCart->id !== $userCart->id) {
            $guestCart->delete();
        }
    }

    public static function mergeGuestCart(?string $oldSessionId = null): void
    {
        if (!Auth::check()) {
            return;
        }

        $guestCart = Cart::where('session_id', $oldSessionId ?: session()->getId())
            ->whereNull('user_id')
            ->first();

        if (!$guestCart) {
            return;
        }

        self::mergeGuestCartById($guestCart->id);
    }

    public static function mergeGuestCartBeforeLogin(?int $guestCartId, int $userId): void
    {
        if (!$guestCartId) {
            return;
        }

        $guestCart = Cart::with('items')->find($guestCartId);

        if (!$guestCart) {
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
                ]);
            }
        }

        if ($guestCart->id !== $userCart->id) {
            $guestCart->delete();
        }
    }

    public function applyPromocode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $cart = self::currentCart();
        $cartTotal = (float) $cart->total_price;

        $promocode = Promocode::where('code', strtoupper(trim($request->code)))->first();

        if (!$promocode) {
            return back()->with('promocode_error', 'Промокод не найден');
        }

        if (!$promocode->isAvailable($cartTotal)) {
            return back()->with('promocode_error', 'Промокод недоступен или истёк');
        }

        if (auth()->check() && auth()->user()->promocode_used_at) {
            return back()->with('promocode_error', 'Вы уже использовали промокод ранее.');
        }

        $discount = $promocode->calculateDiscount($cartTotal);

        session([
            'promocode' => [
                'id' => $promocode->id,
                'code' => $promocode->code,
                'discount' => $discount,
            ],
        ]);

        return back()->with('success', 'Промокод применён');
    }

    public function removePromocode()
    {
        session()->forget('promocode');

        return back()->with('success', 'Промокод удалён');
    }
}