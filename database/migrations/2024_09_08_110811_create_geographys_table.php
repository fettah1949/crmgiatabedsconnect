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
        Schema::create('geographies', function (Blueprint $table) {
            $table->id();
            $table->string('countryCode');
            $table->string('countryName');
            $table->string('destinationId');
            $table->string('destinationName');
            $table->string('cityId');
            $table->string('cityName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geographys');
    }
};
