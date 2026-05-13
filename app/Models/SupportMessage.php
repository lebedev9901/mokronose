<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'sender_type',
        'message',
    ];

    public function chat() {
        return $this->belongsTo(SupportChat::class, 'chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
