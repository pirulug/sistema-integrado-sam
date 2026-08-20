<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GraduationTrackingTest extends TestCase
{
    use RefreshDatabase;

    private User $teacherUser;
    private Curriculum $curriculum;
    private Student $student;
    private Course $course1;
    private Course $course2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherUser = User::factory()->create([
            "role" => "teacher",
        ]);

        $this->curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        $this->course1 = Course::create([
            "code" => "DPW-I-01",
            "name" => "Diseño Web I",
            "period" => "I",
            "credits" => 3,
            "hours" => 80,
        ]);

        $this->course2 = Course::create([
            "code" => "DPW-I-02",
            "name" => "Maquetación",
            "period" => "I",
            "credits" => 3,
            "hours" => 80,
        ]);

        $this->curriculum->courses()->attach([$this->course1->id, $this->course2->id]);

        $this->student = Student::create([
            "dni" => "12345678",
            "student_code" => "EST2026001",
            "paternal_last_name" => "Perez",
            "maternal_last_name" => "Gomez",
            "first_name" => "Juan",
            "study_program" => "Diseño y programación web",
            "institutional_email" => "jperez@instituto.edu.pe",
            "admission_date" => "2026-03-01",
            "curriculum_id" => $this->curriculum->id,
        ]);
    }

    public function test_teacher_can_view_graduation_tracking_page_with_course_modals(): void
    {
        $response = $this->actingAs($this->teacherUser)->get(route("graduation.index"));

        $response->assertOk();
        $response->assertSee("Seguimiento de Titulación");
        $response->assertSee("Perez Gomez, Juan");
        $response->assertSee("open-courses-modal-btn");
        $response->assertSee("courses-modal-{$this->student->id}");
    }

    public function test_teacher_can_toggle_course_status_via_ajax(): void
    {
        $response = $this->actingAs($this->teacherUser)->postJson("/graduation/{$this->student->id}/toggle-course/{$this->course1->id}");

        $response->assertOk();
        $response->assertJson([
            "success" => true,
            "approved" => true,
            "pending_count" => 1,
        ]);

        $this->assertTrue($this->student->fresh()->courses->contains($this->course1->id));
    }

    public function test_teacher_can_bulk_approve_courses(): void
    {
        $response = $this->actingAs($this->teacherUser)->postJson("/graduation/{$this->student->id}/bulk-courses", [
            "action" => "approve_all",
        ]);

        $response->assertOk();
        $response->assertJson([
            "success" => true,
            "pending_count" => 0,
        ]);

        $this->assertCount(2, $this->student->fresh()->courses);
    }

    public function test_teacher_can_update_student_efsrt_practice_line_and_activities(): void
    {
        $efsrt = \App\Models\Efsrt::create([
            "module" => "Módulo I",
            "module_name" => "Diseño y elaboración de páginas web",
            "period" => "II",
            "hours" => 96,
            "credits" => 3,
            "competency" => "Competencia de diseño web",
            "practice_lines" => [
                [
                    "line" => "Diseño y creación de páginas web.",
                    "activities" => ["Diseña páginas web", "Realiza la maquetación"]
                ]
            ]
        ]);

        $this->curriculum->efsrts()->attach($efsrt->id);

        $response = $this->actingAs($this->teacherUser)->post(
            "/graduation/{$this->student->id}/update-efsrt/{$efsrt->id}",
            [
                "company_name" => "Agencia Web SAC",
                "practice_line" => "Diseño y creación de páginas web.",
                "activities" => "Diseña páginas web y realiza maquetación",
                "hours" => 96,
                "start_date" => "2026-04-01",
                "end_date" => "2026-06-01",
                "status" => "approved",
            ]
        );

        $response->assertRedirect();
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("efsrt_student", [
            "student_id" => $this->student->id,
            "efsrt_id" => $efsrt->id,
            "company_name" => "Agencia Web SAC",
            "practice_line" => "Diseño y creación de páginas web.",
            "hours" => 96,
            "status" => "approved",
        ]);
    }
}
