<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineBankingsTable extends Migration
{
    public function up()
    {
        Schema::create('online_bankings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->string('bank_name');
            $table->string('account_number');
            $table->timestamps();

            $table->foreign('transaction_id')->references('transaction_id')->on('payments');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_methods');
        });
    }

    public function down()
    {
        Schema::dropIfExists('online_bankings');
    }
}
