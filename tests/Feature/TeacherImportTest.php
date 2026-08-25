<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TeacherImportTest extends TestCase
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

    public function test_admin_can_download_comma_template(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route("teachers.template", ["delimiter" => ","]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("dni,codigo,apellido_paterno", $content);
    }

    public function test_admin_can_download_semicolon_template(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route("teachers.template", ["delimiter" => ";"]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("dni;codigo;apellido_paterno", $content);
    }

    public function test_import_teachers_with_comma_delimiter(): void
    {
        $csvContent = "dni,codigo,apellido_paterno,apellido_materno,nombres,email_institucional,email_personal,telefono,celular,fecha_contratacion\n" .
            "87654321,DOC2026001,Ramirez,Soto,Maria Elena,mramirez@sam.edu.pe,maria@gmail.com,013456789,912345678,2026-03-01\n" .
            "87654322,DOC2026002,Vargas,Silva,Pedro Jose,pvargas@sam.edu.pe,pedro@gmail.com,013456780,912345679,2026-03-01";

        $file = UploadedFile::fake()->createWithContent("profesores.csv", $csvContent);

        $response = $this->actingAs($this->adminUser)->post(route("teachers.import"), [
            "file" => $file,
            "delimiter" => ",",
        ]);

        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("teachers", [
            "dni" => "87654321",
            "teacher_code" => "DOC2026001",
            "paternal_last_name" => "Ramirez",
            "first_name" => "Maria Elena",
        ]);

        $this->assertDatabaseHas("teachers", [
            "dni" => "87654322",
            "teacher_code" => "DOC2026002",
            "paternal_last_name" => "Vargas",
            "first_name" => "Pedro Jose",
        ]);
    }

    public function test_import_teachers_with_semicolon_delimiter(): void
    {
        $csvContent = "dni;codigo;apellido_paterno;apellido_materno;nombres;email_institucional;email_personal;telefono;celular;fecha_contratacion\n" .
            "87654323;DOC2026003;Navarro;Gomez;Luis Alberto;lnavarro@sam.edu.pe;luis@gmail.com;013456781;912345680;2026-03-01";

        $file = UploadedFile::fake()->createWithContent("profesores_semicolon.csv", $csvContent);

        $response = $this->actingAs($this->adminUser)->post(route("teachers.import"), [
            "file" => $file,
            "delimiter" => ";",
        ]);

        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("teachers", [
            "dni" => "87654323",
            "teacher_code" => "DOC2026003",
            "paternal_last_name" => "Navarro",
            "first_name" => "Luis Alberto",
        ]);
    }

    public function test_import_teachers_detects_duplicate_and_redirects_to_conflicts(): void
    {
        Teacher::create([
            "dni" => "87654321",
            "teacher_code" => "DOC2026001",
            "paternal_last_name" => "Ramirez",
            "maternal_last_name" => "Soto",
            "first_name" => "Maria Elena",
            "institutional_email" => "mramirez@sam.edu.pe",
            "hire_date" => "2020-03-01",
        ]);

        $csvContent = "dni,codigo,apellido_paterno,apellido_materno,nombres,email_institucional,fecha_contratacion\n" .
            "87654399,DOC2026099,Nuevo,Docente,Ana,anuevodoc@sam.edu.pe,2026-03-01\n" .
            "87654321,DOC2026001,Ramirez,Soto,Maria Modificada,mramirez.mod@sam.edu.pe,2026-03-01";

        $file = UploadedFile::fake()->createWithContent("docentes_conflicto.csv", $csvContent);

        $response = $this->actingAs($this->adminUser)->post(route("teachers.import"), [
            "file" => $file,
            "delimiter" => ",",
        ]);

        $response->assertRedirect(route("teachers.import-conflicts"));
        $response->assertSessionHas("import_teacher_conflicts");

        // The clean one was created
        $this->assertDatabaseHas("teachers", [
            "dni" => "87654399",
            "teacher_code" => "DOC2026099",
        ]);
    }

    public function test_resolve_teacher_conflicts_updates_existing(): void
    {
        $existing = Teacher::create([
            "dni" => "87654321",
            "teacher_code" => "DOC2026001",
            "paternal_last_name" => "Ramirez",
            "maternal_last_name" => "Soto",
            "first_name" => "Maria",
            "institutional_email" => "mramirez@sam.edu.pe",
            "hire_date" => "2020-03-01",
        ]);

        $response = $this->actingAs($this->adminUser)->post(route("teachers.import-conflicts.resolve"), [
            "rows" => [
                "row_2_test" => [
                    "action" => "update",
                    "existing_teacher_id" => $existing->id,
                    "dni" => "87654321",
                    "teacher_code" => "DOC2026001",
                    "paternal_last_name" => "Ramirez Actualizado",
                    "maternal_last_name" => "Soto",
                    "first_name" => "Maria Elena",
                    "institutional_email" => "mramirez.actualizado@sam.edu.pe",
                    "hire_date" => "2020-03-01",
                ],
            ],
        ]);

        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("teachers", [
            "dni" => "87654321",
            "paternal_last_name" => "Ramirez Actualizado",
            "institutional_email" => "mramirez.actualizado@sam.edu.pe",
        ]);
    }

    public function test_resolve_teacher_conflicts_creates_as_new(): void
    {
        Teacher::create([
            "dni" => "87654321",
            "teacher_code" => "DOC2026001",
            "paternal_last_name" => "Existente",
            "maternal_last_name" => "Docente",
            "first_name" => "Juan",
            "institutional_email" => "juan@sam.edu.pe",
            "hire_date" => "2020-03-01",
        ]);

        // User edits DNI and Code to avoid conflict
        $response = $this->actingAs($this->adminUser)->post(route("teachers.import-conflicts.resolve"), [
            "rows" => [
                "row_2_test" => [
                    "action" => "create",
                    "dni" => "87654399",
                    "teacher_code" => "DOC2026099",
                    "paternal_last_name" => "NuevoHermano",
                    "maternal_last_name" => "Docente",
                    "first_name" => "Carlos",
                    "institutional_email" => "carlos@sam.edu.pe",
                    "hire_date" => "2026-03-01",
                ],
            ],
        ]);

        $response->assertRedirect(route("teachers.index"));

        $this->assertDatabaseHas("teachers", [
            "dni" => "87654399",
            "teacher_code" => "DOC2026099",
            "first_name" => "Carlos",
        ]);
    }

    public function test_resolve_teacher_conflicts_ignores_row(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route("teachers.import-conflicts.resolve"), [
            "rows" => [
                "row_2_test" => [
                    "action" => "ignore",
                    "dni" => "99999999",
                    "teacher_code" => "DOC999",
                    "paternal_last_name" => "Ignorado",
                    "maternal_last_name" => "Ignorado",
                    "first_name" => "Ignorado",
                ],
            ],
        ]);

        $response->assertRedirect(route("teachers.index"));

        $this->assertDatabaseMissing("teachers", [
            "dni" => "99999999",
        ]);
    }

    public function test_cancel_teacher_conflicts_clears_session(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->withSession([
                "import_teacher_conflicts" => [["temp_id" => "1"]],
                "import_teacher_saved_count" => 1,
            ])
            ->post(route("teachers.import-conflicts.cancel"));

        $response->assertRedirect(route("teachers.index"));
        $response->assertSessionMissing("import_teacher_conflicts");
        $response->assertSessionHas("info");
    }
}
