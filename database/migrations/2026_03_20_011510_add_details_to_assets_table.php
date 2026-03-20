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
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'description')) $table->text('description')->nullable();
            if (!Schema::hasColumn('assets', 'valve_type')) $table->string('valve_type')->nullable();
            if (!Schema::hasColumn('assets', 'actual_size')) $table->string('actual_size')->nullable();
            if (!Schema::hasColumn('assets', 'estimated_size')) $table->string('estimated_size')->nullable();
            if (!Schema::hasColumn('assets', 'pressure_class')) $table->string('pressure_class')->nullable();
            if (!Schema::hasColumn('assets', 'work_center')) $table->string('work_center')->nullable();
            if (!Schema::hasColumn('assets', 'latitude')) $table->string('latitude')->nullable();
            if (!Schema::hasColumn('assets', 'longitude')) $table->string('longitude')->nullable();
            if (!Schema::hasColumn('assets', 'special_tools')) $table->text('special_tools')->nullable();
            if (!Schema::hasColumn('assets', 'scaff_crane')) $table->string('scaff_crane')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'valve_type',
                'actual_size',
                'estimated_size',
                'pressure_class',
                'work_center',
                'latitude',
                'longitude',
                'special_tools',
                'scaff_crane'
            ]);
        });
    }
};
