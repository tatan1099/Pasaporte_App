<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Imagenesstands extends Migration
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
            $table->text('images2')->nullable();
            $table->text('images3')->nullable();
            $table->text('images4')->nullable();
            $table->text('images5')->nullable();
            $table->text('images6')->nullable();
            $table->text('images7')->nullable();
            $table->text('images8')->nullable();
            $table->text('images9')->nullable();
            $table->text('images10')->nullable();
           
        });

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
   

   
    }
}