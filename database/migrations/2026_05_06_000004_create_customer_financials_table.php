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
        Schema::create('customer_financials', function (Blueprint $table) {
            $table->id();
            $table->decimal('salary_by_bank', 15, 2)->nullable();
            $table->decimal('salary_by_hand', 15, 2)->nullable();
            $table->decimal('monthly_bank_transaction', 15, 2)->nullable();
            $table->text('existing_loans_credit_cards')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_financials');
    }
};
