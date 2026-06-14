<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSupportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin'])->group(function () {
  

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');

    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('admin.products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('admin.products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('admin.products.destroy');

    Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])
        ->name('admin.products.image.delete');

    Route::post('/products/images/{image}/preview', [ProductController::class, 'setPreview'])
        ->name('admin.products.image.preview');



    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('admin.categories');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('admin.categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('admin.categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('admin.categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('admin.categories.destroy');

        Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users');

    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');

        Route::get('/orders', [AdminOrderController::class, 'index'])
    ->name('admin.orders');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');

    Route::post('/orders/{order}/message', [AdminOrderController::class, 'sendMessage'])
        ->name('admin.orders.message');
Route::post('/orders/{id}/confirm', [AdminOrderController::class, 'confirm'])
        ->name('admin.orders.confirm');

    Route::get('/support', [AdminSupportController::class, 'index'])->name('admin.support');

        Route::get('/support/{chat}', [AdminSupportController::class, 'chat'])->name('admin.support.chat');

        Route::post( '/support/{chat}/send', [AdminSupportController::class, 'send'])->name('admin.support.send');

        Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');


        Route::get('/news', [NewsController::class, 'index'])
    ->name('admin.news');

Route::get('/news/create', [NewsController::class, 'create'])
    ->name('admin.news.create');

Route::post('/news', [NewsController::class, 'store'])
    ->name('admin.news.store');

Route::get('/news/{news}/edit', [NewsController::class, 'edit'])
    ->name('admin.news.edit');

Route::put('/news/{news}', [NewsController::class, 'update'])
    ->name('admin.news.update');

Route::delete('/news/{news}', [NewsController::class, 'destroy'])
    ->name('admin.news.destroy');
    Route::resource('/promocodes', PromocodeController::class)
    ->names('admin.promocodes');
    Route::get('/orders/{order}/messages', [AdminOrderController::class, 'messages'])
    ->name('admin.orders.messages');
});