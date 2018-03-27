<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_penjualan')->unsigned()->nullable();
            $table->foreign('id_penjualan')
                ->references('id')
                ->on('penjualans')
                -> onDelete('set null');

            $table->integer('item_id')->unsigned()->nullable();
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                -> onDelete('set null');

            $table->string('item_name');

            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                -> onDelete('set null');
            
            $table->integer('selling_qty');

            $table->dateTime('datetime_transaction');
            $table->boolean('status');

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
        Schema::drop('penjualan_detail');
    }
}
