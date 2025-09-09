<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatMessage;
use App\Models\User; // Pastikan model User diimpor
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\Log; // Impor Log facade

class ChatController extends Controller
{
    /**
     * Mengambil seluruh riwayat percakapan untuk user tertentu.
     * Metode ini aman dan menangani otorisasi dengan benar.
     */
    public function getChatHistory($userId)
    {
        try {
            // Otorisasi: Pastikan hanya user yang bersangkutan atau admin yang bisa melihat
            if (Auth::id() != $userId && !Auth::user()->role === 'admin') {
                 return response()->json(['error' => 'Forbidden. Anda tidak diizinkan mengakses riwayat ini.'], 403);
            }

            // Validasi: Pastikan user yang diminta ada di database
            $userExists = User::find($userId);
            if (!$userExists) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            $history = ChatMessage::where('user_id', $userId)->orderBy('created_at', 'asc')->get();

            $formattedHistory = $history->map(function ($message) use ($userId) {
                // Tentukan pengirim berdasarkan siapa yang memiliki 'sender_id'
                // Jika sender_id sama dengan user_id dari chat, maka itu pesan dari user.
                // Jika berbeda, itu adalah balasan (kemungkinan dari admin).
                $senderType = ($message->sender_id == $userId) ? 'user' : 'admin';
                
                return [
                    'message'   => $message->message,
                    'sender'    => $senderType,
                    'timestamp' => $message->created_at->toDateTimeString()
                ];
            });

            return response()->json($formattedHistory);

        } catch (\Exception $e) {
            // Mencatat galat detail ke dalam log untuk debugging
            Log::error('Gagal mengambil riwayat chat untuk user ID ' . $userId . ': ' . $e->getMessage());
            
            // Memberikan respons galat umum ke klien
            return response()->json(['error' => 'Terjadi kesalahan internal pada server.'], 500);
        }
    }

    /**
     * Menerima pesan dari user, menyimpannya, dan menyiarkannya.
     */
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $user = Auth::user();
        
        $message = ChatMessage::create([
            'user_id'   => $user->id,
            'sender_id' => $user->id, // Pengirim adalah user itu sendiri
            'message'   => $request->input('message'),
        ]);

        broadcast(new NewChatMessage($message->message, $user->id, 'user'))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }

    /**
     * Menerima balasan dari admin, menyimpannya, dan menyiarkannya.
     */
    public function adminSendMessage(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        $admin = Auth::user();
        $targetUserId = $request->input('user_id');

        $message = ChatMessage::create([
            'user_id'   => $targetUserId, // Tetap ID user yang memulai chat
            'sender_id' => $admin->id,   // Pengirim adalah admin
            'message'   => $request->input('message'),
        ]);

        broadcast(new NewChatMessage($message->message, $targetUserId, 'admin'));

        return response()->json(['status' => 'Reply Sent!']);
    }
}

