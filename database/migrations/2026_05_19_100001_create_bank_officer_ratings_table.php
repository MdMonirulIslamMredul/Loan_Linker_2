<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_officer_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('officer_id');
            $table->unsignedBigInteger('new_loan_application_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('officer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('new_loan_application_id')->references('id')->on('new_loan_application')->cascadeOnDelete();
            $table->unique(['customer_id', 'new_loan_application_id', 'officer_id'], 'bank_officer_ratings_unique_per_officer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_officer_ratings');
    }
};
