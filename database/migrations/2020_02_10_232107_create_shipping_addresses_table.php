<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('user_id');
            $table->string('email');
            $table->string('name');
            $table->string('phone',100)->nullable();
            $table->string('city',100)->nullable();
            $table->string('village',100)->nullable();
            $table->string('district',100)->nullable();
            $table->string('commune',100)->nullable();
            $table->string('street_name',100)->nullable();
            $table->string('street_number',100)->nullable();
            $table->string('postcode',100)->nullable();
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
        Schema::dropIfExists('shipping_addresses');
    }
}
