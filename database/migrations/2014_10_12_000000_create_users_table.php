<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('sex')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->string('ThreeD_model')->nullable();
            $table->string('phone',11)->nullable();
            $table->string('city',100)->nullable();
            $table->string('code')->nullable();
            $table->date('dob')->nullable();
            $table->string('district',100)->nullable();
            $table->string('commune',100)->nullable();
            $table->unsignedBigInteger('shipping_address')->nullable();
            $table->string('village',100)->nullable();
            $table->string('lan',100)->nullable();
            $table->string('role')->default('customer');
            $table->string('lat',100)->nullable();
            $table->string('api_token',60)->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
