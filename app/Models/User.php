<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'bakery_name',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    public function foodListings()
    {
        return $this->hasMany(FoodListing::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBakery()
    {
        return $this->role === 'bakery';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isGuest()
    {
        return $this->role === 'guest';
    }
}