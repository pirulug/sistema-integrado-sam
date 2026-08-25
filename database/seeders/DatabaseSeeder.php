<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Curriculum;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders de usuarios
        $this->call([
            AdminUserSeeder::class,
            TeacherUserSeeder::class,
        ]);

        $curriculum = Curriculum::create([
            "name" => "Malla Curricular 2020",
            "year" => "2020",
        ]);

        $curriculum2019 = Curriculum::create([
            "name" => "Malla Curricular 2019",
            "year" => "2019",
        ]);

        // Cargar cursos mediante seeder dedicado
        $this->call(CurseSeeder::class);

        // Create student: Marcelina Towne (completed all courses)
        $student1 = Student::create([
            "dni" => "91578591",
            "student_code" => "EST2019001",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Towne",
            "maternal_last_name" => "Smith",
            "first_name" => "Marcelina",
            "gender" => "Femenino",
            "personal_email" => "marcelina.towne@gmail.com",
            "institutional_email" => "mtowne@sam.edu.pe",
            "phone" => "014567890",
            "mobile" => "959705580",
            "admission_date" => "2019-03-15",
            "graduation_date" => "2022-12-20",
            "degree_date" => "2023-05-10",
            "curriculum_id" => $curriculum->id,
            "shift" => "Diurno (Mañana)",
        ]);

        // Attach all courses of this curriculum to Marcelina Towne
        $student1->courses()->attach($curriculum->courses->pluck("id"));

        // Create student: Juan Carlos Gomez Perez (completed some courses)
        $student2 = Student::create([
            "dni" => "12345678",
            "student_code" => "EST2026001",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Gomez",
            "maternal_last_name" => "Perez",
            "first_name" => "Juan Carlos",
            "gender" => "Masculino",
            "personal_email" => "juan.gomez@gmail.com",
            "institutional_email" => "jgomez@sam.edu.pe",
            "phone" => "014567890",
            "mobile" => "987654321",
            "admission_date" => "2026-03-01",
            "curriculum_id" => $curriculum->id,
            "shift" => "Nocturno (Noche)",
        ]);

        // Attach some courses of this curriculum
        $someCourses = $curriculum->courses->take(12); // completed 12 courses
        $student2->courses()->attach($someCourses->pluck("id"));

        // Llamar seeder de EFSRT
        $this->call(EfsrtSeeder::class);
    }
}
