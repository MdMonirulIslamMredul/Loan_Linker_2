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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('details1')->nullable();
            $table->text('details2')->nullable();
            $table->text('details3')->nullable();
            $table->text('details4')->nullable();
            $table->string('banner')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->decimal('min_amount', 15, 2)->nullable();
            $table->decimal('max_amount', 15, 2)->nullable();
            $table->integer('min_tenure_months')->nullable();
            $table->integer('max_tenure_months')->nullable();
            $table->text('eligibility')->nullable();
            $table->text('documents_required')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
