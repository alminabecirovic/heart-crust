<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FoodListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_name',
        'image',
        'bakery_name',
        'pickup_address',
        'quantity',
        'original_quantity',
        'made_at',
        'ingredients',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'made_at' => 'datetime',
            'is_available' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isExpired()
    {
        return Carbon::now()->diffInDays($this->created_at) >= 2;
    }
}