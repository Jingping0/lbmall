<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->date('orderDate');
            $table->enum('status', ['Preparing','Shipping','Receiving','Completed','Cancelled','ReturnAndRefund']);
            $table->float('subtotal');
            $table->string('serviceTax');
            $table->string('totalAmount');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->timestamps();

            // $table->foreign('staff_id')->references('user_id')->on('staffs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}