<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Ambil data booking milik user yang sedang login, urutkan dari yang terbaru
        $bookings = $user->bookings()->with('tour')->latest()->paginate(10);

        return view('user.profile', compact('user', 'bookings'));
    }
}
