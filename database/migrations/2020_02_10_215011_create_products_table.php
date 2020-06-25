<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->string('product_name',200)->nullable();
            $table->string('product_code',200)->nullable();
            $table->integer('qty')->nullable();
            //$table->string('product_color')->nullable();
            $table->unsignedInteger('likes')->default(0);
            $table->float('defult_price')->nullable();
            $table->float('discount')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('image')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
