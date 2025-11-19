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
            $table->id('user_id'); 
            //$table->id(''); 
            //$table->unsignedBigInteger('customerId')->nullable();
            //$table->unsignedBigInteger('staffId')->nullable();
        
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('email');
            $table->string('role')->nullable();
            $table->timestamps();

            //$table->foreign('user_id')->references('customerId')->on('customers');
            //$table->foreign('user_id')->references('staffId')->on('staff');
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
