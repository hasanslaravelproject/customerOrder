<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'delivery' => $this->faker->date,
            'number_of_guest' => $this->faker->randomNumber(0),
            'menu_id' => \App\Models\Menu::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
