<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            "name" => "admin",
            "email" => "admin@example.com",
            "password" => bcrypt("admin123"),
        ]);

        // Crear 10 alumnos matriculados
        Student::factory(10)->create([
            "status" => "matriculado",
        ]);

        // Crear 5 alumnos egresados
        Student::factory(5)->egresado()->create();
    }
}
