<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        $title = fake()->unique()->company() . ' Hotel';

        return [
            'category_id' => null,

            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),

            'city' => fake()->city(),
            'image' => 'hotels/default-hotel.jpg',

            'location' => fake()->city() . ', ' . fake()->country(),

            'description' => fake()->paragraph(),

            'price' => fake()->numberBetween(50, 500),

            'rate' => fake()->randomFloat(1, 3, 5),
        ];
    }
}