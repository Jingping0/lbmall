<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardsTable extends Migration
{
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->string('card_holder_name');
            $table->string('card_number');
            $table->string('expiry_date');
            $table->string('cvv');
            $table->timestamps();

            $table->foreign('transaction_id')->references('transaction_id')->on('payments');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_methods');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_cards');
    }
}