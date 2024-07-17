<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event', function (Blueprint $table) {
            //
        $table->text('color_contenedor_3')->nullable();
        $table->text('color_contenedor_4')->nullable();
        $table->text('images1')->nullable();
        $table->text('images2')->nullable();
        $table->text('images3')->nullable();
        $table->text('images4')->nullable();
        $table->text('images5')->nullable();
        $table->text('images6')->nullable();
        $table->text('images7')->nullable();
        $table->text('images8')->nullable();
        $table->Integer('numero_imagenes')->nullable();
        });
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
