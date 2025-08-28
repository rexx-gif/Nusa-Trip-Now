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
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1|max:10', // Validasi jumlah tiket
        ]);

        // ===================================================================
        // PROSES PEMBAYARAN SIMULASI
        // ===================================================================
        // Tidak ada koneksi ke payment gateway.
        // Booking langsung dianggap berhasil dan statusnya diubah menjadi 'paid'.
        
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_id' => $tour->id,
            'booking_date' => $request->booking_date,
            'quantity' => $request->quantity, // Simpan jumlah tiket
            'total_price' => $request->quantity * $tour->price, // Simpan total harga baru
            'status' => 'paid', // Langsung set status menjadi 'paid'
        ]);
        // Hitung total harga baru
        $totalPrice = $tour->price * $request->quantity;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_id' => $tour->id,
            'booking_date' => $request->booking_date,
            'quantity' => $request->quantity, // Simpan jumlah tiket
            'total_price' => $totalPrice, // Simpan total harga baru
            'status' => 'waiting_payment', // KEMBALIKAN STATUS MENJADI MENUNGGU PEMBAYARAN
        ]);

        // ALIHKAN PENGGUNA KE HALAMAN PEMBAYARAN
        return redirect()->route('payment.show', $booking);
    }
};