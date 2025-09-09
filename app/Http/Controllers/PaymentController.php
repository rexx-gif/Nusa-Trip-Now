<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Corrected: Use the Storage facade

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran untuk booking tertentu.
     */
     public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // 1. Ambil path gambar dari relasi tour
        // Asumsi nama kolom di database adalah 'image'
        $imagePath = $booking->tour->image; 

        // 2. Buat URL yang bisa diakses publik
        $imageUrl = $imagePath ? Storage::url($imagePath) : null;

        // 3. Kirim URL ke view bersama dengan data booking
        return view('booking.payment', compact('booking', 'imageUrl'));
    }

    /**
     * Meng-handle upload bukti pembayaran.
     */
    public function upload(Request $request, Booking $booking)
    {
        // Keamanan: Pastikan hanya pemilik booking yang bisa upload bukti
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan melakukan tindakan ini.');
        }

        // Validasi file yang di-upload
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file ke storage/app/public/proofs
        // (Jangan lupa jalankan `php artisan storage:link`)
        $path = $request->file('proof_of_payment')->store('proofs', 'public');

        // Update record booking di database
        $booking->update([
            'proof_of_payment' => $path,
            'status' => 'pending_confirmation', // Status berubah menjadi menunggu konfirmasi admin
        ]);

        // Alihkan ke halaman utama dengan pesan sukses
        return redirect()->route('home')->with('alert', 'Terima kasih! Bukti pembayaran Anda telah diunggah dan akan segera kami verifikasi.');
    }
}
