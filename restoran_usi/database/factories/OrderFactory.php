<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->dateTime(),
            'is_paid' => $this->faker->boolean(),
            'total_price' => $this->faker->randomNumber(1),
            'payment_method' => '',
            'user_id' => \App\Models\User::factory(),
            'table_id' => \App\Models\Table::factory(),
        ];
    }
}
