<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('procedure_code')->nullable();
            $table->text('description')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('work_category')->nullable();
            $table->json('steps')->nullable();
            $table->json('pre_checklist')->nullable();
            $table->json('post_checklist')->nullable();
            $table->json('required_tools')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
