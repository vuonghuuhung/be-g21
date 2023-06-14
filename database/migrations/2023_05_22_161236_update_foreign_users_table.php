<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['urban_id']);
            $table->dropForeign(['city_id']);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('urban_id')->references('id')->on('urbans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['urban_id']);
            $table->dropForeign(['city_id']);
            $table->foreign('city_id')->references('id')->on('urbans');
            $table->foreign('urban_id')->references('id')->on('cities');
        });
    }
};
