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
        'province_id',
    ];

    // Relasi: Satu paket wisata bisa punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tour_category');
    }

    public function inclusions()
    {
        return $this->belongsToMany(Inclusion::class, 'tour_inclusion');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_tour');
    }
}
