<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'transaction_id',
        'amount',
        'payment_method',
        'status',
        'raw_response',
    ];

    protected function casts(): array
    {
        return [
            'raw_response' => 'array',
        ];
    }

    // Relasi: Satu pembayaran dimiliki oleh satu booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
