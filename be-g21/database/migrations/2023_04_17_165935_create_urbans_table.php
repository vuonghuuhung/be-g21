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
        Schema::create('urbans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('slug');
            $table->string('name_with_type');
            $table->string('path');
            $table->string('path_with_type');
            $table->unsignedBigInteger('parent_code');
            $table->timestamps();
        });

        Schema::table('urbans', function (Blueprint $table) {
            $table->foreign('parent_code')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urbans');
    }
};
