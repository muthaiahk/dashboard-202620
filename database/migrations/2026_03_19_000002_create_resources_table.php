<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('address')->nullable();
            $table->json('certificates')->nullable();
            $table->json('permits')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
