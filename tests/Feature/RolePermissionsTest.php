<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Efsrt;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $teacherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            "role" => "admin",
        ]);

        $this->teacherUser = User::factory()->create([
            "role" => "teacher",
        ]);
    }

    public function test_teacher_can_create_and_edit_students_but_cannot_delete(): void
    {
        $student = Student::create([
            "dni" => "11223344",
            "student_code" => "EST2026888",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Rojas",
            "maternal_last_name" => "Perez",
            "first_name" => "Carlos",
            "institutional_email" => "crojas@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        // Teacher can view index and edit
        $responseIndex = $this->actingAs($this->teacherUser)->get(route("students.index"));
        $responseIndex->assertOk();
        $responseIndex->assertDontSee("Eliminar</button>", false);

        $responseEdit = $this->actingAs($this->teacherUser)->get(route("students.edit", $student));
        $responseEdit->assertOk();

        // Teacher CANNOT delete student (403 Forbidden)
        $responseDelete = $this->actingAs($this->teacherUser)->delete(route("students.destroy", $student));
        $responseDelete->assertForbidden();
        $this->assertDatabaseHas("students", ["id" => $student->id]);
    }

    public function test_admin_can_delete_student(): void
    {
        $student = Student::create([
            "dni" => "11223355",
            "student_code" => "EST2026889",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Morales",
            "maternal_last_name" => "Gomez",
            "first_name" => "Lucia",
            "institutional_email" => "lmorales@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        $responseIndex = $this->actingAs($this->adminUser)->get(route("students.index"));
        $responseIndex->assertOk();
        $responseIndex->assertSee("Eliminar");

        $responseDelete = $this->actingAs($this->adminUser)->delete(route("students.destroy", $student));
        $responseDelete->assertRedirect(route("students.index"));
        $this->assertDatabaseMissing("students", ["id" => $student->id]);
    }

    public function test_teacher_can_access_graduation_tracking(): void
    {
        $response = $this->actingAs($this->teacherUser)->get(route("graduation.index"));
        $response->assertOk();
        $response->assertSee("Seguimiento");
    }

    public function test_teacher_cannot_access_curriculums_courses_efsrts_and_teachers(): void
    {
        // Curriculums
        $this->actingAs($this->teacherUser)->get(route("curriculums.index"))->assertForbidden();
        $this->actingAs($this->teacherUser)->get(route("curriculums.create"))->assertForbidden();

        // Courses
        $this->actingAs($this->teacherUser)->get(route("courses.index"))->assertForbidden();
        $this->actingAs($this->teacherUser)->get(route("courses.create"))->assertForbidden();

        // EFSRT
        $this->actingAs($this->teacherUser)->get(route("efsrts.index"))->assertForbidden();
        $this->actingAs($this->teacherUser)->get(route("efsrts.create"))->assertForbidden();

        // Teachers
        $this->actingAs($this->teacherUser)->get(route("teachers.index"))->assertForbidden();
        $this->actingAs($this->teacherUser)->get(route("teachers.create"))->assertForbidden();
    }

    public function test_admin_has_full_unrestricted_access(): void
    {
        $this->actingAs($this->adminUser)->get(route("students.index"))->assertOk();
        $this->actingAs($this->adminUser)->get(route("teachers.index"))->assertOk();
        $this->actingAs($this->adminUser)->get(route("curriculums.index"))->assertOk();
        $this->actingAs($this->adminUser)->get(route("courses.index"))->assertOk();
        $this->actingAs($this->adminUser)->get(route("efsrts.index"))->assertOk();
        $this->actingAs($this->adminUser)->get(route("graduation.index"))->assertOk();
    }
}
