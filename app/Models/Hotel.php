<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'province_id',
        'city',
        'price',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relasi: Satu hotel bisa ada di banyak tour
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'hotel_tour');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
