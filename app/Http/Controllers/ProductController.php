<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    

    public function show(Product $product)
{
    $product->load('categories', 'images', 'reviews.user', 'reviews.images');

    $favoriteIds = auth()->check()
        ? auth()->user()->favoriteProducts()->pluck('products.id')->toArray()
        : [];

    $categoryIds = $product->categories->pluck('id')->toArray();

    $ageGroups = is_array($product->age_group)
        ? $product->age_group
        : (json_decode($product->age_group, true) ?: []);

    $breedSizes = is_array($product->breed_size)
        ? $product->breed_size
        : (json_decode($product->breed_size, true) ?: []);

    $similarProducts = Product::with(['images', 'categories'])
        ->where('id', '!=', $product->id)
        ->where(function ($query) use ($categoryIds, $ageGroups, $breedSizes) {

            if (!empty($categoryIds)) {
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }

            foreach ($ageGroups as $age) {
                $query->orWhereJsonContains('age_group', $age);
            }

            foreach ($breedSizes as $breed) {
                $query->orWhereJsonContains('breed_size', $breed);
            }

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

    return view('product.show', compact(
        'product',
        'favoriteIds',
        'similarProducts',
        'ageGroups',
        'breedSizes'
    ));
}


     
}
