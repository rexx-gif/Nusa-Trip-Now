<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->string('city')->nullable();
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Pivot table for tour and hotel many-to-many relationship
        Schema::create('hotel_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['hotel_id', 'tour_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_tour');
        Schema::dropIfExists('hotels');
    }
}
