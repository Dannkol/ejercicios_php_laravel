<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1,10),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug,
            'descripcion' => $this->faker->sentence(500),
            'estado' => $this->faker->boolean()
        ];
    }
}
