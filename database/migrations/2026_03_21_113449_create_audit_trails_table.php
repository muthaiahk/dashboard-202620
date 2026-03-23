<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();

            // User role & module
            $table->string('role')->nullable();
            $table->string('module')->index(); // indexed for faster filtering

            // Action info
            $table->string('action'); // create, update, delete, login, etc.

            // Affected model info
            $table->string('model')->nullable();   // e.g., User, Order
            $table->unsignedBigInteger('model_id')->nullable();

            // Change tracking
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Human-readable description
            $table->text('details')->nullable();

            // कौन किया (who did it)
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->index();

            // Timestamps
            $table->timestamps();

            // Optional composite index (for faster queries)
            $table->index(['model', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};