<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => \App\Models\Company::factory(),
            'menu_category_id' => \App\Models\MenuCategory::factory(),
        ];
    }
}
