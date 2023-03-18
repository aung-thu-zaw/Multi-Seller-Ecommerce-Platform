<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "category_id"=>fake()->numberBetween(1, 8),
            "name"=>fake()->unique()->name(),
            "slug"=>fake()->unique()->slug(),
            "image"=>fake()->imageUrl(),
            "status"=>fake()->randomElement(["show","hide"]),
            "created_at"=>fake()->dateTimeBetween("-3 months", now())
        ];
    }
}
