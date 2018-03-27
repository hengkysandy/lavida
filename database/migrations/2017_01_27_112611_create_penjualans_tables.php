<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_nota');

            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                -> onDelete('set null');

            $table->dateTime('datetime_transaction');
            $table->dateTime('datetime_estimate');
            $table->boolean('status');
            $table->string('remark_returan')->nullable();
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
        Schema::drop('penjualans');
    }
}
