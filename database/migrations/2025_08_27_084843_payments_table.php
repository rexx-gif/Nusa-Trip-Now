<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('transaction_id'); // ID dari payment gateway
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->string('status'); // Status dari payment gateway
            $table->json('raw_response'); // Menyimpan response lengkap dari gateway
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};