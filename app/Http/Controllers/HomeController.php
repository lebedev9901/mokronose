<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use App\Models\Review;
use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $query->where('rating', '>', 4.5)
            ->orderBy('rating', 'desc');

        $products = $query->take(3)->get();

        if ($products->isEmpty()) {
            $products = Product::with('images')->latest()->take(3)->get();
        }

        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->paginate(3);

        $cart = Cart::with('items')
            ->when(auth()->check(), function ($query) {
                $query->where('user_id', auth()->id());
            }, function ($query) use ($request) {
                $query->where('session_id', $request->session()->getId());
            })
            ->first();

        $cartQuantities = $cart
            ? $cart->items->pluck('qty', 'product_id')
            : collect();

        $cartCount = $cartQuantities->sum();

        $news = News::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('pages.home', compact(
            'products',
            'reviews',
            'news',
            'cartQuantities',
            'cartCount'
        ));
    }
}