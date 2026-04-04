<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition(): array
    {
        $name = $this->faker->words(4, true);
        $categories = ['aventura', 'cultural', 'natureza', 'gastronomia', 'praia', 'safari', 'historico'];
        $difficulties = ['facil', 'moderado', 'dificil'];
        $cities = ['Luanda', 'Benguela', 'Malanje', 'Lubango', 'Namibe', 'Huambo'];
        $provinces = ['Luanda', 'Benguela', 'Malanje', 'Huíla', 'Namibe', 'Huambo'];

        return [
            'name'              => ucfirst($name),
            'slug'              => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description'       => $this->faker->paragraphs(3, true),
            'short_description' => $this->faker->sentence(15),
            'city'              => $this->faker->randomElement($cities),
            'province'          => $this->faker->randomElement($provinces),
            'location'          => $this->faker->address(),
            'price'             => $this->faker->numberBetween(5000, 200000),
            'duration_days'     => $this->faker->numberBetween(1, 7),
            'max_participants'  => $this->faker->numberBetween(5, 30),
            'available_spots'   => $this->faker->numberBetween(0, 20),
            'category'          => $this->faker->randomElement($categories),
            'difficulty'        => $this->faker->randomElement($difficulties),
            'is_active'         => true,
            'is_featured'       => false,
            'rating_average'    => 0.00,
            'reviews_count'     => 0,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
