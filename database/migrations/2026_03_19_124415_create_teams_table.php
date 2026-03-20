<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();

            $table->string('team_name');

            // Single user per role (FK with users table)
            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('resources')
                ->nullOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('resources')
                ->nullOnDelete();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('resources')
                ->nullOnDelete();

            // Multiple users (no FK possible)
            $table->json('other_staff_ids')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};