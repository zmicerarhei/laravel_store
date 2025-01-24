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
            'brand' => $this->faker->company,
            'release_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'link' => $this->faker->imageUrl(640, 480, 'products')
        ];
    }
}
