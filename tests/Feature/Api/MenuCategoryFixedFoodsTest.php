<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FixedFood;
use App\Models\MenuCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuCategoryFixedFoodsTest extends TestCase
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
    public function it_gets_menu_category_fixed_foods()
    {
        $menuCategory = MenuCategory::factory()->create();
        $fixedFoods = FixedFood::factory()
            ->count(2)
            ->create([
                'menu_category_id' => $menuCategory->id,
            ]);

        $response = $this->getJson(
            route('api.menu-categories.fixed-foods.index', $menuCategory)
        );

        $response->assertOk()->assertSee($fixedFoods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_category_fixed_foods()
    {
        $menuCategory = MenuCategory::factory()->create();
        $data = FixedFood::factory()
            ->make([
                'menu_category_id' => $menuCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.menu-categories.fixed-foods.store', $menuCategory),
            $data
        );

        $this->assertDatabaseHas('fixed_foods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fixedFood = FixedFood::latest('id')->first();

        $this->assertEquals($menuCategory->id, $fixedFood->menu_category_id);
    }
}
