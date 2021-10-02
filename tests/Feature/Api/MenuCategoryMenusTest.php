<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\MenuCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuCategoryMenusTest extends TestCase
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
    public function it_gets_menu_category_menus()
    {
        $menuCategory = MenuCategory::factory()->create();
        $menus = Menu::factory()
            ->count(2)
            ->create([
                'menu_category_id' => $menuCategory->id,
            ]);

        $response = $this->getJson(
            route('api.menu-categories.menus.index', $menuCategory)
        );

        $response->assertOk()->assertSee($menus[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_category_menus()
    {
        $menuCategory = MenuCategory::factory()->create();
        $data = Menu::factory()
            ->make([
                'menu_category_id' => $menuCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.menu-categories.menus.store', $menuCategory),
            $data
        );

        $this->assertDatabaseHas('menus', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $menu = Menu::latest('id')->first();

        $this->assertEquals($menuCategory->id, $menu->menu_category_id);
    }
}
