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
        $stripe = new \Stripe\StripeClient('sk_test_51TFm30DDbaI7WObYoHctCdnaZMbgt7aB2X5WJ5PjdxJbxlvNXYiU546uXnK5nh0YHrAedL2ImxmW6JLgfR7N7UWM007lTEbIvT');

        $name = $this->faker->word();
        $stock = $this->faker->numberBetween(1, 12);
        $description = $this->faker->sentence();
        $shirtPrice = $this->faker->numberBetween(10, 100);

        $product = $stripe->products->create([
            'name' => $name,
            'description' => $description,
            'id' => $name,
        ]);

        $price = $stripe->prices->create([
            'currency' => 'usd',
            'unit_amount' => $shirtPrice * 100,
            'product' => $product->id,
        ]);

        return [
            'name' => $name,
            'code' => $price->id,
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'stock' => $stock,
            'price' => $shirtPrice,
            'description' => $description,
        ];
    }
}
