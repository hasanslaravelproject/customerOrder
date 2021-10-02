<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Food::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'divnumber' => $this->faker->randomNumber(0),
            'menu_category_id' => \App\Models\MenuCategory::factory(),
            'unit_id' => \App\Models\Unit::factory(),
        ];
    }
}
