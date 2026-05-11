<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Allow lead accesses that refer to new loan applications only.
        DB::statement('ALTER TABLE lead_accesses MODIFY application_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE lead_accesses MODIFY application_id BIGINT UNSIGNED NOT NULL');
    }
};
