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
        Schema::table('about_us', function (Blueprint $table) {
            if (! Schema::hasColumn('about_us', 'working_hours')) {
                $table->string('working_hours')->nullable()->after('contact_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            if (Schema::hasColumn('about_us', 'working_hours')) {
                $table->dropColumn('working_hours');
            }
        });
    }
};
