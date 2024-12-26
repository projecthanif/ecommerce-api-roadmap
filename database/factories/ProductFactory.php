<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use League\CommonMark\Normalizer\SlugNormalizer;

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
        $name = $this->faker->name();

        return [
            'name' => $name,
            'slug' => (new SlugNormalizer())->normalize($name),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(1000, 10000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'category_id' => CategoryFactory::new(),
            'brand_id' => $this->faker->randomElement([null, BrandFactory::new()]),
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
