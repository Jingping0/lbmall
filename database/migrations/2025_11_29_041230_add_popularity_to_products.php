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
        Schema::table('product_items', function (Blueprint $table) {
            $table->unsignedBigInteger('click_count')->default(0);
            $table->unsignedBigInteger('cart_count')->default(0); 
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('product_items', function (Blueprint $table) {
    $table->dropColumn(['click_count', 'cart_count']);
});

    }
};
