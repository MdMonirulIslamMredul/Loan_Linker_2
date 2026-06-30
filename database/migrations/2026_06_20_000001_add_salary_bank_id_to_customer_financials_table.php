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
            $table->foreignId('salary_bank_id')->nullable()->constrained('banks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_financials', function (Blueprint $table) {
            $table->dropForeign(['salary_bank_id']);
            $table->dropColumn('salary_bank_id');
        });
    }
};
