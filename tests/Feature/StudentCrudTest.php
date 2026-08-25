<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $teacherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherUser = User::factory()->create([
            "role" => "teacher",
        ]);
    }

    public function test_teacher_can_view_create_student_form(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->get(route("students.create"));

        $response->assertOk();
        $response->assertSee("Registrar Estudiante");
        $response->assertSee("Género");
        $response->assertSee("Masculino");
        $response->assertSee("Femenino");
    }

    public function test_teacher_can_create_student_with_gender(): void
    {
        $studentData = [
            "dni" => "12345678",
            "student_code" => "EST2026100",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Rosas",
            "maternal_last_name" => "Valle",
            "first_name" => "Carmen",
            "gender" => "Femenino",
            "personal_email" => "carmen.rosas@gmail.com",
            "institutional_email" => "crosas@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $studentData);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "12345678",
            "student_code" => "EST2026100",
            "first_name" => "Carmen",
            "gender" => "Femenino",
        ]);
    }

    public function test_teacher_can_view_student_profile_with_gender(): void
    {
        $student = Student::create([
            "dni" => "87654321",
            "student_code" => "EST2026101",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Castro",
            "maternal_last_name" => "Navarro",
            "first_name" => "Jorge",
            "gender" => "Masculino",
            "institutional_email" => "jcastro@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        $response = $this->actingAs($this->teacherUser)
            ->get(route("students.show", $student));

        $response->assertOk();
        $response->assertSee("Jorge");
        $response->assertSee("Género");
        $response->assertSee("Masculino");
    }

    public function test_teacher_can_edit_and_update_student_gender(): void
    {
        $student = Student::create([
            "dni" => "99887711",
            "student_code" => "EST2026102",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Vega",
            "maternal_last_name" => "Luna",
            "first_name" => "Alex",
            "gender" => "Masculino",
            "institutional_email" => "avega@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        $editResponse = $this->actingAs($this->teacherUser)
            ->get(route("students.edit", $student));

        $editResponse->assertOk();
        $editResponse->assertSee("Editar Estudiante");
        $editResponse->assertSee("Masculino");

        $updateData = [
            "dni" => "99887711",
            "student_code" => "EST2026102",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Vega",
            "maternal_last_name" => "Luna",
            "first_name" => "Alexandra",
            "gender" => "Femenino",
            "institutional_email" => "avega@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $updateResponse = $this->actingAs($this->teacherUser)
            ->put(route("students.update", $student), $updateData);

        $updateResponse->assertRedirect(route("students.index"));
        $updateResponse->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "99887711",
            "first_name" => "Alexandra",
            "gender" => "Femenino",
        ]);
    }
}
