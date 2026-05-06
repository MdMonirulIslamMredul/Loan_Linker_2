<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'customer' to the role enum
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('super_admin','bank_admin','branch_admin','customer') NOT NULL DEFAULT 'branch_admin'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'customer' from enum (ensure no users have role 'customer' before running down)
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('super_admin','bank_admin','branch_admin') NOT NULL DEFAULT 'branch_admin'");
    }
};
