<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman detail wisata dan form booking.
     */
    public function create(Tour $tour)
    {
        return view('booking.create', compact('tour'));
    }

    /**
     * Memproses booking dan mengarahkan ke pembayaran.
     */
    public function store(Request $request, Tour $tour)
    {
        // 1. Validasi input dari form
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // 2. Hitung total harga berdasarkan kuantitas
        $totalPrice = $tour->price * $request->quantity;

        // 3. Buat SATU data booking baru dengan status menunggu pembayaran
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_id' => $tour->id,
            'booking_date' => $request->booking_date,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'waiting_payment', // Status yang benar untuk alur pembayaran
        ]);

        // 4. Alihkan pengguna ke halaman pembayaran dengan data booking yang baru dibuat
        return redirect()->route('payment.show', $booking);
    }
}