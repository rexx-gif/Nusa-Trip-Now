<?php

namespace App\Http\Controllers\Admin; // Sesuaikan namespace Anda

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User; // <-- Import User
use Illuminate\Support\Facades\DB; // <-- Import DB

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang sudah ada
        $totalSales = Booking::whereIn('status', ['paid', 'completed'])->sum('total_price');
        $pendingConfirmations = Booking::with('user', 'tour')->where('status', 'pending_confirmation')->get();
        $allBookings = Booking::with('user', 'tour')->latest()->paginate(10);

        // DATA BARU: Ambil daftar user yang memiliki percakapan
        $chatUserIds = DB::table('chat_messages')->distinct()->pluck('user_id');
        $chatUsers = User::whereIn('id', $chatUserIds)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'pendingConfirmations',
            'allBookings',
            'chatUsers' // <-- Kirim data user chat ke view
        ));
    }
}