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
        return view('product.show', compact('product'));
    }


     
}
