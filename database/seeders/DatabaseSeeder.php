<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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

        // Asociar carreras a estudiantes con sus respectivos turnos
        $allStudents = $studentsMatriculados->concat($studentsEgresados);
        $allStudents->each(function ($student) use ($careers) {
            $selectedCareers = $careers->random(rand(1, 2));
            $attachData = [];
            foreach ($selectedCareers as $career) {
                $availableShifts = $career->shifts ?? ["Mañana"];
                $randomShift = $availableShifts[array_rand($availableShifts)];
                
                $entryYear = rand(2015, 2024);
                $graduationYear = null;
                if ($student->status === "egresado" || rand(1, 100) <= 30) {
                    $graduationYear = $entryYear + rand(3, 4);
                }

                $attachData[$career->id] = [
                    "shift" => $randomShift,
                    "entry_year" => $entryYear,
                    "graduation_year" => $graduationYear,
                ];

                // Create the 3 EFSRT records for this student and career
                foreach (["MODULO I", "MODULO II", "MODULO III"] as $module) {
                    $student->efsrtRecords()->create([
                        "career_id" => $career->id,
                        "module_name" => $module,
                        "status" => "pendiente"
                    ]);
                }
            }
            $student->careers()->attach($attachData);

            // Seed student job info if titled (has graduation_year on any career)
            $hasGraduationYear = false;
            foreach ($attachData as $cData) {
                if (!empty($cData["graduation_year"])) {
                    $hasGraduationYear = true;
                    break;
                }
            }

            if ($hasGraduationYear) {
                $jobs = [
                    ["Analista de Sistemas", "Banco de la Nación", true],
                    ["Desarrollador Web Junior", "Software Solution S.A.C.", true],
                    ["Soporte Técnico Especialista", "Clínica San Borja", true],
                    ["Administrador de Base de Datos", "Ministerio Público", true],
                    ["Asistente Contable", "Estudio Contable Alza & Asociados", true],
                    ["Cajero Principal", "Supermercados Plaza Vea", false],
                    ["Recepcionista", "Hotel Los Portales", false],
                ];
                $selectedJob = $jobs[array_rand($jobs)];
                $student->job()->create([
                    "current_job" => $selectedJob[0],
                    "workplace" => $selectedJob[1],
                    "is_related" => $selectedJob[2],
                ]);
            }
        });

        $this->call(CourseSeeder::class);

        // Asociar cursos a estudiantes
        $allCourses = \App\Models\Course::all();
        $allStudents->each(function ($student) use ($allCourses) {
            // Find courses belonging to student's careers
            $studentCareerIds = $student->careers->pluck("id");
            $studentCourses = $allCourses->whereIn("career_id", $studentCareerIds);

            if ($studentCourses->isNotEmpty()) {
                // Attach a random subset of courses
                $selectedCourses = $studentCourses->random(min(rand(1, 3), $studentCourses->count()));
                $selectedCourses->each(function ($course) use ($student) {
                    $grade = rand(5, 20);
                    $status = $grade >= 11 ? "aprobado" : "desaprobado";
                    $student->courses()->attach($course->id, [
                        "grade" => $grade,
                        "status" => $status,
                    ]);
                });
            }
        });

        // Actualizar aleatoriamente algunos registros EFSRT con notas, horas y empresas
        $companies = ["Soporte TI S.A.C.", "Soluciones Web E.I.R.L.", "Consultoría Contable S.A.", "Clínica San Juan", "Farmacia Salud"];
        $allStudents->each(function ($student) use ($companies) {
            $student->load('efsrtRecords');
            $student->efsrtRecords->each(function ($efsrt) use ($companies) {
                $index = $efsrt->module_name === "MODULO I" ? 0 : ($efsrt->module_name === "MODULO II" ? 1 : 2);
                // MODULO I has 70% chance of being approved, MODULO II has 40%, MODULO III has 10%
                $chance = $index == 0 ? 70 : ($index == 1 ? 40 : 10);
                if (rand(1, 100) <= $chance) {
                    $grade = rand(11, 20);
                    $efsrt->update([
                        "grade" => $grade,
                        "hours" => rand(150, 300),
                        "company" => $companies[array_rand($companies)],
                        "status" => "aprobado",
                    ]);
                } elseif (rand(1, 100) <= 20) { // 20% chance of failed/disapproved
                    $grade = rand(5, 10);
                    $efsrt->update([
                        "grade" => $grade,
                        "hours" => rand(50, 120),
                        "company" => $companies[array_rand($companies)],
                        "status" => "desaprobado",
                    ]);
                }
            });
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
