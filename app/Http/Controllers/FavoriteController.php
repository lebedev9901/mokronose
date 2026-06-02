<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
  

    public function toggle(Product $product)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'success' => true,
                'is_favorite' => false,
            ]);
        }

        Favorite::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return response()->json([
            'success' => true,
            'is_favorite' => true,
        ]);
    }
}
