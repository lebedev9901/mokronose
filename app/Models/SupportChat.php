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
        'subject'
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

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Открыт',
            'waiting' => 'Ожидает ответа поддержки',
            'answered' => 'Есть ответ поддержки',
            'closed' => 'Закрыт',
            default => 'Неизвестно',
        };
    }

}
