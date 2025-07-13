<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'order_item_id' => \App\Models\OrderItem::factory(),
            'menu_categorie_id' => \App\Models\MenuCategorie::factory(),
        ];
    }
}
