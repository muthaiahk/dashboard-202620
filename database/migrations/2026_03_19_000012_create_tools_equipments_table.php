<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tools_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('tool'); // tool, vehicle
            $table->string('serial_number')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        // Add foreign key to pivot table created in work_orders migration
        Schema::table('work_order_tool', function (Blueprint $table) {
            $table->foreign('tool_id')->references('id')->on('tools_equipments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('work_order_tool', function (Blueprint $table) {
            $table->dropForeign(['tool_id']);
        });
        Schema::dropIfExists('tools_equipments');
    }
};
