<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'parent_id',
        'slug',
    ];

   // many-to-many с товарами
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    // дерево категорий (self relation)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
