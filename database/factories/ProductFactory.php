<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'prices' => $this->faker->randomNumber(5),
            'category_id' => 1,
            'brand_id' => 4,
            'description' => $this->faker->sentence,
            'thumbnail' => 'https://stimg.cardekho.com/images/carexteriorimages/930x620/Audi/Q7/7002/1667718548867/front-left-side-47.jpg',
        ];
    }
}
