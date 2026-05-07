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
        Schema::create('new_loan_application', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('expected_amount', 15, 2);
            $table->integer('tenure_months');
            $table->enum('service_category', ['credit_card', 'loan']);
            $table->enum('service_type', ['visa_credit_card', 'personal_loan']);
            $table->json('bank_ids')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'review', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_loan_application');
    }
};
