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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('bank_official_id')->nullable()->constrained('bank_officials')->nullOnDelete();
            $table->foreignId('officer_document_id')->nullable()->constrained('officer_documents')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['bank_official_id']);
            $table->dropForeign(['officer_document_id']);
            $table->dropColumn(['bank_official_id', 'officer_document_id']);
        });
    }
};
