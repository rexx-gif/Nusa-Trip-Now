<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'price',
        'image',
    ];

    // Relasi: Satu paket wisata bisa punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
