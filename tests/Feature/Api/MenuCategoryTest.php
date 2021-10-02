<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MenuCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuCategoryTest extends TestCase
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
    public function it_gets_menu_categories_list()
    {
        $menuCategories = MenuCategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.menu-categories.index'));

        $response->assertOk()->assertSee($menuCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_category()
    {
        $data = MenuCategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.menu-categories.store'), $data);

        $this->assertDatabaseHas('menu_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.menu-categories.update', $menuCategory),
            $data
        );

        $data['id'] = $menuCategory->id;

        $this->assertDatabaseHas('menu_categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_menu_category()
    {
        $menuCategory = MenuCategory::factory()->create();

        $response = $this->deleteJson(
            route('api.menu-categories.destroy', $menuCategory)
        );

        $this->assertDeleted($menuCategory);

        $response->assertNoContent();
    }
}
