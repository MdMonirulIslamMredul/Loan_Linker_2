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
        Schema::table('package_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('package_orders', 'expired_at')) {
                $table->timestamp('expired_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_orders', function (Blueprint $table) {
            if (Schema::hasColumn('package_orders', 'expired_at')) {
                $table->dropColumn('expired_at');
            }
        });
    }
};
