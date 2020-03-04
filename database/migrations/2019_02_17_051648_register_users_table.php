<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegisterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fio');
            $table->string('phone');
            $table->string('email');
            $table->string('group');
            $table->string('price');
            $table->text('order_info');
            $table->boolean('notification');
            $table->string('uuid');
            $table->timestamps();
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
