<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_id',
        'booking_date',
        'total_price',
        'status',
        'payment_token',
        'payment_url',
    ];

    // Relasi: Satu booking dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu booking untuk satu paket wisata
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Relasi: Satu booking punya satu data pembayaran
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
