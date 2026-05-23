<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VkReview extends Model
{
    protected $fillable = [
        'product_id',
        'vk_comment_id',
        'author_name',
        'text',
        'photo',
        'vk_created_at',
    ];

    protected $casts = [
        'vk_created_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
