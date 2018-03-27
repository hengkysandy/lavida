<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWasteListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_list', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_returan')->unsigned()->nullable();
            $table->foreign('id_returan')
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
                
            $table->integer('qty_waste');

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
        Schema::drop('waste_list');
    }
}
