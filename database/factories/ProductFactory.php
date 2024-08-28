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
            'name' => fake()->name(),
            'description' => fake()->text(100),
            'stock' => fake()->numberBetween(0,100),
            'price' => fake()->randomFloat(2,10,500),
            'rating' => fake()->randomFloat(0,1,5),
            'image' => fake()->image(storage_path('app/public'), 500, 500, null, false),
            'category_id' => 1,
        ];
    }
}
