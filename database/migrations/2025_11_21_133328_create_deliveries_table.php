<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('delivery_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->string('username');
            $table->string('street');
            $table->string('area');
            $table->string('postcode');
            $table->string('phone');
            $table->enum('status', ['Collected','Shipping','OutOfShipping','Arrival']);
            $table->timestamps();
            
            // $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            // $table->foreign('address_id')->references('address_id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
