<?php

use App\Http\Controllers\Auth\VkAuthController;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use App\Models\User;
use App\Services\VkMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

Route::get('/products', function () {
    return Product::query()
        ->where('is_active', true)
        ->with('images')
        ->latest()
        ->get()
        ->map(function ($product) {
            $image = $product->images->first();

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'rating' => $product->rating,
                'category_id' => $product->category_id,
                'image_url' => $image
                    ? url('/api/product-image/' . basename($image->image))
                    : null,
            ];
        });
});


Route::get('/product-image/{path}', function ($path) {
    $fullPath = 'products/' . $path;

    if (!Storage::disk('public')->exists($fullPath)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($fullPath);
    $mime = Storage::disk('public')->mimeType($fullPath);

    return Response::make($file, 200, [
        'Content-Type' => $mime,
        'Access-Control-Allow-Origin' => '*',
    ]);
});

Route::middleware('auth:sanctum')->get('/cart', function (Request $request) {
    $cart = Cart::firstOrCreate([
        'user_id' => $request->user()->id,
    ]);

    return $cart->items()
        ->with('product.images')
        ->get()
        ->map(function ($item) {
            $image = $item->product->images->first();

            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'title' => $item->product->title,
                'price' => $item->product->price,
                'image_url' => $image
                    ? url('/api/product-image/' . basename($image->image))
                    : null,
                'total' => $item->qty * $item->product->price,
            ];
        });
});

Route::middleware('auth:sanctum')->post('/cart/add', function (Request $request) {
    $request->validate([
        'product_id' => ['required', 'exists:products,id'],
        'qty' => ['nullable', 'integer', 'min:1'],
    ]);

    $cart = Cart::firstOrCreate([
        'user_id' => $request->user()->id,
    ]);

    $item = CartItem::firstOrCreate(
        [
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
        ],
        [
            'qty' => 0,
        ]
    );

    $item->increment('qty', $request->qty ?? 1);

    return response()->json([
        'success' => true,
        'cart_count' => $cart->items()->sum('qty'),
    ]);
});

Route::middleware('auth:sanctum')->post('/cart/remove', function (Request $request) {
    $data = $request->validate([
        'product_id' => ['required', 'exists:products,id'],
    ]);

    $cart = Cart::where('user_id', $request->user()->id)->first();

    if (!$cart) {
        return response()->json(['success' => true]);
    }

    $item = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $data['product_id'])
        ->first();

    if (!$item) {
        return response()->json(['success' => true]);
    }

    if ($item->qty > 1) {
        $item->decrement('qty');
    } else {
        $item->delete();
    }

    return response()->json(['success' => true]);
});



Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $data['email'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json([
            'message' => 'Неверный email или пароль',
        ], 401);
    }

    $token = $user->createToken('mobile')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user,
    ]);
});

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'id' => $user->id,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'middle_name' => $user->middle_name,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'avatar' => $user->avatar,
        'role' => $user->role,
    ]);
});

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'last_name' => ['required', 'string', 'max:255'],
        'first_name' => ['required', 'string', 'max:255'],
        'middle_name' => ['nullable', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::min(6)],
    ]);

    $user = User::create([
        'last_name' => $data['last_name'],
        'first_name' => $data['first_name'],
        'middle_name' => $data['middle_name'] ?? null,
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'email_verified_at' => now(),
    ]);

    $token = $user->createToken('mobile-app')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'middle_name' => $user->middle_name,
            'email' => $user->email,
        ],
    ]);
});

Route::middleware('auth:sanctum')->get('/addresses', function (Request $request) {
    return $request->user()
        ->addresses()
        ->latest()
        ->get();
});

Route::middleware('auth:sanctum')->post('/addresses', function (Request $request) {
    $data = $request->validate([
        'city' => ['required', 'string', 'max:255'],
        'street' => ['required', 'string', 'max:255'],
        'house' => ['required', 'string', 'max:50'],
        'apartment' => ['nullable', 'string', 'max:50'],
    ]);

    $address = $request->user()->addresses()->create([
        ...$data,
        'is_default' => false,
    ]);

    return response()->json($address);
});

Route::middleware('auth:sanctum')->delete('/addresses/{address}', function (
    Request $request,
    Address $address
) {
    if ($address->user_id !== $request->user()->id) {
        abort(403);
    }

    $address->delete();

    return response()->json([
        'success' => true,
    ]);
});

Route::middleware('auth:sanctum')->post('/checkout', function (
    Request $request,
    VkMessageService $vk
) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:50'],

        'delivery_method' => ['required', 'in:courier,pickup,cdek,post'],
        'payment_method' => ['required', 'in:cash,card,online'],

        'address_id' => ['required_if:delivery_method,courier', 'nullable', 'exists:addresses,id'],
        'pickup_point' => ['required_if:delivery_method,pickup', 'nullable', 'string'],
        'cdek_point' => ['required_if:delivery_method,cdek', 'nullable', 'string'],
        'post_address' => ['required_if:delivery_method,post', 'nullable', 'string'],
    ]);

    $user = $request->user();

    if ($data['delivery_method'] === 'courier') {
        $address = $user->addresses()
            ->where('id', $data['address_id'])
            ->first();

        if (!$address) {
            abort(403);
        }
    }

    $user->update([
        'first_name' => $data['name'],
        'phone' => $data['phone'],
    ]);

    $cart = Cart::where('user_id', $user->id)
        ->with('items.product')
        ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json([
            'message' => 'Корзина пуста',
        ], 422);
    }

    $order = DB::transaction(function () use ($cart, $user, $data) {
        $total = $cart->items->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

        $orderData = [
            'user_id' => $user->id,
            'total_price' => $total,
            'delivery_method' => $data['delivery_method'],
            'payment_method' => $data['payment_method'],
            'status' => 'new',
        ];

        switch ($data['delivery_method']) {
            case 'courier':
                $orderData['address_id'] = $data['address_id'];
                break;

            case 'pickup':
                $orderData['pickup_point'] = $data['pickup_point'];
                break;

            case 'cdek':
                $orderData['cdek_point'] = $data['cdek_point'];
                break;

            case 'post':
                $orderData['post_address'] = $data['post_address'];
                break;
        }

        $order = Order::create($orderData);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                'qty' => $item->qty,
            ]);
        }

        $chat = SupportChat::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'status' => 'open',
            'subject' => 'Заказ #' . $order->id,
        ]);

        SupportMessage::create([
            'user_id' => $user->id,
            'chat_id' => $chat->id,
            'sender_type' => 'system',
            'message' => 'Заказ создан и передан в поддержку',
        ]);

        $cart->items()->delete();

        return $order;
    });

    if ($user->vk_id) {
        $vk->sendToUser(
            $user->vk_id,
            "Здравствуйте, {$user->first_name}!\n\n" .
            "Ваш заказ №{$order->id} успешно оформлен и передан в поддержку.\n" .
            "Сумма заказа: {$order->total_price} ₽\n\n" .
            "Мы свяжемся с вами в ближайшее время."
        );
    }

    return response()->json([
        'success' => true,
        'order_id' => $order->id,
        'message' => 'Заказ оформлен',
    ]);
});

Route::get('/categories', function () {
    return Category::query()
        ->whereNull('parent_id')
        ->with('children')
        ->get();
});

Route::post('/auth/vk/mobile', [VkAuthController::class, 'mobileLogin']);
Route::get('/vk/mobile-callback', [VkAuthController::class, 'mobileCallback']);
Route::get('/vk/callback', [VkAuthController::class, 'callback']);