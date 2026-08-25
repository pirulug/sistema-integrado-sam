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
        $this->actingAs($this->adminUser)->get(route("activity-logs.index"))->assertOk();
        $this->actingAs($this->adminUser)->get(route("users.index"))->assertOk();
    }

    public function test_auditor_can_observe_all_modules_and_logs(): void
    {
        $auditorUser = User::factory()->create([
            "role" => "auditor",
        ]);

        $student = Student::create([
            "dni" => "22334455",
            "student_code" => "EST2026777",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Torres",
            "maternal_last_name" => "Salas",
            "first_name" => "Valeria",
            "institutional_email" => "vtorres@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        // Can view all index & show pages as observer
        $this->actingAs($auditorUser)->get(route("students.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("students.show", $student))->assertOk();
        $this->actingAs($auditorUser)->get(route("graduation.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("users.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("teachers.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("curriculums.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("courses.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("efsrts.index"))->assertOk();
        $this->actingAs($auditorUser)->get(route("activity-logs.index"))->assertOk();
    }

    public function test_auditor_cannot_perform_mutations_or_access_forms(): void
    {
        $auditorUser = User::factory()->create([
            "role" => "auditor",
        ]);

        $student = Student::create([
            "dni" => "33445566",
            "student_code" => "EST2026666",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Castro",
            "maternal_last_name" => "Vargas",
            "first_name" => "Esteban",
            "institutional_email" => "ecastro@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        // Cannot access create or edit forms
        $this->actingAs($auditorUser)->get(route("students.create"))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("students.edit", $student))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("users.create"))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("users.edit", $this->adminUser))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("teachers.create"))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("curriculums.create"))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("courses.create"))->assertForbidden();
        $this->actingAs($auditorUser)->get(route("efsrts.create"))->assertForbidden();

        // Cannot mutate data
        $this->actingAs($auditorUser)->delete(route("students.destroy", $student))->assertForbidden();
        $this->actingAs($auditorUser)->post(route("graduation.titular", $student), [
            "action" => "save",
            "degree_date" => "2026-08-25",
            "degree_modality" => "Tesis",
            "degree_grade" => 18.0,
        ])->assertForbidden();
    }
}
