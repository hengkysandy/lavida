<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKembalisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kembalis', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_returan_detail')->unsigned()->nullable();
            $table->foreign('id_returan_detail')
                ->references('id')
                ->on('returan_detail')
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

            $table->integer('qty_kembali');

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
        Schema::drop('kembalis');
    }
}
