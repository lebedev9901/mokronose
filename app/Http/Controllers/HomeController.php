<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔍 поиск
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // ⭐ фильтр рейтинга
        $query->where('rating', '>', 4.5)
            ->orderBy('rating', 'desc');

        $products = $query->take(9)->get();

        // fallback если пусто
        if ($products->isEmpty()) {
            $products = Product::latest()->take(9)->get();
        }

        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->take(6)
            ->get();

        return view('pages.home', compact('products', 'reviews'));
    }

}
