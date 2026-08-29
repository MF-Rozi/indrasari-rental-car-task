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
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('type');
            $table->string('model');
            $table->string('year');
            $table->string('color');
            $table->string('plate_number');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->string('seat_capacity');
            $table->string('price');
            $table->enum('availability', ['available', 'rented', 'maintenance'])->default('available');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
