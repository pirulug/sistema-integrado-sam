<?php

namespace Database\Factories;

use App\Models\Career;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Career>
 */
class CareerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->unique()->word(),
            "code" => $this->faker->unique()->lexify("???"),
            "description" => $this->faker->sentence(),
            "status" => "activo",
        ];
    }
}
