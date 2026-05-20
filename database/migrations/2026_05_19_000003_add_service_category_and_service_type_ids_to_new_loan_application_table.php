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
            $table->foreignId('service_category_id')->nullable()->after('service_category')->constrained('service_categories')->nullOnDelete();
            $table->foreignId('service_type_id')->nullable()->after('service_type')->constrained('service_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_loan_application', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);
            $table->dropForeign(['service_type_id']);
            $table->dropColumn(['service_category_id', 'service_type_id']);
        });
    }
};
