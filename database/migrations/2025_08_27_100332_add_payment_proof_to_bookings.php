<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah kolom untuk menyimpan path file bukti pembayaran
            $table->string('proof_of_payment')->nullable()->after('status');
        });

        // Ubah tipe data kolom status agar bisa menampung nilai baru
        // Perintah DB::statement() diperlukan untuk mengubah ENUM di MySQL
        DB::statement("ALTER TABLE bookings CHANGE COLUMN status status ENUM('pending', 'paid', 'cancelled', 'completed', 'waiting_payment', 'pending_confirmation') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('proof_of_payment');
        });
        DB::statement("ALTER TABLE bookings CHANGE COLUMN status status ENUM('pending', 'paid', 'cancelled', 'completed') NOT NULL DEFAULT 'pending'");
    }
};
