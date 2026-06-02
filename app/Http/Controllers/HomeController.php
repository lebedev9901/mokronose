<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use App\Models\Review;
use App\Models\VkReview;
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

        $products = $query->take(6)->get();

        // fallback если пусто
        if ($products->isEmpty()) {
            $products = Product::latest()->take(9)->get();
        }

        $reviews = Review::with(['user', 'product'])
           ->latest()
            ->paginate(9);

        $vkReviews = VkReview::latest('vk_created_at')
            ->take(6)
            ->get();

        $news = News::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();


        return view('pages.home', compact('products', 'reviews', 'vkReviews', 'news'));
    }

}
