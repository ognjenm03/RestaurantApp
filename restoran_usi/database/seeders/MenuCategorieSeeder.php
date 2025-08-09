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
        $categories = [
            'Appetizers',
            'Grilled Dishes',
            'Fish & Seafood',
            'Beverages',
            'Desserts',
            'Salads',
            'Soups',
            'Pasta & Rice'
        ];

        foreach ($categories as $category) {
            MenuCategorie::create(['name' => $category]);
        }
    }
}
