<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Food;

use App\Models\Unit;
use App\Models\MenuCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodControllerTest extends TestCase
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
    public function it_displays_index_view_with_all_food()
    {
        $allFood = Food::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('all-food.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.all_food.index')
            ->assertViewHas('allFood');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_food()
    {
        $response = $this->get(route('all-food.create'));

        $response->assertOk()->assertViewIs('app.all_food.create');
    }

    /**
     * @test
     */
    public function it_stores_the_food()
    {
        $data = Food::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('all-food.store'), $data);

        $this->assertDatabaseHas('food', $data);

        $food = Food::latest('id')->first();

        $response->assertRedirect(route('all-food.edit', $food));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_food()
    {
        $food = Food::factory()->create();

        $response = $this->get(route('all-food.show', $food));

        $response
            ->assertOk()
            ->assertViewIs('app.all_food.show')
            ->assertViewHas('food');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_food()
    {
        $food = Food::factory()->create();

        $response = $this->get(route('all-food.edit', $food));

        $response
            ->assertOk()
            ->assertViewIs('app.all_food.edit')
            ->assertViewHas('food');
    }

    /**
     * @test
     */
    public function it_updates_the_food()
    {
        $food = Food::factory()->create();

        $menuCategory = MenuCategory::factory()->create();
        $unit = Unit::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'divnumber' => $this->faker->randomNumber(0),
            'menu_category_id' => $menuCategory->id,
            'unit_id' => $unit->id,
        ];

        $response = $this->put(route('all-food.update', $food), $data);

        $data['id'] = $food->id;

        $this->assertDatabaseHas('food', $data);

        $response->assertRedirect(route('all-food.edit', $food));
    }

    /**
     * @test
     */
    public function it_deletes_the_food()
    {
        $food = Food::factory()->create();

        $response = $this->delete(route('all-food.destroy', $food));

        $response->assertRedirect(route('all-food.index'));

        $this->assertDeleted($food);
    }
}
