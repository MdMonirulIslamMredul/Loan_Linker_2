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
            $table->unsignedBigInteger('c_division_id')->nullable()->after('dob');
            $table->unsignedBigInteger('c_district_id')->nullable()->after('c_division_id');
            $table->unsignedBigInteger('p_division_id')->nullable()->after('permanent_address');
            $table->unsignedBigInteger('p_district_id')->nullable()->after('p_division_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'c_division_id',
                'c_district_id',
                'p_division_id',
                'p_district_id',
            ]);
        });
    }
};
