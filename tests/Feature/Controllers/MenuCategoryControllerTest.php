<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MenuCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuCategoryControllerTest extends TestCase
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
    public function it_displays_index_view_with_menu_categories()
    {
        $menuCategories = MenuCategory::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('menu-categories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.menu_categories.index')
            ->assertViewHas('menuCategories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_menu_category()
    {
        $response = $this->get(route('menu-categories.create'));

        $response->assertOk()->assertViewIs('app.menu_categories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_menu_category()
    {
        $data = MenuCategory::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('menu-categories.store'), $data);

        $this->assertDatabaseHas('menu_categories', $data);

        $menuCategory = MenuCategory::latest('id')->first();

        $response->assertRedirect(route('menu-categories.edit', $menuCategory));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_menu_category()
    {
        $menuCategory = MenuCategory::factory()->create();

        $response = $this->get(route('menu-categories.show', $menuCategory));

        $response
            ->assertOk()
            ->assertViewIs('app.menu_categories.show')
            ->assertViewHas('menuCategory');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_menu_category()
    {
        $menuCategory = MenuCategory::factory()->create();

        $response = $this->get(route('menu-categories.edit', $menuCategory));

        $response
            ->assertOk()
            ->assertViewIs('app.menu_categories.edit')
            ->assertViewHas('menuCategory');
    }

    /**
     * @test
     */
    public function it_updates_the_menu_category()
    {
        $menuCategory = MenuCategory::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->put(
            route('menu-categories.update', $menuCategory),
            $data
        );

        $data['id'] = $menuCategory->id;

        $this->assertDatabaseHas('menu_categories', $data);

        $response->assertRedirect(route('menu-categories.edit', $menuCategory));
    }

    /**
     * @test
     */
    public function it_deletes_the_menu_category()
    {
        $menuCategory = MenuCategory::factory()->create();

        $response = $this->delete(
            route('menu-categories.destroy', $menuCategory)
        );

        $response->assertRedirect(route('menu-categories.index'));

        $this->assertDeleted($menuCategory);
    }
}
