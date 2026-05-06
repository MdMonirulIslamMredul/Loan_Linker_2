<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameApprovedByToUpdatedByInPackageOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop existing foreign key on approved_by if exists, then rename column and re-add foreign key on updated_by
        Schema::table('package_orders', function (Blueprint $table) {
            // Some setups use the conventional FK name
            try {
                $table->dropForeign(['approved_by']);
            } catch (\Exception $e) {
                // ignore if not exists
            }
        });

        // Rename column preserving data
        DB::statement('ALTER TABLE package_orders CHANGE approved_by updated_by BIGINT UNSIGNED NULL');

        Schema::table('package_orders', function (Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_orders', function (Blueprint $table) {
            try {
                $table->dropForeign(['updated_by']);
            } catch (\Exception $e) {
            }
        });

        DB::statement('ALTER TABLE package_orders CHANGE updated_by approved_by BIGINT UNSIGNED NULL');

        Schema::table('package_orders', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }
}
