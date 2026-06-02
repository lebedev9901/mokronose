<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'species',
        'breed',
        'birth_date',
        'avatar',
        'age_group',
        'breed_size',
        'weight',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
