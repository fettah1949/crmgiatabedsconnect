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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name');
            $table->string('hotel_code');
            $table->string('giataId');
            $table->string('city');
            $table->string('country');
            $table->string('addresses');
            $table->string('phones_voice');
            $table->string('phones_fax');
            $table->string('email');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('chainId');
            $table->string('chainName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
