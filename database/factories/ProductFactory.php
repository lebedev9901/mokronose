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
        'preview' => $this->faker->word(4, true),
        'description' => $this->faker->paragraph(),
        'price' => $this->faker->numberBetween(300, 5000),
        'rating' => $this->faker->randomFloat(1, 3, 5),
        'stock' => $this->faker->numberBetween(0, 50),
        'weight' => $this->faker->numberBetween(0, 50),
        'is_active' => '1',
        ];
    }
}
