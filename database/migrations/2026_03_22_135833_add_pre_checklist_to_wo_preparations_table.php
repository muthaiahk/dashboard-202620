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
        Schema::table('wo_preparations', function (Blueprint $table) {
            $table->json('pre_checklist')->after('pre_loto_applied')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wo_preparations', function (Blueprint $table) {
            $table->dropColumn('pre_checklist');
        });
    }
};
