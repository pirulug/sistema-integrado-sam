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

    public function test_admin_can_create_teacher_with_user_account(): void
    {
        $teacherData = [
            "dni" => "08991155",
            "teacher_code" => "DOC2026996",
            "paternal_last_name" => "Palacios",
            "maternal_last_name" => "Mendoza",
            "first_name" => "Carmen",
            "institutional_email" => "cpalacios@sam.edu.pe",
            "hire_date" => "2026-03-01",
            "create_user_account" => "1",
            "password" => "docentepass123",
            "password_confirmation" => "docentepass123",
        ];

        $response = $this->actingAs($this->adminUser)->post(route("teachers.store"), $teacherData);
        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionHas("success");

        $teacher = Teacher::where("dni", "08991155")->first();
        $this->assertNotNull($teacher);
        $this->assertNotNull($teacher->user_id);

        $user = User::find($teacher->user_id);
        $this->assertEquals("cpalacios@sam.edu.pe", $user->email);
        $this->assertEquals("teacher", $user->role);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check("docentepass123", $user->password));
    }

    public function test_admin_can_update_teacher_password_and_account(): void
    {
        $teacher = Teacher::create([
            "dni" => "08991166",
            "teacher_code" => "DOC2026995",
            "paternal_last_name" => "Luna",
            "maternal_last_name" => "Perez",
            "first_name" => "Ricardo",
            "institutional_email" => "rluna@sam.edu.pe",
            "hire_date" => "2026-03-01",
        ]);

        $this->assertNull($teacher->user_id);

        // Update to create user account
        $updateData = [
            "dni" => "08991166",
            "teacher_code" => "DOC2026995",
            "paternal_last_name" => "Luna",
            "maternal_last_name" => "Perez",
            "first_name" => "Ricardo",
            "institutional_email" => "rluna@sam.edu.pe",
            "hire_date" => "2026-03-01",
            "create_user_account" => "1",
            "password" => "nuevaclave123",
            "password_confirmation" => "nuevaclave123",
        ];

        $response = $this->actingAs($this->adminUser)->put(route("teachers.update", $teacher), $updateData);
        $response->assertRedirect(route("teachers.index"));

        $teacher->refresh();
        $this->assertNotNull($teacher->user_id);

        $user = User::find($teacher->user_id);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check("nuevaclave123", $user->password));

        // Update password again
        $updateData2 = [
            "dni" => "08991166",
            "teacher_code" => "DOC2026995",
            "paternal_last_name" => "Luna",
            "maternal_last_name" => "Perez",
            "first_name" => "Ricardo",
            "institutional_email" => "rluna@sam.edu.pe",
            "hire_date" => "2026-03-01",
            "password" => "clavemodificada456",
            "password_confirmation" => "clavemodificada456",
        ];

        $this->actingAs($this->adminUser)->put(route("teachers.update", $teacher), $updateData2);
        $user->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check("clavemodificada456", $user->password));
    }
}
