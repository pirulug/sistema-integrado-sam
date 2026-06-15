<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Career;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->words(3, true),
            "code" => strtoupper($this->faker->unique()->bothify("??-###")),
            "credits" => $this->faker->numberBetween(2, 5),
            "career_id" => Career::factory(),
        ];
    }
}
