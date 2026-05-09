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
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->id();
            $table->string('picture')->nullable();
            $table->string('nid')->nullable();
            $table->string('office_id')->nullable();
            $table->string('visiting_card')->nullable();
            $table->string('pay_slip')->nullable();
            $table->string('bank_statements')->nullable();
            $table->string('trade_license')->nullable();
            $table->string('lend_document')->nullable();
            $table->string('other_document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_documents');
    }
};
