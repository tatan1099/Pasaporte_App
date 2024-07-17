<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNuevasColumnasToStands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stands', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('evento_id');
            $table->foreign('evento_id')->references('id')->on('event');
            $table->unsignedBigInteger('places_id');
            $table->foreign('places_id')->references('id')->on('places');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stands', function (Blueprint $table) {
            //
        });
    }
}
