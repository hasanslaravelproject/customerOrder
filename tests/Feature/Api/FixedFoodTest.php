<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FixedFood;

use App\Models\Unit;
use App\Models\MenuCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FixedFoodTest extends TestCase
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
    public function it_gets_fixed_foods_list()
    {
        $fixedFoods = FixedFood::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.fixed-foods.index'));

        $response->assertOk()->assertSee($fixedFoods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_fixed_food()
    {
        $data = FixedFood::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.fixed-foods.store'), $data);

        $this->assertDatabaseHas('fixed_foods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_fixed_food()
    {
        $fixedFood = FixedFood::factory()->create();

        $menuCategory = MenuCategory::factory()->create();
        $unit = Unit::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'divnumber' => $this->faker->randomNumber(0),
            'menu_category_id' => $menuCategory->id,
            'unit_id' => $unit->id,
        ];

        $response = $this->putJson(
            route('api.fixed-foods.update', $fixedFood),
            $data
        );

        $data['id'] = $fixedFood->id;

        $this->assertDatabaseHas('fixed_foods', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_fixed_food()
    {
        $fixedFood = FixedFood::factory()->create();

        $response = $this->deleteJson(
            route('api.fixed-foods.destroy', $fixedFood)
        );

        $this->assertDeleted($fixedFood);

        $response->assertNoContent();
    }
}
