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
        $entryYear = $this->faker->numberBetween(2018, 2024);
        $status = $this->faker->randomElement(["matriculado", "egresado", "retirado"]);
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $emailName = strtolower($firstName . '.' . $lastName);
        return [
            "name" => $firstName . ' ' . $lastName,
            "student_code" => 'EST-' . $this->faker->unique()->numerify("#####"),
            "document_number" => $this->faker->unique()->numerify("########"),
            "personal_email" => $emailName . "@gmail.com",
            "institutional_email" => $emailName . "@sam.edu.pe",
            "phone" => $this->faker->numerify("9########"),
            "whatsapp" => $this->faker->numerify("9########"),
            "status" => $status,
            "enrollment_date" => $this->faker->date(),
            "graduation_date" => $status === "egresado" ? $this->faker->date() : null,
            "entry_year" => $entryYear,
            "graduation_year" => $status === "egresado" ? $entryYear + $this->faker->numberBetween(4, 6) : null,
        ];
    }

    public function egresado(): static
    {
        return $this->state(fn (array $attributes) => [
            "status" => "egresado",
            "graduation_date" => $this->faker->date(),
            "graduation_year" => ($attributes["entry_year"] ?? 2020) + $this->faker->numberBetween(4, 6),
        ]);
    }
}
