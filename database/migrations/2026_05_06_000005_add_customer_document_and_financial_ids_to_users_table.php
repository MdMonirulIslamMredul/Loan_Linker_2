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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('customer_document_id')->nullable()->constrained('customer_documents')->nullOnDelete();
            $table->foreignId('customer_financial_id')->nullable()->constrained('customer_financials')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['customer_document_id']);
            $table->dropForeign(['customer_financial_id']);
            $table->dropColumn(['customer_document_id', 'customer_financial_id']);
        });
    }
};
