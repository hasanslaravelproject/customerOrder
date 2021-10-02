<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\Order;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuOrdersTest extends TestCase
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
    public function it_gets_menu_orders()
    {
        $menu = Menu::factory()->create();
        $orders = Order::factory()
            ->count(2)
            ->create([
                'menu_id' => $menu->id,
            ]);

        $response = $this->getJson(route('api.menus.orders.index', $menu));

        $response->assertOk()->assertSee($orders[0]->delivery);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_orders()
    {
        $menu = Menu::factory()->create();
        $data = Order::factory()
            ->make([
                'menu_id' => $menu->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.menus.orders.store', $menu),
            $data
        );

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $order = Order::latest('id')->first();

        $this->assertEquals($menu->id, $order->menu_id);
    }
}
