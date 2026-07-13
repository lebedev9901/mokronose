<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promocode;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Services\VkMessageService;
use App\Services\YooKassaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('product')
            ->whereHas('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $total = $cartItems->sum(fn ($item) => $item->product->price * $item->qty);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function confirm(Request $request, VkMessageService $vk, YooKassaService $yooKassa)
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

        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with('product')
            ->whereHas('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $order = DB::transaction(function () use ($cartItems, $request, $cart) {
            $totalBeforeDiscount = $cartItems->sum(fn ($item) => $item->product->price * $item->qty);

            $promocode = session('promocode');
            $discountAmount = 0;

            if ($promocode) {
                $discountAmount = (float) ($promocode['discount'] ?? 0);
            }

            if (session('promocode') && auth()->check()) {
                auth()->user()->update([
                    'promocode_used_at' => now(),
                ]);
            }

            if (session('promocode.id')) {
                Promocode::where('id', session('promocode.id'))->increment('used_count');
            }

            $totalAfterDiscount = max($totalBeforeDiscount - $discountAmount, 0);

            $orderData = [
                'user_id' => auth()->id(),
                'promocode_id' => $promocode['id'] ?? null,
                'promocode_code' => $promocode['code'] ?? null,
                'total_price' => $totalAfterDiscount,
                'total_before_discount' => $totalBeforeDiscount,
                'discount_amount' => $discountAmount,
                'total_after_discount' => $totalAfterDiscount,
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

            User::where('role', 'admin')->get()->each(function ($admin) use ($order) {
                $admin->notify(
                    new NewOrderNotification($order)
                );
            });

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

            CartItem::where('cart_id', $cart->id)->delete();

            session()->forget('promocode');
            
            return $order;
        });

        $user = auth()->user();

        try {
            if ($user->vk_id) {
                $vk->sendToUser(
                    $user->vk_id,
                    "Здравствуйте, {$user->first_name}!\n\n" .
                    "Ваш заказ №{$order->id} успешно оформлен и передан в поддержку.\n" .
                    "Сумма заказа: {$order->total_after_discount} ₽\n\n" .
                    "Мы свяжемся с вами в ближайшее время."
                );
            }
        } catch (\Throwable $e) {
            Log::error('Ошибка отправки VK уведомления о заказе', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->queue(
                    new NewOrderMail($order)
                );
            }
        } catch (\Throwable $e) {
            Log::error('Ошибка отправки email после оформления заказа', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'error' => $e->getMessage(),
            ]);
        }
        if ($order->payment_method === 'online') {
            return redirect()->away(
                $yooKassa->getConfirmationUrl($order)
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
            ->paginate(9);

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

    public function repeat(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.product');

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        foreach ($order->items as $item) {
            if (!$item->product) {
                continue;
            }

            $cartItem = CartItem::firstOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $item->product_id,
                ],
                [
                    'user_id' => auth()->id(),
                    'qty' => 0,
                ]
            );

            $cartItem->increment('qty', $item->qty);
        }

        return redirect()
            ->route('cart')
            ->with('success', 'Товары из заказа добавлены в корзину');
    }
}