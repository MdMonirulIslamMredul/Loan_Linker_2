<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchAdminIdToLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            if (!Schema::hasColumn('loans', 'branch_admin_id')) {
                $table->unsignedBigInteger('branch_admin_id')->nullable()->after('category_id');
                $table->foreign('branch_admin_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            if (Schema::hasColumn('loans', 'branch_admin_id')) {
                $table->dropForeign(['branch_admin_id']);
                $table->dropColumn('branch_admin_id');
            }
        });
    }
}
