<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang sudah ada
        $totalSales = Booking::whereIn('status', ['paid', 'completed'])->sum('total_price');
        $pendingConfirmations = Booking::with('user', 'tour')->whereHas('user')->whereHas('tour')->where('status', 'pending_confirmation')->get();
        $allBookings = Booking::with('user', 'tour')->whereHas('user')->whereHas('tour')->latest()->paginate(10);

        // Data untuk grafik
        $monthlyBookings = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Data status booking
        $bookingStatuses = Booking::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // DATA BARU: Ambil daftar user yang memiliki percakapan
        $chatUserIds = DB::table('chat_messages')->distinct()->pluck('user_id');
        $chatUsers = User::whereIn('id', $chatUserIds)->get();

        // Fetch tours data for sidebar stats
        $tours = Tour::with(['province', 'categories'])->paginate(10);

        return view('admin.dashboard_new', compact(
            'totalSales',
            'pendingConfirmations',
            'allBookings',
            'monthlyBookings',
            'bookingStatuses',
            'chatUsers',
            'tours'
        ));
    }

    /**
    * Approve a booking's payment.
    */
    public function approvePayment(Booking $booking)
    {
        // Check if the booking is actually pending confirmation
        if ($booking->status !== 'pending_confirmation') {
            return redirect()->back()->with('alert', 'This booking is not awaiting payment approval.');
        }

        // Update the booking status to 'paid'.
        // The error indicates 'confirmed' is not a valid value in the database schema.
        // We are using 'paid' as it is used elsewhere in this controller.
        $booking->update([
            'status' => 'paid',
        ]);

        // Store notification for the user (they'll see it when they visit the landing page)
        session()->flash('payment_approved', 'Selamat! Pembayaran Anda telah diterima dan dikonfirmasi oleh admin. Booking Anda sekarang aktif.');

        // Redirect back to the admin dashboard with a success message
        // Assumes your admin dashboard route is named 'admin.dashboard'
        return redirect()->route('admin.dashboard')->with('alert', 'Booking payment has been successfully approved and status set to paid.');
    }
}
