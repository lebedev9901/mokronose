<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
     public function index()
    {
        $categories = Category::with('parent')
            ->withCount('products')
            ->orderBy('parent_id')
            ->orderBy('title')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'parent_id' => $request->parent_id,
            'is_active' => 1
        ]);

        return back();
    }

    public function edit(Category $category)
    {
          $categories = Category::where('id', '!=', $category->id)
            ->orderBy('title')
            ->get();
        return view('admin.categories.edit', compact('categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Категория удалена');
    }
}
