<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Unit;
use App\Models\Food;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitAllFoodTest extends TestCase
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
    public function it_gets_unit_all_food()
    {
        $unit = Unit::factory()->create();
        $allFood = Food::factory()
            ->count(2)
            ->create([
                'unit_id' => $unit->id,
            ]);

        $response = $this->getJson(route('api.units.all-food.index', $unit));

        $response->assertOk()->assertSee($allFood[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_unit_all_food()
    {
        $unit = Unit::factory()->create();
        $data = Food::factory()
            ->make([
                'unit_id' => $unit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.units.all-food.store', $unit),
            $data
        );

        $this->assertDatabaseHas('food', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $food = Food::latest('id')->first();

        $this->assertEquals($unit->id, $food->unit_id);
    }
}
