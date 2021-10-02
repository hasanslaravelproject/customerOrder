<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Unit;
use App\Models\FixedFood;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitFixedFoodsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_unit_fixed_foods()
    {
        $unit = Unit::factory()->create();
        $fixedFoods = FixedFood::factory()
            ->count(2)
            ->create([
                'unit_id' => $unit->id,
            ]);

        $response = $this->getJson(route('api.units.fixed-foods.index', $unit));

        $response->assertOk()->assertSee($fixedFoods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_unit_fixed_foods()
    {
        $unit = Unit::factory()->create();
        $data = FixedFood::factory()
            ->make([
                'unit_id' => $unit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.units.fixed-foods.store', $unit),
            $data
        );

        $this->assertDatabaseHas('fixed_foods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fixedFood = FixedFood::latest('id')->first();

        $this->assertEquals($unit->id, $fixedFood->unit_id);
    }
}
