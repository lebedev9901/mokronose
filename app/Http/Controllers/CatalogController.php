<?php

namespace App\Http\Controllers;

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

        $products = $query->latest()->paginate(9)->withQueryString();

        return view('catalog.index', compact('products', 'categories'));
    }
}