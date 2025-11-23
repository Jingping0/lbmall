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
        Schema::create('customer_service', function (Blueprint $table) {
            $table->id('cust_service_id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('issue_type', ['Payment','Shipping','General Enquireies','Order']);
            $table->string('cust_service_desc');
            $table->enum('status', ['Open', 'In Progress', 'Resolved'])->default('Open');
            $table->string('cust_service_image')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_service');
    }
};
