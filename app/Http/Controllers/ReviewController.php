<?php

namespace App\Http\Controllers;

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
}
