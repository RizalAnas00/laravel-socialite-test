<?php

namespace Database\Factories;

use App\Models\Shirt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shirt>
 */
class ShirtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'stock' => $this->faker->numberBetween(1, 12),
            'price' => $this->faker->randomFloat(2, 9, 999),
            'description' => $this->faker->sentence(),
        ];
    }
}
