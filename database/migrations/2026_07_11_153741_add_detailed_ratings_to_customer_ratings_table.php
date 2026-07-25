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
        Schema::table('customer_ratings', function (Blueprint $table) {
            $table->integer('information_accuracy')->after('rating')->nullable();
            $table->integer('behavior')->after('information_accuracy')->nullable();
            $table->integer('response_time')->after('behavior')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_ratings', function (Blueprint $table) {
            $table->dropColumn(['information_accuracy', 'behavior', 'response_time']);
        });
    }
};
