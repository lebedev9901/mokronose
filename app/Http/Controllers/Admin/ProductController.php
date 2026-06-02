<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories', 'images')->latest()->get();
        

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
         $categories = Category::orderBy('title')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
         $request->validate([
        'title' => 'required',
        'price' => 'required|numeric',
        'weight' => 'required|numeric',
        'stock' => 'nullable|integer',
        'images.*' => 'image'
    ]);

    DB::transaction(function () use ($request) {

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'weight' => $request->weight,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'is_active' => 1,
            'proteins' => $request->proteins,
            'fats' => $request->fats,
            'carbohydrates' => $request->carbohydrates,
            'energy_value' => $request->energy_value,
            'shelf_life' => $request->shelf_life,
            'composition' => $request->composition,
            'storage_conditions' => $request->storage_conditions,
            'recommendations' => $request->recommendations,
            'age_group' => $request->age_group,
            'breed_size' => $request->breed_size,
            
        ]);
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories ?? []);
        }
        $previewIndex = (int) ($request->preview_index ?? 0);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $file) {

                $path = $file->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_preview' => $index === $previewIndex ? 1 : 0,
                ]);
            }
        }
    });

    return redirect()->route('admin.products');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $product->load('categories');
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'nullable|integer',
        ]);

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'weight' => $request->weight,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'proteins' => $request->proteins,
            'fats' => $request->fats,
            'carbohydrates' => $request->carbohydrates,
            'energy_value' => $request->energy_value,
            'shelf_life' => $request->shelf_life,
            'composition' => $request->composition,
            'storage_conditions' => $request->storage_conditions,
            'recommendations' => $request->recommendations,
            'age_group' => $request->age_group,
            'breed_size' => $request->breed_size,
            
        ]);
        $product->categories()->sync($request->categories ?? []);
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {

                $path = $file->store('products', 'public');

                $product->images()->create([
                    'image' => $path,
                    'is_preview' => 0
                ]);
            }
        }

        return redirect()->route('admin.products');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back();
    }

    public function deleteImage(ProductImage $image)
    {
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function setPreview(ProductImage $image)
    {
        // снимаем старый preview у товара
        $image->product->images()->update([
            'is_preview' => 0
        ]);

        // ставим новый
        $image->update([
            'is_preview' => 1
        ]);

        return response()->json(['success' => true]);
    }
}
