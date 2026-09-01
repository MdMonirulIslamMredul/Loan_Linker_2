<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('districts_id')->nullable()->after('address');
            $table->unsignedBigInteger('thana_id')->nullable()->after('districts_id');
        });

        DB::statement('ALTER TABLE `branches` DROP INDEX `branches_code_unique`');
        DB::statement('ALTER TABLE `branches` MODIFY `code` VARCHAR(50) NULL');

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn(['city', 'state']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
        });

        DB::statement('ALTER TABLE `branches` MODIFY `code` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `branches` ADD UNIQUE `branches_code_unique` (`code`)');

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn(['districts_id', 'thana_id']);
        });
    }
};
