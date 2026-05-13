<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        // 📦 товары всего
        $productsCount = Product::count();

        // 📦 товары в наличии
        $productsInStock = Product::where('stock', '>', 0)->count();

        // 📦 пользователи
        $usersCount = User::count();

        // 📦 заказы
        $ordersCount = Order::count();

        // 💰 сумма продаж (если есть price + qty или total)
        $totalSales = Order::where('status', 'confirmed')
            ->sum('total_price');

        return view('admin.dashboard', compact(
            'productsCount',
            'productsInStock',
            'usersCount',
            'ordersCount',
            'totalSales'
        ));
    }
}
