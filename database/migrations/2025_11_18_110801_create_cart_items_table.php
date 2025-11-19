<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cart_id')->unsigned();
            $table->bigInteger('product_item_id')->unsigned();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('cart_id')->references('cart_id')->on('carts');
            $table->foreign('product_item_id')->references('product_item_id')->on('product_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
