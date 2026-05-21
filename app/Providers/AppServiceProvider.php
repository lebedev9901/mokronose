<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{

    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('*', function ($view) {
        $cartCount = 0;

        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();

            if ($cart) {
                $cartCount = CartItem::where('cart_id', $cart->id)->sum('qty');
            }
        }

        $view->with('cartCount', $cartCount);
    });
    }
}
