<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('branch_admin_id');
            $table->unsignedBigInteger('new_loan_application_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('branch_admin_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('new_loan_application_id')->references('id')->on('new_loan_application')->cascadeOnDelete();
            $table->unique(['branch_admin_id', 'new_loan_application_id'], 'customer_ratings_unique_per_request');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_ratings');
    }
};
