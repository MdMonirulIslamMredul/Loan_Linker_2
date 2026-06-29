<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Thana;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SuperAdminThanaSearchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('thanas');
        Schema::dropIfExists('districts');

        parent::tearDown();
    }

    public function test_thana_search_uses_qualified_column_name_for_joined_queries(): void
    {
        $district = District::create([
            'division_id' => 1,
            'name' => 'Fakirhat',
            'slug' => 'fakirhat',
        ]);

        Thana::create([
            'district_id' => $district->id,
            'name' => 'Fakirhat',
        ]);

        Thana::create([
            'district_id' => $district->id,
            'name' => 'Another Thana',
        ]);

        $this->withoutMiddleware();

        $response = $this->get(route('super-admin.thanas.index', ['search' => 'Fakirhat']));

        $response->assertOk();
        $response->assertSee('Fakirhat');
        $response->assertDontSee('Another Thana');
    }

    public function test_pagination_links_preserve_search_and_district_filters(): void
    {
        $district = District::create([
            'division_id' => 1,
            'name' => 'Dhaka',
            'slug' => 'dhaka',
        ]);

        for ($i = 1; $i <= 25; $i++) {
            Thana::create([
                'district_id' => $district->id,
                'name' => 'Thana ' . $i,
            ]);
        }

        $this->withoutMiddleware();

        $response = $this->get(route('super-admin.thanas.index', [
            'search' => 'Thana',
            'district' => $district->id,
        ]));

        $response->assertOk();
        $response->assertSee('search=Thana', false);
        $response->assertSee('district=' . $district->id, false);
    }
}
