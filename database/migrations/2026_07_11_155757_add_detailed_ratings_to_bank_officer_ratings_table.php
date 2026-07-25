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
        Schema::table('bank_officer_ratings', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->change();
            $table->integer('professionalism')->after('rating')->nullable();
            $table->integer('behavior')->after('professionalism')->nullable();
            $table->integer('response_time')->after('behavior')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_officer_ratings', function (Blueprint $table) {
            $table->integer('rating')->change();
            $table->dropColumn(['professionalism', 'behavior', 'response_time']);
        });
    }
};
