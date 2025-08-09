<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition(): array
    {
        return [
            'table_number' => $this->faker->unique()->numberBetween(20, 100),
            'status' => 1,  // Uvek slobodan sto kao default
        ];
    }

    public function free()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 1, // slobodan sto
            ];
        });
    }
}
