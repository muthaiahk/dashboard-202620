<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_maintenance', function (Blueprint $table) {
            $table->id();

            // Foreign key to equipment table
            $table->unsignedBigInteger('equipment_id');
            $table->foreign('equipment_id')
                ->references('id')
                ->on('equipments')
                ->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('purpose');
            $table->date('date');
            $table->string('ownership');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
    }
};