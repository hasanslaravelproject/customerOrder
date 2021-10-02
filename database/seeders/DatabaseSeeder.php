<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(UserSeeder::class);
      /*   $this->call(CompanySeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(MenuCategorySeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(FixedFoodSeeder::class); */
    }
}
