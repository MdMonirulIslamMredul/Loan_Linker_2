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
        Schema::table('new_loan_application', function (Blueprint $table) {
            $table->boolean('admin_view')->default(0)->after('status');
            $table->boolean('branch_view')->default(0)->after('admin_view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_loan_application', function (Blueprint $table) {
            $table->dropColumn(['admin_view', 'branch_view']);
        });
    }
};
