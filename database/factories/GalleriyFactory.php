<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'url_image' => $this->faker->imageUrl(),
            'index' => $this->faker->randomNumber(),
            'product_id' => function () {
                return \App\Models\Product::factory()->create()->id;
            },
        ];
    }
}
