<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('order_id');
            $table->double('amount', 10,2);
            $table->dateTime('payment_date');
            $table->string('status')->default('Pending');
            $table->unsignedBigInteger('payment_method_id');
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_methods');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}