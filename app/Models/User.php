<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firts_name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'birth_date',
        'phone',
        'avatar',
        'role',
    ];

     public function getFilamentName(): string
    {
        // если full_name нет, используем email
        return $this->first_name ?? $this->email ?? 'User';
    }

    public function getNameAttribute(): string
    {
        return $this->first_name ?: $this->email ?: 'User';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
