<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang memulai chat
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // Siapa yang mengirim (bisa user, bisa admin)
            $table->text('message');
            $table->boolean('is_read')->default(false); // Berguna untuk notifikasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};