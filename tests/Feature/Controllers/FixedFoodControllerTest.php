<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FixedFood;

use App\Models\Unit;
use App\Models\MenuCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FixedFoodControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_fixed_foods()
    {
        $fixedFoods = FixedFood::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('fixed-foods.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.fixed_foods.index')
            ->assertViewHas('fixedFoods');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_fixed_food()
    {
        $response = $this->get(route('fixed-foods.create'));

        $response->assertOk()->assertViewIs('app.fixed_foods.create');
    }

    /**
     * @test
     */
    public function it_stores_the_fixed_food()
    {
        $data = FixedFood::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('fixed-foods.store'), $data);

        $this->assertDatabaseHas('fixed_foods', $data);

        $fixedFood = FixedFood::latest('id')->first();

        $response->assertRedirect(route('fixed-foods.edit', $fixedFood));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_fixed_food()
    {
        $fixedFood = FixedFood::factory()->create();

        $response = $this->get(route('fixed-foods.show', $fixedFood));

        $response
            ->assertOk()
            ->assertViewIs('app.fixed_foods.show')
            ->assertViewHas('fixedFood');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_fixed_food()
    {
        $fixedFood = FixedFood::factory()->create();

        $response = $this->get(route('fixed-foods.edit', $fixedFood));

        $response
            ->assertOk()
            ->assertViewIs('app.fixed_foods.edit')
            ->assertViewHas('fixedFood');
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

        $response = $this->put(route('fixed-foods.update', $fixedFood), $data);

        $data['id'] = $fixedFood->id;

        $this->assertDatabaseHas('fixed_foods', $data);

        $response->assertRedirect(route('fixed-foods.edit', $fixedFood));
    }

    /**
     * @test
     */
    public function it_deletes_the_fixed_food()
    {
        $fixedFood = FixedFood::factory()->create();

        $response = $this->delete(route('fixed-foods.destroy', $fixedFood));

        $response->assertRedirect(route('fixed-foods.index'));

        $this->assertDeleted($fixedFood);
    }
}
