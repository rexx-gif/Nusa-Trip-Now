<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_soft_deletes_to_tours_table.php

public function up()
{
    Schema::table('tours', function (Blueprint $table) {
        $table->softDeletes(); // Ini akan menambahkan kolom 'deleted_at'
    });
}

public function down()
{
    Schema::table('tours', function (Blueprint $table) {
        $table->dropSoftDeletes(); // Untuk rollback migrasi
    });
}
};
