<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatMessage;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    /**
     * Menerima pesan dari user (landing page), menyimpannya, dan menyiarkannya.
     */
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate(['message' => 'required|string|max:1000']);

        // Pastikan user sudah login untuk mengirim pesan
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $user = Auth::user();
        $messageContent = $request->input('message');

        // 1. Simpan pesan ke database
        ChatMessage::create([
            'user_id'   => $user->id,
            'sender_id' => $user->id, // Pengirim adalah user itu sendiri
            'message'   => $messageContent,
        ]);

        // 2. Siarkan event ke channel privat user
        // Admin juga mendengarkan channel ini
        broadcast(new NewChatMessage(
            $messageContent,
            $user->id,      // ID user yang memiliki chat
            'user'          // Tipe pengirim
        ))->toOthers(); // toOthers() agar tidak terkirim kembali ke tab pengirim

        return response()->json(['status' => 'Message Sent and Saved!']);
    }

    /**
     * Menerima balasan dari admin, menyimpannya, dan menyiarkannya.
     */
    public function adminSendMessage(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses
        if (!Auth::check() || Auth::user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

        $request->validate([
            'message' => 'required|string|max:1000',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        $admin = Auth::user();
        $messageContent = $request->input('message');
        $targetUserId = $request->input('user_id');

        // 1. Simpan balasan admin ke database
        ChatMessage::create([
            'user_id'   => $targetUserId, // Tetap ID user yang memulai chat
            'sender_id' => $admin->id, // Pengirim adalah admin
            'message'   => $messageContent,
        ]);

        // 2. Siarkan event ke channel privat user yang dituju
        broadcast(new NewChatMessage(
            $messageContent,
            $targetUserId,
            'agent'
        ));

        return response()->json(['status' => 'Reply Sent and Saved!']);
    }

    /**
     * Mengambil seluruh riwayat percakapan untuk user tertentu.
     */
    public function getChatHistory($userId)
{
    // Otorisasi: Pastikan hanya user yang bersangkutan atau admin yang bisa lihat
    // The problem is almost certainly that '!Auth::user()->admin' is returning true.
    // Make sure your admin user has the 'admin' column set to 1 in the database.
   // UBAH BAGIAN INI
    if (Auth::id() != $userId && Auth::user()->role !== 'admin') {
         return response()->json(['error' => 'Forbidden'], 403);
    }

    $history = ChatMessage::where('user_id', $userId)->orderBy('created_at', 'asc')->get();

    $formattedHistory = $history->map(function ($message) {
        return [
            'message' => $message->message,
            'sender'  => $message->sender_id == $message->user_id ? 'user' : 'agent',
            'timestamp' => $message->created_at->toDateTimeString()
        ];
    });

    return response()->json($formattedHistory);
}
}