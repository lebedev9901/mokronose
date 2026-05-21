<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
         $reviews = Review::with(['user', 'product' ,'images'])
            ->latest()->paginate(9);
        return view('pages.reviews', compact('reviews'));
    }




    public function store(Request $request, Product $product)
{
    $data = $request->validate([
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
        'text' => ['required', 'string', 'min:3', 'max:1000'],
        'images' => ['nullable', 'array'],
        'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
    ], [
        'text.min' => 'Отзыв должен быть не короче 3 символов.',
        'text.required' => 'Напишите текст отзыва.',
        'images.*.image' => 'Можно загружать только изображения.',
        'images.*.max' => 'Фото не должно быть больше 5 МБ.',
    ]);

    $review = $product->reviews()->create([
        'user_id' => auth()->id(),
        'rating' => $data['rating'],
        'text' => $data['text'],
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('reviews', 'public');

            ReviewImage::create([
                'review_id' => $review->id,
                'path' => $path,
            ]);
        }
    }

    $product->update([
        'rating' => round($product->reviews()->avg('rating'), 1),
    ]);

    return back()->with('success', 'Отзыв добавлен');
}
}
