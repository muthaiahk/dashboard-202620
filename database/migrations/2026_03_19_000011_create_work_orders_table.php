<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('procedure_id')->nullable();
            $table->string('status')->default('pending');
            $table->date('scheduled_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('set null');
        });

        Schema::create('work_order_resource', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('resource_id');

            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
        });

        Schema::create('work_order_tool', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('tool_id');

            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            // Tool foreign key will be added in tool migration or here if table exists. We'll wait.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_tool');
        Schema::dropIfExists('work_order_resource');
        Schema::dropIfExists('work_orders');
    }
};
