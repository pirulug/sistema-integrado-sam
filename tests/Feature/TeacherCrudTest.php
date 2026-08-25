<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            "role" => "admin",
        ]);
    }

    public function test_admin_can_view_teachers_list_and_create_form(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route("teachers.index"));
        $response->assertOk();
        $response->assertSee("Registrar Profesor");

        $createResponse = $this->actingAs($this->adminUser)->get(route("teachers.create"));
        $createResponse->assertOk();
        $createResponse->assertSee("Fotografía del Profesor");
    }

    public function test_admin_can_create_teacher(): void
    {
        $teacherData = [
            "dni" => "08991122",
            "teacher_code" => "DOC2026999",
            "paternal_last_name" => "Valdez",
            "maternal_last_name" => "Rios",
            "first_name" => "Marcos",
            "institutional_email" => "mvaldez@sam.edu.pe",
            "hire_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->adminUser)->post(route("teachers.store"), $teacherData);

        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("teachers", [
            "dni" => "08991122",
            "teacher_code" => "DOC2026999",
            "first_name" => "Marcos",
        ]);
    }

    public function test_admin_can_view_and_update_teacher(): void
    {
        $teacher = Teacher::create([
            "dni" => "08991133",
            "teacher_code" => "DOC2026998",
            "paternal_last_name" => "Torres",
            "maternal_last_name" => "Silva",
            "first_name" => "Elena",
            "institutional_email" => "etorres@sam.edu.pe",
            "hire_date" => "2026-03-01",
            "photo_path" => "teachers/sample.jpg",
        ]);

        $this->assertNotNull($teacher->photo_url);
        $this->assertStringContainsString("teachers/sample.jpg", $teacher->photo_url);

        $showResponse = $this->actingAs($this->adminUser)->get(route("teachers.show", $teacher));
        $showResponse->assertOk();
        $showResponse->assertSee("Elena");
        $showResponse->assertSee("DOC2026998");

        $updateData = [
            "dni" => "08991133",
            "teacher_code" => "DOC2026998",
            "paternal_last_name" => "Torres",
            "maternal_last_name" => "Silva",
            "first_name" => "Elena Maria",
            "institutional_email" => "etorres@sam.edu.pe",
            "hire_date" => "2026-03-01",
            "remove_photo" => "1",
        ];

        $response = $this->actingAs($this->adminUser)->put(route("teachers.update", $teacher), $updateData);

        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionHas("success");

        $teacher->refresh();
        $this->assertEquals("Elena Maria", $teacher->first_name);
        $this->assertNull($teacher->photo_path);
        $this->assertNull($teacher->photo_url);
    }

    public function test_destroy_teacher(): void
    {
        $teacher = Teacher::create([
            "dni" => "08991144",
            "teacher_code" => "DOC2026997",
            "paternal_last_name" => "Salas",
            "maternal_last_name" => "Guerra",
            "first_name" => "Pedro",
            "institutional_email" => "psalas@sam.edu.pe",
            "hire_date" => "2026-03-01",
        ]);

        $response = $this->actingAs($this->adminUser)->delete(route("teachers.destroy", $teacher));

        $response->assertRedirect(route("teachers.index"));
        $this->assertDatabaseMissing("teachers", ["id" => $teacher->id]);
    }
}
