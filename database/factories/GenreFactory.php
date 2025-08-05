<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Genre>
 *
 * @psalm-suppress UnusedClass
 * Класс используется через вызов в DatabaseSeeder
 */
final class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return string[]
     *
     * @psalm-return array{name: string}
     */
    #[\Override]
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }
}
