<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\District;
use App\Models\Thana;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SuperAdminBranchFilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('banks', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('districts', function ($table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('thanas', function ($table) {
            $table->id();
            $table->unsignedBigInteger('district_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('branches', function ($table) {
            $table->id();
            $table->unsignedBigInteger('bank_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedBigInteger('districts_id')->nullable();
            $table->unsignedBigInteger('thana_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('users', function ($table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('thanas');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('banks');

        parent::tearDown();
    }

    public function test_branch_listing_can_be_filtered_by_bank_district_and_thana(): void
    {
        $bankOne = Bank::create(['name' => 'Bank One', 'code' => 'BANK-ONE', 'is_active' => true]);
        $bankTwo = Bank::create(['name' => 'Bank Two', 'code' => 'BANK-TWO', 'is_active' => true]);

        $districtOne = District::create(['division_id' => 1, 'name' => 'Dhaka', 'slug' => 'dhaka']);
        $districtTwo = District::create(['division_id' => 1, 'name' => 'Chittagong', 'slug' => 'chittagong']);

        $thanaOne = Thana::create(['district_id' => $districtOne->id, 'name' => 'Dhanmondi']);
        $thanaTwo = Thana::create(['district_id' => $districtTwo->id, 'name' => 'GEC']);

        $matchingBranch = Branch::create([
            'bank_id' => $bankOne->id,
            'name' => 'Matching Branch',
            'code' => 'BR-001',
            'districts_id' => $districtOne->id,
            'thana_id' => $thanaOne->id,
            'is_active' => true,
        ]);

        Branch::create([
            'bank_id' => $bankTwo->id,
            'name' => 'Other Branch',
            'code' => 'BR-002',
            'districts_id' => $districtTwo->id,
            'thana_id' => $thanaTwo->id,
            'is_active' => true,
        ]);

        $this->withoutMiddleware();

        $response = $this->get(route('super-admin.branches.index', [
            'bank_id' => $bankOne->id,
            'district_id' => $districtOne->id,
            'thana_id' => $thanaOne->id,
        ]));

        $response->assertOk();
        $response->assertSee($matchingBranch->name);
        $response->assertDontSee('Other Branch');
    }
}
