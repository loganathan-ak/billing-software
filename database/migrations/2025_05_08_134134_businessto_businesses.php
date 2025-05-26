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
        Schema::create('businessto_businesses', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');
            $table->string('invoice_number')->nullable();
            $table->string('customer_id');
            $table->string('payment_status');
            $table->string('payment_method');
            $table->string('paid_amount')->nullable();
            $table->string('balance')->nullable();
            $table->json('item_details');
            $table->text('description')->nullable();
            $table->text('discount_percent')->nullable();
            $table->text('discount_amount')->nullable();
            $table->text('subtotal');
            $table->text('total_tax');
            $table->text('grand_total');
            $table->text('created_by')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
