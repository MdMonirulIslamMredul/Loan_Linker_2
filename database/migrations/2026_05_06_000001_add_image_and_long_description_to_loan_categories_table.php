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
        Schema::table('loan_categories', function (Blueprint $table) {
            $table->text('long_description')->nullable()->after('description');
            $table->string('image')->nullable()->after('long_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_categories', function (Blueprint $table) {
            $table->dropColumn(['long_description', 'image']);
        });
    }
};
