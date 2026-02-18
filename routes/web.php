<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;



Route::view('/', 'pages.home')->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove') ;
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');


Route::view('/product', 'pages.product')->name('product');

Route::view('/aboute', 'pages.aboute')->name('aboute');
Route::view('/reviews', 'pages.reviews')->name('reviews');
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


Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
Route::get('/orders', [OrderController::class, 'store'])->name('order.success');


Route::get('/dashboard', function () {
    return redirect('/profile');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{page}', [ProfileController::class, 'index'])->name('profile.page');
   


    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
