<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            if (!Schema::hasColumn('procedures', 'procedure_code')) {
                $table->string('procedure_code')->nullable()->after('title');
            }
            if (!Schema::hasColumn('procedures', 'asset_type')) {
                $table->string('asset_type')->nullable()->after('description');
            }
            if (!Schema::hasColumn('procedures', 'work_category')) {
                $table->string('work_category')->nullable()->after('asset_type');
            }
            if (!Schema::hasColumn('procedures', 'steps')) {
                $table->json('steps')->nullable()->after('work_category');
            }
            if (!Schema::hasColumn('procedures', 'pre_checklist')) {
                $table->json('pre_checklist')->nullable()->after('steps');
            }
            if (!Schema::hasColumn('procedures', 'post_checklist')) {
                $table->json('post_checklist')->nullable()->after('pre_checklist');
            }
            if (!Schema::hasColumn('procedures', 'required_tools')) {
                $table->json('required_tools')->nullable()->after('post_checklist');
            }
            if (!Schema::hasColumn('procedures', 'status')) {
                $table->tinyInteger('status')->default(1)->after('required_tools');
            }
        });
    }

    public function down(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            $table->dropColumn(['procedure_code', 'work_category', 'pre_checklist', 'post_checklist', 'required_tools']);
        });
    }
};
