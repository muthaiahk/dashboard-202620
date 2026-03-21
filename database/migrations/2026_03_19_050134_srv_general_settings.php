<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->string('logo')->nullable();
            $table->string('fav_icon')->nullable();
            $table->string('url');
            $table->string('email_id')->nullable();
            $table->string('mobile_number')->nullable();

            $table->string('date_format')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('registered_name')->nullable();

            // ✅ Correct integer columns
            $table->unsignedBigInteger('language_id')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            
            $table->text('address')->nullable();
            $table->string('pincode')->nullable();

            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->unsignedBigInteger('status')->default(0);
            $table->string('linkedin_link')->nullable();
            $table->string('pinterest_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('website_link')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};