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
            $table->string('reference')->nullable()->after('password');
            $table->unsignedBigInteger('c_upazila_id')->nullable()->after('c_district_id');
            $table->unsignedBigInteger('c_thana_id')->nullable()->after('c_upazila_id');
            $table->unsignedBigInteger('p_upazila_id')->nullable()->after('p_district_id');
            $table->unsignedBigInteger('p_thana_id')->nullable()->after('p_upazila_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'reference',
                'c_upazila_id',
                'c_thana_id',
                'p_upazila_id',
                'p_thana_id',
            ]);
        });
    }
};
