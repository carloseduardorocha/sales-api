<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id'  => fake()->numberBetween(1, 15),
            'amount'     => $this->faker->randomFloat(2, 10, 3000),
            'sale_date'  => $this->faker->date(),
            'commission' => function(array $attributes) {
                return $attributes['amount'] * 0.085;
            },
        ];
    }
}
