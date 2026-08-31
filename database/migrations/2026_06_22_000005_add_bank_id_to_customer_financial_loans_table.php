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
        Schema::table('customer_financial_loans', function (Blueprint $table) {
            $table->foreignId('bank_id')->nullable()->constrained('banks')->nullOnDelete()->after('service_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_financial_loans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bank_id');
        });
    }
};
