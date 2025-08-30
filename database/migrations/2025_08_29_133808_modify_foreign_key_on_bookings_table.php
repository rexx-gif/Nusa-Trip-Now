<?php

// ...modify_foreign_key_on_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // 1. Jadikan kolom tour_id nullable terlebih dahulu
            // Ganti unsignedBigInteger jika Anda menggunakan foreignId
            $table->unsignedBigInteger('tour_id')->nullable()->change();

            // 2. KARENA FOREIGN KEY TIDAK ADA, BAGIAN DROP DIHAPUS

            // 3. Langsung tambahkan foreign key yang baru dan benar
            $table->foreign('tour_id')
                  ->references('id')
                  ->on('tours')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Sesuaikan bagian down jika diperlukan
            $table->dropForeign(['tour_id']);
            $table->unsignedBigInteger('tour_id')->nullable(false)->change();
        });
    }
};
