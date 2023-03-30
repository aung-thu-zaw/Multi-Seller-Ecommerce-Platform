<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductBanner>
 */
class ProductBannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title"=>fake()->word(),
            "description"=>fake()->sentence(),
            "image"=>fake()->imageUrl(),
            "url"=>fake()->url(),
            "is_active"=>true,
        ];
    }
}
