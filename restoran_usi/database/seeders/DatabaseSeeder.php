<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        // Prvo tipovi korisnika
        $this->call(UserTypeSeeder::class);

        // Onda korisnici
        $this->call(UserSeeder::class);

        // Ostali seederi
        $this->call(MenuCategorieSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(TableSeeder::class);
    }
}
