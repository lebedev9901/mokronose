<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
         $reviews = Review::with(['user', 'product'])
            ->latest()->paginate(9);
        return view('pages.reviews', compact('reviews'));
    }




    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'text' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'text.min' => 'Отзыв должен быть не короче 3 символов.',
            'text.required' => 'Напишите текст отзыва.',
        ]);

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $data['rating'],
            'text' => $data['text'],
        ]);

        $product->update([
            'rating' => round($product->reviews()->avg('rating'), 1),
        ]);

        return back()->with('success', 'Отзыв добавлен');
    }
}
