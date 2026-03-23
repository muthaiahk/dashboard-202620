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
        Schema::create('workorder_closures', function (Blueprint $table) {
            $table->id();

            // ✅ SAME FK
            $table->foreignId('workorder_id')
                ->constrained('work_orders')
                ->onDelete('cascade');

            $table->string('before_image')->nullable();
            $table->string('during_image')->nullable();
            $table->string('after_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_closures');
    }
};