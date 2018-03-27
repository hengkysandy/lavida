<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_code');
            $table->string('supplier_name');
            $table->string('pic_name');
            $table->string('pic_contact');
            $table->string('pic_email');
            $table->string('pic_phone');
            $table->string('supplier_location');
            $table->string('supplier_description');
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
        Schema::drop('suppliers');
    }
}
