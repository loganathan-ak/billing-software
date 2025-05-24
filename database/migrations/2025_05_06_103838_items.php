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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable(); // Item name
            $table->string('product_name'); // Item name
            $table->string('hsn_code'); // Item name
            $table->string('price_per_unit'); // Item name
            $table->string('selling_price_per_unit'); // Item name
            $table->string('unit_id'); // e.g., Piece, Dozen, Set, Bundle
            $table->string('tax_type_id'); // e.g., GST, IGST, Exempt
            $table->integer('tax_percentage'); // Tax percentage, e.g., 5.00, 12.00
            $table->text('description')->nullable(); // Optional description
            $table->unsignedInteger('current_stock')->default(0);
            $table->timestamps(); // created_at, updated_at
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
