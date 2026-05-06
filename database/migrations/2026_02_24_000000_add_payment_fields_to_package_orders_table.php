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
        Schema::table('package_orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
            $table->string('txn_number')->nullable()->after('payment_method');
            $table->string('bank_name')->nullable()->after('txn_number');
            $table->string('account_no')->nullable()->after('bank_name');
            $table->string('phone')->nullable()->after('account_no');
            $table->string('screenshot')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'txn_number', 'bank_name', 'account_no', 'phone', 'screenshot']);
        });
    }
};
