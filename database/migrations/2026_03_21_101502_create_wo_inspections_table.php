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
        Schema::create('wo_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workorder_id')
                ->constrained('work_orders')
                ->onDelete('cascade');

            $table->text('site_condition_notes')->nullable();
            $table->text('obstruction_notes')->nullable();
            $table->text('special_tools_required')->nullable();
            $table->text('access_issues')->nullable();
            $table->text('safety_concerns')->nullable();

            $table->string('permit_number')->nullable();
            $table->string('permit_transferred_by')->nullable();

            $table->string('staff_mobile_no')->nullable();
            $table->string('staff_email_id')->nullable();

            $table->foreignId('assigned_team_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('permit_upload')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wo_inspections');
    }
};