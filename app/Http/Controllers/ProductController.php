<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    

    public function show(Product $product)
    {
        
        // // Подгружаем категории и изображения для продукта
        $product->load('categories', 'images', 'reviews.user', 'reviews.images');
        // // dd($product);

         $favoriteIds = auth()->check()
            ? auth()->user()->favoriteProducts()->pluck('products.id')->toArray()
            : [];
        $categoryIds = $product->categories->pluck('id');

        $similarProducts = Product::with(['images', 'categories'])
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product, $categoryIds) {
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                })
                ->orWhere('age_group', $product->age_group)
                ->orWhere('breed_size', $product->breed_size);
            })
            ->latest()
            ->limit(4)
            ->get();

        if ($similarProducts->count() < 4) {
            $extraProducts = Product::with(['images', 'categories'])
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $similarProducts->pluck('id'))
                ->latest()
                ->limit(4 - $similarProducts->count())
                ->get();

            $similarProducts = $similarProducts->merge($extraProducts);
        }

        return view('product.show', compact('product', 'favoriteIds', 'similarProducts'));
    }


     
}
