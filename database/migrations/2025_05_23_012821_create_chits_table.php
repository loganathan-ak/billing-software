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
        Schema::create('chits', function (Blueprint $table) {
            $table->id();
            $table->string('chit_number');
            $table->foreignId('customer_id');
            $table->enum('chit_type', ['new', 'payment']);
            $table->date('start_date')->nullable()->comment('Only for new chit');
            $table->decimal('monthly_amount')->nullable()->comment('Only for new chit');
            $table->integer('total_months')->nullable()->comment('Only for new chit');
            $table->string('description')->nullable()->comment('Optional text for new chit');
            $table->date('payment_date')->nullable()->comment('Only for installment');
            $table->decimal('amount_paid')->nullable()->comment('Amount paid in a specific installment');
            $table->integer('month_number')->nullable()->comment('Which month (e.g., 1, 2, ..., 12)');
            $table->integer('discount_percent')->nullable()->comment('Optional discount percentage for new chit');
            $table->decimal('totally_paid_amount', 10, 2)->nullable();
            $table->decimal('wallet_balance', 10, 2)->nullable();
            $table->enum('due_status', ['paid', 'pending'])->nullable()->comment('Status of the installment payment');
            $table->enum('chit_status', ['completed', 'in_progress', 'cancelled'])->default('in_progress')->comment('Status of the chit');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chits');
    }
};
