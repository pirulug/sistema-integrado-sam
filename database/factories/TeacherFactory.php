<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
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
            "specialty" => $this->faker->randomElement(["Matemáticas", "Física", "Química", "Historia", "Geografía", "Lenguaje", "Inglés", "Educación Física"]),
            "status" => $this->faker->randomElement(["activo", "inactivo"]),
            "hire_date" => $this->faker->date(),
        ];
    }
}
