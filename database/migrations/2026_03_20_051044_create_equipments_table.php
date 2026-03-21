<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->string('category');
            $table->string('serial_number')->unique();
            $table->string('manufacturer');
            $table->string('model');
            $table->string('ownership');
            $table->string('current_status');
            $table->string('current_location');
            $table->string('certificate')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};