<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        return view('booking.payment', compact('booking'));
    }

    public function upload(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('proof_of_payment')->store('proofs', 'public');

        $booking->update([
            'proof_of_payment' => $path,
            'status' => 'pending_confirmation',
        ]);

        // DIPERBARUI: Redirect ke landing page dengan pesan status
        return redirect()->route('home')->with('alert', 'Terima kasih! Bukti pembayaran Anda telah diunggah dan akan segera kami verifikasi.');
    }
}