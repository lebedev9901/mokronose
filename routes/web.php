<?php

use App\Filament\Pages\SupportChatMessage;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VkAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\VkController;
use Filament\Facades\Filament;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Socialite;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product');

Route::post('/cart/add-ajax/{product}', [CartController::class, 'addAjax'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count']);


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove') ;
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');


Route::view('/aboute', 'pages.aboute')->name('aboute');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::view('/pay', 'pages.pay')->name('pay');


Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('dashboard');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);


Route::get('/vk/redirect', [VkAuthController::class, 'redirect'])->name('vk.redirect');
Route::get('/vk/callback', [VkAuthController::class, 'callback'])->name('vk.callback');


Route::middleware(['auth'])->group(function (){

    

    // Страница выбора доставки и оплаты
    Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

    // Подтверждение оформления
    Route::post('/orders/checkout', [OrderController::class, 'confirm'])->name('order.confirm');

    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])
    ->name('product.reviews.store');
});

//  Route::post('/orders', [OrderController::class, 'store'])->name('order.store');


Route::get('/dashboard', function () {
    return redirect('/profile');
})->middleware(['auth'])->name('dashboard');

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

    Route::get('/profile/section/orders', [OrderController::class, 'index'])->name('profile.orders');
    Route::get('/chat/{id}', [SupportChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/send', [SupportChatController::class, 'send'])->name('chat.send');
Route::middleware('auth')->group(function () {

    Route::get('/profile/order/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
  
    Route::get('/profile/{page?}', [ProfileController::class, 'index'])->name('profile.page');

    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses', [AddressController::class, 'create'])->name('address.form');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])
    ->name('addresses.destroy');
    Route::post('/addresses/{id}', [AddressController::class, 'update'])
    ->name('addresses.update');
Route::post('/addresses/{id}/main', [AddressController::class, 'setMain']);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/save-contact', function (Request $request) {

        auth()->user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true]);
    });

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
});

require __DIR__.'/auth.php';
