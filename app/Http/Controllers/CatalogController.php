<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('categories');

        if($request->category){
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $products = $query->latest()->paginate(9);

        // return view('home');
        return view('catalog.index', compact('products', 'categories'));
    }
}
