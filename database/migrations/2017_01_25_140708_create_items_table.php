<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_code');
            $table->string('item_brand');
            $table->string('item_sku');
            $table->string('item_name');
            $table->string('item_category');

            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                -> onDelete('set null');

            $table->integer('item_qty');
            $table->integer('item_min_qty');
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
        Schema::drop('items');
    }
}
