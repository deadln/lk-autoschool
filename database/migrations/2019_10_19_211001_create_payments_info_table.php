<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_info', function (Blueprint $table) {
			$table->increments('id');
			$table->string('data');
			$table->string('type_payments');//способ платежа
			$table->string('type_operations');//способ оплаты
			$table->string('info');
			$table->boolean('notification');
			$table->string('uuid');
			$table->bool('ofd');
			$table->string('sum');
			$table->string('payments_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments_info');
    }
}
