<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function catalog(Request $request)
    {
        $categories = Category::with([
                'children' => function ($query) {
                    $query->withCount('products');
                },
            ])
            ->withCount('products')
            ->whereNull('parent_id')
            ->get();

        $pets = auth()->check()
            ? auth()->user()->pets()->get()
            : collect();

        $query = Product::with(['images', 'categories']);
        if ($request->filled('pet_id') && auth()->check()) {
                $pet = auth()->user()
                    ->pets()
                    ->find($request->pet_id);

                if ($pet) {
                    if ($pet->age_group) {
                        $request->merge([
                            'age_group' => [$pet->age_group],
                        ]);
                    }

                    if ($pet->breed_size) {
                        $request->merge([
                            'breed_size' => [$pet->breed_size],
                        ]);
                    }
                }
            }

        if ($request->filled('category')) {
            $categoryId = (int) $request->category;

            $category = Category::with('children')->find($categoryId);

            if ($category) {
                $ids = [$category->id];

                if ($category->children->isNotEmpty()) {
                    $ids = array_merge(
                        $ids,
                        $category->children->pluck('id')->toArray()
                    );
                }

                $query->whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('categories.id', $ids);
                });
            }
        }

        if ($request->filled('price_from')) {
            $query->where('price', '>=', (float) $request->price_from);
        }

        if ($request->filled('price_to')) {
            $query->where('price', '<=', (float) $request->price_to);
        }

        if ($request->filled('age_group')) {
    $ages = (array) $request->age_group;

    $query->where(function ($q) use ($ages) {
        foreach ($ages as $age) {
            $q->orWhereJsonContains('age_group', $age);
        }

        $q->orWhereNull('age_group', 'all')
        ->orWhereNull('age_group')
            ->orWhereJsonLength('age_group', 0);
    });
}

if ($request->filled('breed_size')) {
    $sizes = (array) $request->breed_size;

    $query->where(function ($q) use ($sizes) {
        foreach ($sizes as $size) {
            $q->orWhereJsonContains('breed_size', $size);
        }

        $q->orWhereNull('breed_size', 'all')
        ->orWhereNull('breed_size')
            ->orWhereJsonLength('breed_size', 0);
    });
}

        match ($request->get('sort')) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'old' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $products = $query->paginate(12)->withQueryString();

        $cartQuantities = [];

        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();

            if ($cart) {
                $cartQuantities = $cart->items()
                    ->pluck('qty', 'product_id')
                    ->toArray();
            }
        } else {
            $cart = Cart::where('session_id', session()->getId())->first();

            if ($cart) {
                $cartQuantities = $cart->items()
                    ->pluck('qty', 'product_id')
                    ->toArray();
            }
        }

        $favoriteIds = auth()->check()
            ? auth()->user()->favorites()->pluck('product_id')->toArray()
            : [];

        if ($request->ajax()) {
            return response()->json([
                'products' => view('partials.product', compact(
                    'products',
                    'cartQuantities',
                    'favoriteIds'
                ))->render(),

                'pagination' => view('partials.pagination', compact(
                    'products'
                ))->render(),

                'total' => $products->total(),
            ]);
        }

        return view('catalog.index', compact(
            'products',
            'categories',
            'cartQuantities',
            'favoriteIds',
            'pets'
        ));
    }

    public function quick(Product $product)
    {
        $product->load(['images', 'categories']);

        return view('partials.quick-product', compact('product'))->render();
    }
}
