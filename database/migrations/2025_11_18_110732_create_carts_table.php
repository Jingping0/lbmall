<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}

