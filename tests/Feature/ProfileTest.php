<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed_in_spanish(): void
    {
        $user = User::factory()->create([
            "name" => "Profesor Demo",
            "email" => "demo@sam.edu.pe",
            "role" => "teacher",
        ]);

        $response = $this
            ->actingAs($user)
            ->get("/profile");

        $response->assertOk();
        $response->assertSee("Mi Perfil de Usuario");
        $response->assertSee("Información del Perfil");
        $response->assertSee("Seguridad y Contraseña");
        $response->assertSee("demo@sam.edu.pe");
        $response->assertDontSee("Delete Account");
    }

    public function test_profile_name_can_be_updated(): void
    {
        $user = User::factory()->create([
            "name" => "Nombre Antiguo",
            "email" => "original@sam.edu.pe",
        ]);

        $response = $this
            ->actingAs($user)
            ->patch("/profile", [
                "name" => "Nombre Modificado",
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect("/profile");

        $user->refresh();

        $this->assertSame("Nombre Modificado", $user->name);
        $this->assertSame("original@sam.edu.pe", $user->email);
    }

    public function test_email_cannot_be_changed_from_profile(): void
    {
        $user = User::factory()->create([
            "name" => "Docente Institucional",
            "email" => "docente@sam.edu.pe",
        ]);

        $response = $this
            ->actingAs($user)
            ->patch("/profile", [
                "name" => "Docente Actualizado",
                "email" => "intruso@gmail.com",
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect("/profile");

        $user->refresh();

        $this->assertSame("Docente Actualizado", $user->name);
        $this->assertSame("docente@sam.edu.pe", $user->email);
    }

    public function test_user_cannot_delete_their_account_from_profile(): void
    {
        $user = User::factory()->create([
            "role" => "teacher",
        ]);

        $response = $this
            ->actingAs($user)
            ->delete("/profile");

        $response->assertForbidden();
        $this->assertNotNull($user->fresh());
    }
}
