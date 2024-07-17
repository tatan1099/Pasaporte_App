<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('document')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('birthday')->nullable();
            $table->string('genere')->nullable();
            $table->foreignId('rol_id');
            $table->foreign('rol_id')->references('id')->on('rols');
            $table->string('auth_id')->nullable();
            $table->string('auth_name')->nullable();
            $table->rememberToken();
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
}
