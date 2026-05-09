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
            $table->date('dob')->nullable()->after('phone');
            $table->text('contact_address')->nullable()->after('dob');
            $table->text('permanent_address')->nullable()->after('contact_address');
            $table->string('education')->nullable()->after('permanent_address');
            $table->string('profession')->nullable()->after('education');
            $table->string('organization_name')->nullable()->after('profession');
            $table->string('designation')->nullable()->after('organization_name');
            $table->date('date_of_joining')->nullable()->after('designation');
            $table->string('total_working_experience')->nullable()->after('date_of_joining');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'dob',
                'contact_address',
                'permanent_address',
                'education',
                'profession',
                'organization_name',
                'designation',
                'date_of_joining',
                'total_working_experience',
            ]);
        });
    }
};
