<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturanDetailStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returan_detail_status', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_returan_detail')->unsigned()->nullable();
            $table->foreign('id_returan_detail')
                ->references('id')
                ->on('returan_detail')
                -> onDelete('set null');

            $table->integer('qty_waste');
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
        Schema::drop('returan_detail_status');
    }
}
