<?php

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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_type_id')->contrained()->onDelete('cascade');
            $table->string('license_plate', 10);
            $table->integer('rental_rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
