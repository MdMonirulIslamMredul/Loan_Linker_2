<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('lead_accesses', 'newloan_id')) {
            Schema::table('lead_accesses', function (Blueprint $table) {
                $table->foreignId('newloan_id')
                    ->nullable()
                    ->after('application_id');
            });
        }

        $uniqueIndex = DB::select("SHOW INDEX FROM lead_accesses WHERE Key_name = ?", ['lead_accesses_officer_newloan_unique']);
        if (empty($uniqueIndex)) {
            Schema::table('lead_accesses', function (Blueprint $table) {
                $table->unique(['officer_id', 'newloan_id'], 'lead_accesses_officer_newloan_unique');
            });
        }

        $foreignKey = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'lead_accesses' AND COLUMN_NAME = 'newloan_id' AND REFERENCED_TABLE_NAME = 'new_loan_application'");
        if (empty($foreignKey)) {
            Schema::table('lead_accesses', function (Blueprint $table) {
                $table->foreign('newloan_id', 'lead_accesses_newloan_id_foreign')
                    ->references('id')
                    ->on('new_loan_application')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('lead_accesses', function (Blueprint $table) {
            if (Schema::hasColumn('lead_accesses', 'newloan_id')) {
                $table->dropUnique('lead_accesses_officer_newloan_unique');
                $table->dropForeign(['newloan_id']);
                $table->dropColumn('newloan_id');
            }
        });
    }
};
