<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'title' => $this->faker->words(3, true),
        
            'description' => $this->faker->paragraphs(2, true),
            'price' => $this->faker->numberBetween(50, 10000),
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'stock' => $this->faker->numberBetween(0, 200),
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'is_active' => $this->faker->boolean(85) ? 1 : 0,
        ];
    }
}
