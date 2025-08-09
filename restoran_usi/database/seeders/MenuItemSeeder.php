<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use App\Models\MenuCategorie;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dohvati kategorije unutar metode
        $appetizers = MenuCategorie::where('name', 'Appetizers')->first()->category_id;
        $grilled = MenuCategorie::where('name', 'Grilled Dishes')->first()->category_id;
        $fish = MenuCategorie::where('name', 'Fish & Seafood')->first()->category_id;
        $beverages = MenuCategorie::where('name', 'Beverages')->first()->category_id;
        $desserts = MenuCategorie::where('name', 'Desserts')->first()->category_id;
        $salads = MenuCategorie::where('name', 'Salads')->first()->category_id;
        $soups = MenuCategorie::where('name', 'Soups')->first()->category_id;
        $pasta = MenuCategorie::where('name', 'Pasta & Rice')->first()->category_id;

        // Ručno ubacivanje menu itema
        $items = [
            ['name' => 'Bruschetta', 'price' => 5.99, 'menu_categorie_id' => $appetizers, 'image' => 'images/menu_items/bruschetta.jpg'],
            ['name' => 'Garlic Bread', 'price' => 3.99, 'menu_categorie_id' => $appetizers, 'image' => 'images/menu_items/garlic_bread.jpg'],
            ['name' => 'Grilled Steak', 'price' => 18.99, 'menu_categorie_id' => $grilled, 'image' => 'images/menu_items/grilled_steak.jpg'],
            ['name' => 'BBQ Chicken', 'price' => 15.99, 'menu_categorie_id' => $grilled, 'image' => 'images/menu_items/bbq_chicken.jpg'],
            ['name' => 'Trout', 'price' => 16.50, 'menu_categorie_id' => $fish, 'image' => 'images/menu_items/trout.jpg'],
            ['name' => 'Shrimp Cocktail', 'price' => 12.00, 'menu_categorie_id' => $fish, 'image' => 'images/menu_items/shrimp_cocktail.jpg'],
            ['name' => 'Lemonade', 'price' => 2.99, 'menu_categorie_id' => $beverages, 'image' => 'images/menu_items/lemonade.jpg'],
            ['name' => 'Red Wine', 'price' => 8.50, 'menu_categorie_id' => $beverages, 'image' => 'images/menu_items/red_wine.jpg'],
            ['name' => 'Cheesecake', 'price' => 6.99, 'menu_categorie_id' => $desserts, 'image' => 'images/menu_items/cheesecake.jpg'],
            ['name' => 'Chocolate Mousse', 'price' => 5.50, 'menu_categorie_id' => $desserts, 'image' => 'images/menu_items/chocolate_mousse.jpg'],
            ['name' => 'Caesar Salad', 'price' => 7.99, 'menu_categorie_id' => $salads, 'image' => 'images/menu_items/caesar_salad.jpg'],
            ['name' => 'Greek Salad', 'price' => 7.50, 'menu_categorie_id' => $salads, 'image' => 'images/menu_items/greek_salad.jpg'],
            ['name' => 'Tomato Soup', 'price' => 4.99, 'menu_categorie_id' => $soups, 'image' => 'images/menu_items/tomato_soup.jpg'],
            ['name' => 'Chicken Noodle Soup', 'price' => 5.99, 'menu_categorie_id' => $soups, 'image' => 'images/menu_items/chicken_noodle_soup.jpg'],
            ['name' => 'Spaghetti Carbonara', 'price' => 11.99, 'menu_categorie_id' => $pasta, 'image' => 'images/menu_items/spaghetti_carbonara.jpg'],
            ['name' => 'Risotto', 'price' => 13.99, 'menu_categorie_id' => $pasta, 'image' => 'images/menu_items/risotto.jpg'],
            ['name' => 'Margherita Pizza', 'price' => 10.50, 'menu_categorie_id' => $pasta, 'image' => 'images/menu_items/margherita_pizza.jpg'],
            ['name' => 'Fettuccine Alfredo', 'price' => 12.50, 'menu_categorie_id' => $pasta, 'image' => 'images/menu_items/fettuccine_alfredo.jpg'],
            ['name' => 'Roasted Vegetables', 'price' => 8.00, 'menu_categorie_id' => $grilled, 'image' => 'images/menu_items/roasted_vegetables.jpg'],
            ['name' => 'Fruit Salad', 'price' => 6.00, 'menu_categorie_id' => $salads, 'image' => 'images/menu_items/fruit_salad.jpg'],
            ['name' => 'Iced Tea', 'price' => 2.50, 'menu_categorie_id' => $beverages, 'image' => 'images/menu_items/iced_tea.jpg'],
            ['name' => 'Grilled Salmon', 'price' => 17.50, 'menu_categorie_id' => $fish, 'image' => 'images/menu_items/grilled_salmon.jpg'],
            ['name' => 'Chocolate Cake', 'price' => 6.50, 'menu_categorie_id' => $desserts, 'image' => 'images/menu_items/chocolate_cake.jpg'],
            ['name' => 'French Fries', 'price' => 3.99, 'menu_categorie_id' => $appetizers, 'image' => 'images/menu_items/french_fries.jpg'],
            ['name' => 'Onion Rings', 'price' => 4.50, 'menu_categorie_id' => $appetizers, 'image' => 'images/menu_items/onion_rings.jpg'],
            ['name' => 'Minestrone Soup', 'price' => 5.50, 'menu_categorie_id' => $soups, 'image' => 'images/menu_items/minestrone_soup.jpg'],
            ['name' => 'Tiramisu', 'price' => 7.00, 'menu_categorie_id' => $desserts, 'image' => 'images/menu_items/tiramisu.jpg'],
            ['name' => 'Coke', 'price' => 1.99, 'menu_categorie_id' => $beverages, 'image' => 'images/menu_items/coke.jpg'],
            ['name' => 'Penne Arrabbiata', 'price' => 11.50, 'menu_categorie_id' => $pasta, 'image' => 'images/menu_items/penne_arrabbiata.jpg'],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
