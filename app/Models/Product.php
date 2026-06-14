<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;

     protected $table = 'products'; // название таблицы в БД
    protected $fillable = [
        'title', 
        'stock', 
        'description', 
        'price', 
        'weight', 
        'rating',
        'proteins',
        'fats',
        'carbohydrates',
        'energy_value',
        'shelf_life',
        'composition',
        'storage_conditions',
        'recommendations',
        'age_group',
        'breed_size',
        ]; 

        protected $casts = [
            'age_group' => 'array',
            'breed_size' => 'array',
        ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function vkReviews()
    {
        return $this->hasMany(VkReview::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
