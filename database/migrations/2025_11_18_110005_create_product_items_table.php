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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id('product_item_id');
            $table->string('product_name');
            $table->double('product_price', 8, 2);
            $table->string('product_image');
            $table->string('product_desc'); // Assuming 'description' should be 'product_desc'
            $table->boolean('available')->default(true);
            $table->string('product_measurement'); // Adjust the data type if needed
            $table->string('product_subImage1')->nullable();
            $table->string('product_subImage2')->nullable();
            $table->string('product_subImage3')->nullable();
            $table->foreignId('category_id')->constrained('categories','category_id');
            $table->timestamps();
       });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
