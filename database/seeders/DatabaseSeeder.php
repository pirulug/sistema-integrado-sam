<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Efsrt;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('teacher123'),
            'role' => 'teacher',
        ]);


        Teacher::create([
            'dni' => '87654321',
            'teacher_code' => 'DOC2026001',
            'paternal_last_name' => 'Ramirez',
            'maternal_last_name' => 'Soto',
            'first_name' => 'Maria Elena',
            'personal_email' => 'maria.ramirez@gmail.com',
            'institutional_email' => 'mramirez@instituto.edu.pe',
            'phone' => '013456789',
            'mobile' => '912345678',
            'hire_date' => '2020-03-01',
        ]);

        $curriculum = Curriculum::create([
            'name' => 'Malla Curricular 2020',
            'year' => '2020',
        ]);

        $csvPath = database_path('csv/sam_unidades.csv');
        if (file_exists($csvPath)) {
            $file = fopen($csvPath, 'r');
            $header = fgetcsv($file); // skip header
            
            $counters = [];
            while (($row = fgetcsv($file)) !== false) {
                // Programa Estudios,Periodo,Unidad Académica,Créditos,Horas
                $period = $row[1];
                $name = $row[2];
                $credits = (int)$row[3];
                $hours = (int)$row[4];
                
                if (!isset($counters[$period])) {
                    $counters[$period] = 1;
                } else {
                    $counters[$period]++;
                }
                
                $code = 'DPW-' . $period . '-' . str_pad($counters[$period], 2, '0', STR_PAD_LEFT);
                
                $course = Course::create([
                    'code' => $code,
                    'name' => $name,
                    'period' => $period,
                    'credits' => $credits,
                    'hours' => $hours,
                ]);
                
                $curriculum->courses()->attach($course->id);
            }
            fclose($file);
        }

        $efsrt1 = Efsrt::create([
            'module' => 'Módulo I',
            'module_name' => 'Diseño y Elaboración de Páginas Web',
        ]);

        $efsrt2 = Efsrt::create([
            'module' => 'Módulo II',
            'module_name' => 'Desarrollo de Aplicaciones Web',
        ]);

        $efsrt3 = Efsrt::create([
            'module' => 'Módulo III',
            'module_name' => 'Integración de Soluciones Web',
        ]);

        // Sync associations
        $curriculum->efsrts()->sync([$efsrt1->id, $efsrt2->id, $efsrt3->id]);

        // Create student: Marcelina Towne (completed all courses & EFSRTs)
        $student1 = Student::create([
            "dni" => "91578591",
            "student_code" => "EST2019001",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Towne",
            "maternal_last_name" => "Smith",
            "first_name" => "Marcelina",
            "gender" => "Femenino",
            "personal_email" => "marcelina.towne@gmail.com",
            "institutional_email" => "mtowne@instituto.edu.pe",
            "phone" => "014567890",
            "mobile" => "959705580",
            "admission_date" => "2019-03-15",
            "graduation_date" => "2022-12-20",
            "degree_date" => "2023-05-10",
            "curriculum_id" => $curriculum->id,
            "shift" => "Diurno (Mañana)",
        ]);

        // Attach all courses of this curriculum to Marcelina Towne
        $student1->courses()->attach($curriculum->courses->pluck('id'));

        // Attach and approve all 3 EFSRTs
        $student1->efsrts()->attach([
            $efsrt1->id => ['company_name' => 'Web Design Studio', 'hours' => 240, 'start_date' => '2020-01-15', 'end_date' => '2020-03-15', 'status' => 'approved'],
            $efsrt2->id => ['company_name' => 'App Developers Inc', 'hours' => 240, 'start_date' => '2021-01-15', 'end_date' => '2021-03-15', 'status' => 'approved'],
            $efsrt3->id => ['company_name' => 'Enterprise Solutions', 'hours' => 240, 'start_date' => '2022-01-15', 'end_date' => '2022-03-15', 'status' => 'approved'],
        ]);

        // Create student: Juan Carlos Gomez Perez (completed some courses & EFSRTs)
        $student2 = Student::create([
            "dni" => "12345678",
            "student_code" => "EST2026001",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Gomez",
            "maternal_last_name" => "Perez",
            "first_name" => "Juan Carlos",
            "gender" => "Masculino",
            "personal_email" => "juan.gomez@gmail.com",
            "institutional_email" => "jgomez@instituto.edu.pe",
            "phone" => "014567890",
            "mobile" => "987654321",
            "admission_date" => "2026-03-01",
            "curriculum_id" => $curriculum->id,
            "shift" => "Nocturno (Noche)",
        ]);

        // Attach some courses of this curriculum
        $someCourses = $curriculum->courses->take(12); // completed 12 courses
        $student2->courses()->attach($someCourses->pluck('id'));

        // Attach some EFSRTs
        $student2->efsrts()->attach([
            $efsrt1->id => ['company_name' => 'Tech Support SA', 'hours' => 240, 'start_date' => '2026-05-01', 'end_date' => '2026-07-01', 'status' => 'approved'],
            $efsrt2->id => ['company_name' => 'Software Factory', 'hours' => 240, 'start_date' => '2026-08-01', 'end_date' => null, 'status' => 'pending'],
        ]);
    }
}
