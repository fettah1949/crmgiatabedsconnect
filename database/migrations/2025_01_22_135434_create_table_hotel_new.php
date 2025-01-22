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
        Schema::create('hotel_news', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name');
            $table->string('hotel_code');
            $table->string('bdc_id');
            $table->string('provider_id');
            $table->string('giataId');
            $table->string('city');
            $table->string('country');
            $table->string('country_code');
            $table->string('addresses');
            $table->string('phones_voice');
            $table->string('phones_fax');
            $table->string('email');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('chainId');
            $table->string('chainName');
            $table->string('zip_code');
            $table->integer('etat');
            $table->string('CategoryCode');
            $table->string('CategoryName');
            $table->string('CityCode');
            $table->string('status');
            $table->integer('with_giata')->default(0);
            $table->string('id_Expedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_news');
    }
};
