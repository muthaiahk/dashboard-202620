<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wo_executions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_id')
                ->constrained('work_orders')
                ->onDelete('cascade');

            // All checklist items stored as JSON (key => boolean)
            $table->json('safety_checklist')->nullable();
            $table->json('procedure_checklist')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wo_executions');
    }
};
