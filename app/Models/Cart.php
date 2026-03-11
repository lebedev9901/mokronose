<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

      protected $fillable = [
        'user_id',
        'session_id',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    // Общее количество товаров
    public function getTotalQtyAttribute()
    {
        return $this->items->sum('qty');
    }

    // Общая сумма
    public function getTotalPriceAttribute()
    {
        // предполагаем, что у Product есть поле price
        return $this->items->sum(function ($item) {
            return $item->qty * $item->product->price;
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
