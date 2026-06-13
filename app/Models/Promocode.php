<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
        'code',
        'title',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function isAvailable(float $cartTotal): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_order_amount && $cartTotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $cartTotal): float
    {
        if ($this->type === 'percent') {
            return round($cartTotal * ($this->value / 100), 2);
        }

        return min($this->value, $cartTotal);
    }
}
