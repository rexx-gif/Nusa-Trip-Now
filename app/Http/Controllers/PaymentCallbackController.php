<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');

        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error processing notification.'], 500);
        }
        
        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        // Ekstrak ID booking dari order_id
        $bookingId = explode('-', $orderId)[1];
        $booking = Booking::findOrFail($bookingId);

        // Jangan proses jika status booking sudah bukan 'pending'
        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Booking already processed.']);
        }

        // Simpan data pembayaran
        Payment::create([
            'booking_id' => $booking->id,
            'transaction_id' => $notification->transaction_id,
            'amount' => $notification->gross_amount,
            'payment_method' => $type,
            'status' => $transaction,
            'raw_response' => json_encode($notification->getResponse()),
        ]);

        // Update status booking berdasarkan notifikasi
        if ($transaction == 'capture' || $transaction == 'settlement') {
            $booking->update(['status' => 'paid']);
        } else if ($transaction == 'pending') {
            // Tetap pending
        } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $booking->update(['status' => 'cancelled']);
        }

        return response()->json(['message' => 'Payment notification handled successfully.']);
    }
}