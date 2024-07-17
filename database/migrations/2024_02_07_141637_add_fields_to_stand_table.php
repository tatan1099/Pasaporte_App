<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToStandTable extends Migration
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
            $table->text('color_contenedor_1')->nullable();
            $table->text('color_contenedor_2')->nullable();
            $table->text('images1')->nullable();
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
        $table->dropColumn('color_contenedor_1');
        $table->dropColumn('color_contenedor_2');
        $table->dropColumn('images');
    });
}
}