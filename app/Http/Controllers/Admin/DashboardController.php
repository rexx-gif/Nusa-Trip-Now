<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang sudah ada
        $totalSales = Booking::whereIn('status', ['paid', 'completed'])->sum('total_price');
        $pendingConfirmations = Booking::with('user', 'tour')->where('status', 'pending_confirmation')->get();
        $allBookings = Booking::with('user', 'tour')->latest()->paginate(10);

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

        return view('admin.dashboard', compact(
            'totalSales',
            'pendingConfirmations',
            'allBookings',
            'monthlyBookings',
            'bookingStatuses',
            'chatUsers'
        ));
    }
}