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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nid_number');
            $table->text('present_address');
            $table->text('permanent_address')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('occupation');
            $table->string('monthly_income');
            $table->decimal('loan_amount', 15, 2);
            $table->integer('tenure_months');
            $table->enum('employment_type', ['employed', 'self-employed', 'business', 'professional', 'student']);
            $table->string('company_name')->nullable();
            $table->text('purpose_of_loan');

            // Document paths (JSON array to store multiple documents)
            $table->json('documents')->nullable();

            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
