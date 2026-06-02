<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('title')
            ->get();

        $query = Product::with(['images', 'categories.parent']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $category = Category::with('children')->find($request->category);

            if ($category) {
                $ids = collect([$category->id])
                    ->merge($category->children->pluck('id'))
                    ->toArray();

                $query->whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('categories.id', $ids);
                });
            }
        }

        $favoriteIds = auth()->check()
            ? auth()->user()->favoriteProducts()->pluck('products.id')->toArray()
            : [];

        $products = $query->latest()->paginate(9)->withQueryString();
            
        $sessionId = session()->getId();
        $userId = auth()->id();

        $cart = Cart::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->first();

        $cartQuantities = $cart
            ? $cart->items()->pluck('qty', 'product_id')
            : collect();

        $cartCount = $cartQuantities->sum();

        return view('catalog.index', compact(
            'products',
            'categories',
            'cartQuantities',
            'cartCount',
            'favoriteIds'
        ));
    }
}