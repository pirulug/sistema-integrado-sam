<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $teacherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            "name" => "Admin Principal",
            "email" => "admin@sam.edu.pe",
            "role" => "admin",
        ]);

        $this->teacherUser = User::factory()->create([
            "name" => "Profesor Demo",
            "email" => "demo@sam.edu.pe",
            "role" => "teacher",
        ]);
    }

    public function test_admin_can_view_users_list_and_stats(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route("users.index"));
        $response->assertOk();
        $response->assertSee("Gestión de Usuarios del Sistema");
        $response->assertSee("Admin Principal");
        $response->assertSee("Profesor Demo");
    }

    public function test_teacher_cannot_access_user_management(): void
    {
        $this->actingAs($this->teacherUser)->get(route("users.index"))->assertForbidden();
        $this->actingAs($this->teacherUser)->get(route("users.create"))->assertForbidden();
        $this->actingAs($this->teacherUser)->post(route("users.store"), [])->assertForbidden();
    }

    public function test_admin_can_create_new_administrator(): void
    {
        $userData = [
            "name" => "Nuevo Administrador",
            "dni" => "09112233",
            "email" => "segundoadmin@sam.edu.pe",
            "role" => "admin",
            "password" => "password123",
            "password_confirmation" => "password123",
        ];

        $response = $this->actingAs($this->adminUser)->post(route("users.store"), $userData);
        $response->assertRedirect(route("users.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("users", [
            "email" => "segundoadmin@sam.edu.pe",
            "role" => "admin",
        ]);

        $user = User::where("email", "segundoadmin@sam.edu.pe")->first();
        $this->assertTrue(Hash::check("password123", $user->password));
    }

    public function test_admin_can_create_and_assign_user_to_teacher_with_institutional_email(): void
    {
        $teacher = Teacher::create([
            "dni" => "08994455",
            "teacher_code" => "DOC2026888",
            "paternal_last_name" => "Castillo",
            "maternal_last_name" => "Vega",
            "first_name" => "Rosa",
            "institutional_email" => "rcastillo@sam.edu.pe",
            "hire_date" => "2026-03-01",
        ]);

        $this->assertNull($teacher->user_id);

        $userData = [
            "role" => "teacher",
            "teacher_id" => $teacher->id,
            "password" => "docente2026",
            "password_confirmation" => "docente2026",
        ];

        $response = $this->actingAs($this->adminUser)->post(route("users.store"), $userData);
        $response->assertRedirect(route("users.index"));
        $response->assertSessionHas("success");

        $teacher->refresh();
        $this->assertNotNull($teacher->user_id);

        $user = User::find($teacher->user_id);
        $this->assertEquals("rcastillo@sam.edu.pe", $user->email);
        $this->assertEquals("teacher", $user->role);
        $this->assertTrue(Hash::check("docente2026", $user->password));
    }

    public function test_admin_can_reset_user_password(): void
    {
        $targetUser = User::factory()->create([
            "email" => "olvidadizo@sam.edu.pe",
            "password" => Hash::make("antiguaclave"),
            "role" => "teacher",
        ]);

        $resetData = [
            "password" => "nuevaclave2026",
            "password_confirmation" => "nuevaclave2026",
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route("users.reset-password", $targetUser), $resetData);

        $response->assertSessionHas("success");

        $targetUser->refresh();
        $this->assertTrue(Hash::check("nuevaclave2026", $targetUser->password));
        $this->assertFalse(Hash::check("antiguaclave", $targetUser->password));
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->delete(route("users.destroy", $this->adminUser));

        $response->assertSessionHas("error");
        $this->assertDatabaseHas("users", ["id" => $this->adminUser->id]);
    }

    public function test_admin_can_delete_other_user_and_unlink_teacher(): void
    {
        $teacher = Teacher::create([
            "dni" => "08994466",
            "teacher_code" => "DOC2026887",
            "paternal_last_name" => "Guerrero",
            "maternal_last_name" => "Ponce",
            "first_name" => "Jorge",
            "institutional_email" => "jguerrero@sam.edu.pe",
            "hire_date" => "2026-03-01",
        ]);

        $user = User::create([
            "name" => "Jorge Guerrero",
            "dni" => "08994466",
            "email" => "jguerrero@sam.edu.pe",
            "password" => Hash::make("password123"),
            "role" => "teacher",
        ]);

        $teacher->update(["user_id" => $user->id]);

        $response = $this->actingAs($this->adminUser)
            ->delete(route("users.destroy", $user));

        $response->assertRedirect(route("users.index"));
        $this->assertDatabaseMissing("users", ["id" => $user->id]);

        $teacher->refresh();
        $this->assertNull($teacher->user_id);
    }

    public function test_admin_can_update_teacher_password_from_users_edit(): void
    {
        $teacher = Teacher::create([
            "dni" => "08994477",
            "teacher_code" => "DOC2026886",
            "paternal_last_name" => "Palomino",
            "maternal_last_name" => "Flores",
            "first_name" => "Carmen",
            "institutional_email" => "cpalomino@sam.edu.pe",
            "hire_date" => "2026-03-01",
        ]);

        $user = User::create([
            "name" => "Carmen Palomino",
            "dni" => "08994477",
            "email" => "cpalomino@sam.edu.pe",
            "password" => Hash::make("oldpass123"),
            "role" => "teacher",
        ]);

        $teacher->update(["user_id" => $user->id]);

        $response = $this->actingAs($this->adminUser)->put(route("users.update", $user), [
            "password" => "newpass123",
            "password_confirmation" => "newpass123",
        ]);

        $response->assertRedirect(route("users.index"));
        $user->refresh();
        $this->assertTrue(Hash::check("newpass123", $user->password));
    }

    public function test_admin_can_update_admin_user_details(): void
    {
        $otherAdmin = User::factory()->create([
            "name" => "Admin Anterior",
            "email" => "anterior@sam.edu.pe",
            "role" => "admin",
        ]);

        $response = $this->actingAs($this->adminUser)->put(route("users.update", $otherAdmin), [
            "name" => "Admin Modificado",
            "email" => "modificado@sam.edu.pe",
            "role" => "admin",
        ]);

        $response->assertRedirect(route("users.index"));
        $otherAdmin->refresh();
        $this->assertEquals("Admin Modificado", $otherAdmin->name);
        $this->assertEquals("modificado@sam.edu.pe", $otherAdmin->email);
    }
}
