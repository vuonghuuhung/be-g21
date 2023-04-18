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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100);
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->unique('email');
            $table->string('password', 100);
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->string('deleted_by', 100)->nullable();
            $table->unsignedBigInteger('role')->default(1)->comment('1-user, 2-admin');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('urban_id');
            $table->string('address_node');
            $table->string('phone');
            $table->string('token');
            $table->unsignedBigInteger('status')->default(2)->comment('1-active, 2-inactive, 3-removed');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('urbans');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('urban_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
