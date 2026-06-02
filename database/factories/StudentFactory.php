<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "document_number" => $this->faker->unique()->numerify("########"),
            "email" => $this->faker->unique()->safeEmail(),
            "phone" => $this->faker->phoneNumber(),
            "status" => $this->faker->randomElement(["matriculado", "egresado", "retirado"]),
            "enrollment_date" => $this->faker->date(),
            "graduation_date" => null,
        ];
    }

    public function egresado(): static
    {
        return $this->state(fn (array $attributes) => [
            "status" => "egresado",
            "graduation_date" => $this->faker->date(),
        ]);
    }
}
