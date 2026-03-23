<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->tinyInteger('wizard_current_step')->default(0)->after('wizard_data');
            $table->string('wizard_status', 20)->default('pending')->after('wizard_current_step');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['wizard_current_step', 'wizard_status']);
        });
    }
};
