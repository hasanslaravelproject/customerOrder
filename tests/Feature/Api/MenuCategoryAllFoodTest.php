<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Food;
use App\Models\MenuCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuCategoryAllFoodTest extends TestCase
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
    public function it_gets_menu_category_all_food()
    {
        $menuCategory = MenuCategory::factory()->create();
        $allFood = Food::factory()
            ->count(2)
            ->create([
                'menu_category_id' => $menuCategory->id,
            ]);

        $response = $this->getJson(
            route('api.menu-categories.all-food.index', $menuCategory)
        );

        $response->assertOk()->assertSee($allFood[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_category_all_food()
    {
        $menuCategory = MenuCategory::factory()->create();
        $data = Food::factory()
            ->make([
                'menu_category_id' => $menuCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.menu-categories.all-food.store', $menuCategory),
            $data
        );

        $this->assertDatabaseHas('food', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $food = Food::latest('id')->first();

        $this->assertEquals($menuCategory->id, $food->menu_category_id);
    }
}
