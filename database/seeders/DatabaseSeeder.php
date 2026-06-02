<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
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
        $this->call(CareerSeeder::class);

        User::factory()->create([
            "name" => "admin",
            "email" => "admin@example.com",
            "password" => bcrypt("admin123"),
        ]);

        $careers = \App\Models\Career::all();

        // Crear 10 alumnos matriculados
        $studentsMatriculados = Student::factory(10)->create([
            "status" => "matriculado",
        ]);

        // Crear 5 alumnos egresados
        $studentsEgresados = Student::factory(5)->egresado()->create();

        // Asociar carreras a estudiantes
        $allStudents = $studentsMatriculados->concat($studentsEgresados);
        $allStudents->each(function ($student) use ($careers) {
            $student->careers()->attach(
                $careers->random(rand(1, 2))->pluck("id")->toArray()
            );
        });

        // Crear 10 profesores (8 activos y 2 inactivos)
        $teachersActivos = Teacher::factory(8)->create([
            "status" => "activo",
        ]);

        $teachersInactivos = Teacher::factory(2)->create([
            "status" => "inactivo",
        ]);

        // Asociar carreras a profesores
        $allTeachers = $teachersActivos->concat($teachersInactivos);
        $allTeachers->each(function ($teacher) use ($careers) {
            $teacher->careers()->attach(
                $careers->random(rand(1, 2))->pluck("id")->toArray()
            );
        });
    }
}
