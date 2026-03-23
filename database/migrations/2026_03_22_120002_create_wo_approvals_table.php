<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wo_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_id')
                ->constrained('work_orders')
                ->onDelete('cascade');

            $table->boolean('escalate')->default(false);
            $table->text('tech_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wo_approvals');
    }
};
