<?php

use App\Filament\Pages\SupportChatMessage;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\auth\VkAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\SupportController;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

Route::get('/admin/support-chat/{chatId}', SupportChatMessage::class)->name('livewire.support-chat-messages');



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product');
// Route::post('/cart/add/{product}', [CartController::class, 'add'])
    // ->name('cart.add');
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

// Route::prefix('admin')->group(function () {
//     Route::view('/', 'admin.dashboard')->name('admin.dashboard');
//     Route::view('/categories', 'admin.categories')->name('admin.categories');
//     Route::view('/products', 'admin.products')->name('admin.products');
// });
Route::get('/auth/vk', [VkAuthController::class, 'redirect']);
Route::get('/auth/vk/callback', [VkAuthController::class, 'callback']);
use Laravel\Socialite\Facades\Socialite;

Route::get('/debug-vk', function () {
    dd(Socialite::driver('vkontakte'));
});
Route::middleware(['auth'])->group(function (){

    

    // Страница выбора доставки и оплаты
    Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

    // Подтверждение оформления
    Route::post('/orders/checkout', [OrderController::class, 'confirm'])->name('order.confirm');


});

//  Route::post('/orders', [OrderController::class, 'store'])->name('order.store');


Route::get('/dashboard', function () {
    return redirect('/profile');
})->middleware(['auth'])->name('dashboard');

    Route::get('/profile/section/orders', [OrderController::class, 'index'])->name('profile.orders');
    Route::get('/chat/{id}', [SupportChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/send', [SupportChatController::class, 'send'])->name('chat.send');
Route::middleware('auth')->group(function () {

    Route::get('/profile/order/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
  
    Route::get('/profile/{page?}', [ProfileController::class, 'index'])->name('profile.page');



    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
