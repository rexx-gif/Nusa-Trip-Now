<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // <-- Tambahkan ini
use App\Mail\BookingConfirmed;      // <-- Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Booking::where('status', 'paid')->orWhere('status', 'completed')->sum('total_price');
        $allBookings = Booking::with(['user', 'tour'])->latest()->paginate(15);
        $pendingConfirmations = Booking::where('status', 'pending_confirmation')->with(['user', 'tour'])->get();

        return view('admin.dashboard', compact('totalSales', 'allBookings', 'pendingConfirmations'));
    }

    public function approvePayment(Booking $booking)
    {
        // Ubah status booking menjadi 'paid'
        $booking->update(['status' => 'paid']);

        // Kirim email notifikasi ke user
        Mail::to($booking->user->email)->send(new BookingConfirmed($booking));

        return redirect()->route('admin.dashboard')->with('success', 'Pembayaran telah berhasil dikonfirmasi dan email notifikasi telah dikirim.');
    }

    // METHOD BARU UNTUK REJECT
    public function rejectPayment(Booking $booking)
    {
        // Ubah status booking menjadi 'cancelled'
        $booking->update(['status' => 'cancelled']);

        // Di sini Anda juga bisa mengirim email notifikasi penolakan jika diperlukan

        return redirect()->route('admin.dashboard')->with('success', 'Pembayaran telah ditolak.');
    }
}