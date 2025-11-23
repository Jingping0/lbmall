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
        
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('rating_id');
            $table->unsignedBigInteger('order_id');
            $table->bigInteger('product_item_id')->unsigned();
            $table->unsignedBigInteger('customer_id');
            $table->integer('rating_value');
            $table->text('rating_comment')->nullable();
            $table->string('rating_image')->nullable();
            $table->enum('rating_status', ['unrate', 'rate'])->default('unrate');

            $table->timestamps();

            // Foreign key constraints
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down():void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('rating_image');
        });
    }
};


