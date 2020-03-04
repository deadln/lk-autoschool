<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorsInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instructors_id');
            $table->text('instructors_info');
            $table->text('instructors_worktime');
            $table->string('transmission')
            $table->strign('number_car')
            $table->string('img_car');
            $table->string('img_instructor');
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
