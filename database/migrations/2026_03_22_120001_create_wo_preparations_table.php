<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wo_preparations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_id')
                ->constrained('work_orders')
                ->onDelete('cascade');

            // Pre-Checklist booleans
            $table->boolean('pre_ptw_approved')->default(false);
            $table->boolean('pre_gate_pass_valid')->default(false);
            $table->boolean('pre_weather_verified')->default(false);
            $table->boolean('pre_equipment_readiness')->default(false);
            $table->boolean('pre_team_certs_valid')->default(false);
            $table->boolean('pre_loto_applied')->default(false);

            // Assigned tools (stored as JSON array of checked tool IDs)
            $table->json('assigned_tools')->nullable();

            // Technical notes
            $table->boolean('escalate')->default(false);
            $table->text('tech_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wo_preparations');
    }
};
