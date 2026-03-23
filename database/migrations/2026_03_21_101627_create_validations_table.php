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
        Schema::create('validations', function (Blueprint $table) {
            $table->id();

            // ✅ SAME FK
            $table->foreignId('workorder_id')
                ->constrained('work_orders')
                ->onDelete('cascade');

            $table->boolean('tools')->default(false);
            $table->boolean('assigned_members')->default(false);
            $table->boolean('obstruction_notes')->default(false);
            $table->boolean('special_tools')->default(false);
            $table->boolean('access_issues')->default(false);
            $table->boolean('safety_concerns')->default(false);
            $table->boolean('site_condition_notes')->default(false);
            $table->boolean('documents_permits')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};