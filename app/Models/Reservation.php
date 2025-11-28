<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_listing_id',
        'quantity',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodListing()
    {
        return $this->belongsTo(FoodListing::class);
    }

    public function survey()
    {
        return $this->hasOne(Survey::class);
    }
}