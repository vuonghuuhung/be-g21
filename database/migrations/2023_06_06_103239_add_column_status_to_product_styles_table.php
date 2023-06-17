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
        Schema::table('product_styles', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('0-deleted, 1-normal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_styles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
