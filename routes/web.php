<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\TourPageController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Landing Page (Publik)
Route::get('/', function () {
    return view('LandingPage');
})->name("home");

// Route bawaan Laravel untuk login, register, dll.
require __DIR__.'/auth.php';

// --- ROUTE UNTUK MENAMPILKAN WISATA KE USER (PUBLIC) ---
Route::get('/tours', [TourPageController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', function(\App\Models\Tour $tour) {
    $tour->load(['province', 'categories', 'inclusions']);
    return view('tours.show_improved', compact('tour'));
})->name('tours.show');

// --- ROUTE UNTUK USER YANG SUDAH LOGIN ---
Route::middleware(['auth', 'prevent.back'])->group(function () {
    
   // routes/web.php

Route::get('/dashboard', function () {
    // This line causes the error
    if (\Illuminate\Support\Facades\Request::user() && \Illuminate\Support\Facades\Request::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.profile.history');
})->name('dashboard');

    // Route Profil & Booking User
    Route::get('/my-bookings', [UserProfileController::class, 'index'])->name('user.profile.history');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/booking/{tour}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{tour}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking-success', function() { return view('booking.success'); })->name('booking.success');
    Route::get('/booking-failed', function() { return view('booking.failed'); })->name('booking.failed');

    // --- ROUTE UNTUK PROSES PEMBAYARAN ---
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{booking}/upload', [PaymentController::class, 'upload'])->name('payment.upload');

    // === ROUTE CHAT UNTUK USER ===
    // User mengirim pesan
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    // User & Admin mengambil riwayat chat berdasarkan ID User
    Route::get('/chat/history/{userId}', [ChatController::class, 'getChatHistory'])->name('chat.history');
});

// --- ROUTE UNTUK ADMIN ---
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('tours', TourController::class);
    Route::resource('users', UserController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::post('/bookings/{booking}/approve', [AdminDashboardController::class, 'approvePayment'])->name('bookings.approve');

    // === ROUTE CHAT UNTUK ADMIN ===
    // Admin mengirim balasan
    Route::post('/chat/send', [ChatController::class, 'adminSendMessage'])->name('chat.send');
});

// --- ROUTE UNTUK PAYMENT GATEWAY CALLBACK ---
Route::post('/payments/callback', [PaymentCallbackController::class, 'handle'])->name('payment.callback');

