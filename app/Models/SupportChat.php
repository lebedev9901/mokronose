<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
    protected $fillable = [
        'chat_id',
        'order_id',
        'user_id',
        'status',
    ];

    public function message()
    {
        return $this->hasMany(SupportMessage::class, 'chat_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
