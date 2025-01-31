<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'brand_id' => $this->faker->numberBetween(1, 5),
            'category_id' => $this->faker->numberBetween(1, 3),
            'release_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'link' => 'https://picsum.photos/seed/' . $this->faker->word . '/640/480'
        ];
    }
}
