<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_item_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_item_id')->references('product_item_id')->on('product_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
