<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;

use App\Models\Menu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
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
    public function it_gets_orders_list()
    {
        $orders = Order::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.orders.index'));

        $response->assertOk()->assertSee($orders[0]->delivery);
    }

    /**
     * @test
     */
    public function it_stores_the_order()
    {
        $data = Order::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.orders.store'), $data);

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_order()
    {
        $order = Order::factory()->create();

        $menu = Menu::factory()->create();
        $user = User::factory()->create();

        $data = [
            'delivery' => $this->faker->date,
            'number_of_guest' => $this->faker->randomNumber(0),
            'menu_id' => $menu->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.orders.update', $order), $data);

        $data['id'] = $order->id;

        $this->assertDatabaseHas('orders', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_order()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson(route('api.orders.destroy', $order));

        $this->assertDeleted($order);

        $response->assertNoContent();
    }
}
