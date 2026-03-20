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
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropForeign(['technician_id']);
            $table->dropForeign(['driver_id']);

            $table->foreign('supervisor_id')->references('id')->on('resources')->nullOnDelete();
            $table->foreign('technician_id')->references('id')->on('resources')->nullOnDelete();
            $table->foreign('driver_id')->references('id')->on('resources')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropForeign(['technician_id']);
            $table->dropForeign(['driver_id']);

            $table->foreign('supervisor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('technician_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('driver_id')->references('id')->on('users')->nullOnDelete();
        });
    }
};
