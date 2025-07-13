<?php

namespace Database\Seeders;

use App\Models\MenuCategorie;
use Illuminate\Database\Seeder;

class MenuCategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuCategorie::factory()
            ->count(5)
            ->create();
    }
}
