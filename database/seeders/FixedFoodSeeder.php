<?php

namespace Database\Seeders;

use App\Models\FixedFood;
use Illuminate\Database\Seeder;

class FixedFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FixedFood::factory()
            ->count(5)
            ->create();
    }
}
