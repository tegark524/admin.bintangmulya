<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $packages = ['Paket 3x', 'Paket 5x', 'Paket 7x', 'Tambahan'];

    return [
        'name' => fake()->name(),
        'phone' => fake()->phoneNumber(),
        'address' => fake()->address(),
        'package' => fake()->randomElement($packages),
        'remaining_lessons' => fake()->numberBetween(0, 15),
        'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
    ];
}
}
