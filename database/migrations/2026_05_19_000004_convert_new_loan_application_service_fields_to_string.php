<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `new_loan_application` MODIFY `service_category` VARCHAR(255) NULL");
        DB::statement("ALTER TABLE `new_loan_application` MODIFY `service_type` VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `new_loan_application` MODIFY `service_category` ENUM('credit_card','loan') NULL");
        DB::statement("ALTER TABLE `new_loan_application` MODIFY `service_type` ENUM('visa_credit_card','personal_loan') NULL");
    }
};
