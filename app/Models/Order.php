<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
              
        'user_id',
        'total_price',
        'delivery_method',
        'payment_method',
        'status',
        'address_id',
        'pickup_point',
        'cdek_point',
        'post_address',
        'promocode_id',
        'promocode_code',
        'total_before_discount',
        'discount_amount',
        'total_after_discount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->hasOne(SupportChat::class, 'order_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getDeliveryLabelAttribute(): string
    {
        return match ($this->delivery_method) {
            'courier' => 'Курьер',
            'pickup' => 'Самовывоз',
            'cdek' => 'СДЭК',
            'post' => 'Почта России',
            default => 'Неизвестно',
        };
    }

    public function getPaymentLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash' => 'Наличными',
            'card' => 'Банковской картой',
            'online' => 'Онлайн оплата',
            default => 'Неизвестно',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new' => 'Новый',
            'pending' => 'Ожидает обработки',
            'confirmed' => 'Подтверждён',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'completed' => 'Завершён',
            'cancelled' => 'Отменён',
            default => 'Неизвестно',
        };
    }
}
