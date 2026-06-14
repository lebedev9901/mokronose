<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VkAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\SupportController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/catalog', [CatalogController::class, 'catalog'])->name('catalog');
Route::get('/catalog/product/{product}/quick', [CatalogController::class, 'quick'])
    ->name('catalog.product.quick');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product');

Route::view('/aboute', 'pages.aboute')->name('aboute');
Route::view('/pay', 'pages.pay')->name('pay');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('dashboard');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| VK Auth
|--------------------------------------------------------------------------
*/

Route::get('/vk/callback', [VkAuthController::class, 'callback'])->name('vk.callback');
Route::post('/vk/sdk-login', [VkAuthController::class, 'sdkLogin'])->name('vk.sdk-login');

Route::post('/vk/link', [VkAuthController::class, 'link'])
    ->middleware('auth')
    ->name('vk.link');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

Route::post('/cart/add/{product}', [CartController::class, 'ajaxAdd'])->name('cart.ajax.add');
Route::post('/cart/increase/{product}', [CartController::class, 'ajaxIncrease'])->name('cart.ajax.increase');
Route::post('/cart/decrease/{product}', [CartController::class, 'ajaxDecrease'])->name('cart.ajax.decrease');

Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

/*
|--------------------------------------------------------------------------
| Authenticated user routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard / Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return redirect('/profile');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/save-contact', function (Request $request) {
        auth()->user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true]);
    })->name('profile.save-contact');

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/orders/checkout', [OrderController::class, 'confirm'])->name('order.confirm');

    Route::get('/profile/order/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/profile/order/{order}/repeat', [OrderController::class, 'repeat'])->name('orders.repeat');

    /*
    |--------------------------------------------------------------------------
    | Addresses
    |--------------------------------------------------------------------------
    */

    Route::get('/addresses', [AddressController::class, 'create'])->name('address.form');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::post('/addresses/{id}/main', [AddressController::class, 'setMain'])
        ->name('addresses.main');

    Route::post('/checkout/address', [AddressController::class, 'storeAjax'])
        ->name('checkout.address.store');

    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */

    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])
        ->name('product.reviews.store');

    /*
    |--------------------------------------------------------------------------
    | Support
    |--------------------------------------------------------------------------
    */

    Route::get('/profile/support', [SupportController::class, 'index'])
        ->name('support.index');

    Route::get('/profile/support/create', [SupportController::class, 'create'])
        ->name('support.create');

    Route::post('/profile/support/store', [SupportController::class, 'store'])
        ->name('support.store');

    Route::get('/profile/support/{chat}', [SupportController::class, 'chat'])
        ->name('support.chat');

    Route::post('/profile/support/{chat}/send', [SupportController::class, 'send'])
        ->name('support.send');

    Route::get('/support/{chat}/messages', [SupportController::class, 'messages'])
        ->name('support.messages');

    Route::post('/support/{chat}/send-ajax', [SupportController::class, 'sendAjax'])
        ->name('support.send.ajax');

    /*
    |--------------------------------------------------------------------------
    | Old chat routes
    |--------------------------------------------------------------------------
    */

    Route::get('/chat/{id}', [SupportChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/send', [SupportChatController::class, 'send'])->name('chat.send');

    /*
    |--------------------------------------------------------------------------
    | Pets
    |--------------------------------------------------------------------------
    */

    Route::get('/profile/pet', function () {
        return view('profile.pet');
    })->name('pets.page');

    Route::get('/profile/pet/list', [PetController::class, 'index'])->name('pets.index');
    Route::post('/profile/pet', [PetController::class, 'store'])->name('pets.store');
    Route::put('/profile/pet/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/profile/pet/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

    /*
    |--------------------------------------------------------------------------
    | Favorites
    |--------------------------------------------------------------------------
    */

    Route::get('/profile/favorites', [FavoriteController::class, 'index'])
        ->name('favorites.index');

    Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');

    /*
    |--------------------------------------------------------------------------
    | Promocodes
    |--------------------------------------------------------------------------
    */

    Route::post('/cart/promocode/apply', [CartController::class, 'applyPromocode'])
        ->name('cart.promocode.apply');

    Route::post('/cart/promocode/remove', [CartController::class, 'removePromocode'])
        ->name('cart.promocode.remove');

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications/count', [NotificationController::class, 'count'])
        ->name('notifications.count');

    Route::get('/notifications/list', [NotificationController::class, 'list'])
        ->name('notifications.list');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
        ->name('notifications.readAll');
    
    Route::post('/notifications/mark-by-data', [NotificationController::class, 'markByData'])
        ->name('notifications.markByData');

    /*
    |--------------------------------------------------------------------------
    | Profile dynamic page - keep last
    |--------------------------------------------------------------------------
    */

    Route::get('/profile/{page?}', [ProfileController::class, 'index'])
        ->name('profile.page');
});

/*
|--------------------------------------------------------------------------
| Email verification
|--------------------------------------------------------------------------
*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Письмо отправлено!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__ . '/auth.php';