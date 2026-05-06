<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('officer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('application_id')->constrained('loan_applications')->onDelete('cascade');
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();
            $table->unique(['officer_id', 'application_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_accesses');
    }
};
