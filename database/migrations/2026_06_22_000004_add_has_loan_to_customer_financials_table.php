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
        Schema::table('customer_financials', function (Blueprint $table) {
            $table->boolean('has_loan')->nullable()->after('existing_loans_credit_cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_financials', function (Blueprint $table) {
            $table->dropColumn('has_loan');
        });
    }
};
