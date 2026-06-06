<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('lead_accesses', 'application_status')) {
            Schema::table('lead_accesses', function (Blueprint $table) {
                $table->string('application_status')->nullable()->after('newloan_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('lead_accesses', 'application_status')) {
            Schema::table('lead_accesses', function (Blueprint $table) {
                $table->dropColumn('application_status');
            });
        }
    }
};
