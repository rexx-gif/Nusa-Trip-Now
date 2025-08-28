<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->date('booking_date');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'completed'])->default('pending');
            $table->string('payment_token')->nullable(); // Untuk menyimpan token dari payment gateway
            $table->string('payment_url')->nullable(); // Untuk menyimpan URL pembayaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
