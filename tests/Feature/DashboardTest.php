<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_statistics_dashboard(): void
    {
        $user = User::factory()->create([
            "role" => "teacher",
        ]);

        $curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        $course = Course::create([
            "code" => "DPW-01",
            "name" => "Algoritmos",
            "period" => "I",
            "credits" => 4,
            "hours" => 64,
        ]);

        $curriculum->courses()->attach($course->id);

        Teacher::create([
            "dni" => "77777777",
            "teacher_code" => "DOC2026001",
            "paternal_last_name" => "Lopez",
            "maternal_last_name" => "Rios",
            "first_name" => "Carlos",
            "institutional_email" => "clopez@instituto.edu.pe",
            "hire_date" => "2026-03-01",
        ]);

        Student::create([
            "dni" => "88888888",
            "student_code" => "EST2026001",
            "paternal_last_name" => "Salas",
            "maternal_last_name" => "Vargas",
            "first_name" => "Ana",
            "study_program" => "Diseño y programación web",
            "institutional_email" => "asalas@instituto.edu.pe",
            "shift" => "Diurno (Mañana)",
            "admission_date" => "2026-03-01",
            "curriculum_id" => $curriculum->id,
        ]);

        $response = $this->actingAs($user)->get(route("dashboard"));

        $response->assertOk();
        $response->assertSee("Panel Estadístico y Control Académico");
        $response->assertSee("Estado General de Graduación");
        $response->assertSee("Matrícula por Turno");
        $response->assertSee("Mallas Curriculares Vigentes");
        $response->assertSee("Prácticas Pre-Profesionales (EFSRT)");
        $response->assertSee("Malla 2026");
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get(route("dashboard"));

        $response->assertRedirect(route("login"));
    }
}
