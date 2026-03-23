<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workorder_closures', function (Blueprint $table) {
            $table->string('workflow_status')->nullable()->after('after_image');
            $table->string('final_status')->nullable()->after('workflow_status');
        });
    }

    public function down(): void
    {
        Schema::table('workorder_closures', function (Blueprint $table) {
            $table->dropColumn(['workflow_status', 'final_status']);
        });
    }
};
