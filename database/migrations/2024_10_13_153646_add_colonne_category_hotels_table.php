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
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('CategoryCode');
            $table->string('CategoryName');
            $table->string('CityCode');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('CategoryCode');
            $table->dropColumn('CategoryName');
            $table->dropColumn('CityCode');
            $table->dropColumn('status');
        });
    }
};
