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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('order_type')->nullable();
            $table->string('priority')->nullable();
            $table->date('compliance_date')->nullable();
            $table->date('assigned_date')->nullable();
            $table->date('tentative_removal_date')->nullable();
            $table->string('abc_ind')->nullable();
            $table->string('scheduling_grp')->nullable();
            $table->string('haz_area')->nullable();
            $table->string('act_type')->nullable();
            $table->string('cnfn_no')->nullable();
            $table->string('no_men')->nullable();
            $table->string('dur_hrs')->nullable();
            $table->string('st_txt_key')->nullable();
            $table->string('oper_no')->nullable();
            $table->string('catalog_profile')->nullable();
            $table->string('om_manual_doc_no')->nullable();
            $table->string('material_no_desc')->nullable();
            $table->string('recurrence')->nullable();
            $table->string('scaff_crane')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'order_type',
                'priority',
                'compliance_date',
                'assigned_date',
                'tentative_removal_date',
                'abc_ind',
                'scheduling_grp',
                'haz_area',
                'act_type',
                'cnfn_no',
                'no_men',
                'dur_hrs',
                'st_txt_key',
                'oper_no',
                'catalog_profile',
                'om_manual_doc_no',
                'material_no_desc',
                'recurrence',
                'scaff_crane'
            ]);
        });
    }
};
