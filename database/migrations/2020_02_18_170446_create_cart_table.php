<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->integer('product_id');
            $table->String('product_name');
            $table->string('product_code')->nullable();
            $table->string('product_color');
            $table->string('image');
            $table->string('product_size');
            $table->integer('qty');
            $table->string('email');
            $table->double('price');
            $table->double('total');
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
        Schema::dropIfExists('cart');
    }
}
