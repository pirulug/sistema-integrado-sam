<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CourseImportTest extends TestCase
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

    public function test_teacher_can_download_comma_template(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route("courses.template", ["delimiter" => ","]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("codigo,nombre,periodo,creditos,horas", $content);
    }

    public function test_teacher_can_download_semicolon_template(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route("courses.template", ["delimiter" => ";"]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("codigo;nombre;periodo;creditos;horas", $content);
    }

    public function test_import_standalone_courses_with_comma_and_curriculum(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        $csvContent = "codigo,nombre,periodo,creditos,horas\n" .
            "DPW-I-01,Diseño gráfico para la web,I,3,80\n" .
            "DPW-I-02,Maquetación web,I,3,80";

        $file = UploadedFile::fake()->createWithContent("cursos.csv", $csvContent);

        $response = $this->actingAs($this->adminUser)->post(route("courses.import"), [
            "file" => $file,
            "delimiter" => ",",
            "curriculum_id" => $curriculum->id,
        ]);

        $response->assertRedirect(route("courses.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-I-01",
            "name" => "Diseño gráfico para la web",
            "period" => "I",
        ]);

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-I-02",
            "name" => "Maquetación web",
            "period" => "I",
        ]);

        $this->assertTrue($curriculum->courses()->where("code", "DPW-I-01")->exists());
        $this->assertTrue($curriculum->courses()->where("code", "DPW-I-02")->exists());
    }

    public function test_import_standalone_courses_with_semicolon(): void
    {
        $csvContent = "codigo;nombre;periodo;creditos;horas\n" .
            "DPW-II-01;Diseño web;II;3;80";

        $file = UploadedFile::fake()->createWithContent("cursos_semicolon.csv", $csvContent);

        $response = $this->actingAs($this->adminUser)->post(route("courses.import"), [
            "file" => $file,
            "delimiter" => ";",
        ]);

        $response->assertRedirect(route("courses.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-II-01",
            "name" => "Diseño web",
        ]);
    }

    public function test_import_detects_duplicate_code_and_redirects_to_conflicts(): void
    {
        Course::create([
            "code" => "DPW-I-01",
            "name" => "Curso Original",
            "period" => "I",
            "credits" => 3,
            "hours" => 80,
        ]);

        $csvContent = "codigo,nombre,periodo,creditos,horas\n" .
            "DPW-I-01,Curso Con Mismo Código,I,3,80";

        $file = UploadedFile::fake()->createWithContent("conflicto.csv", $csvContent);

        $response = $this->actingAs($this->adminUser)->post(route("courses.import"), [
            "file" => $file,
            "delimiter" => ",",
        ]);

        $response->assertRedirect(route("courses.import-conflicts"));
        $response->assertSessionHas("import_course_conflicts");
    }

    public function test_resolve_course_conflicts_updates_existing(): void
    {
        $existing = Course::create([
            "code" => "DPW-I-01",
            "name" => "Nombre Antiguo",
            "period" => "I",
            "credits" => 2,
            "hours" => 48,
        ]);

        $response = $this->actingAs($this->adminUser)->post(route("courses.import-conflicts.resolve"), [
            "rows" => [
                "course_1" => [
                    "action" => "update",
                    "existing_course_id" => $existing->id,
                    "code" => "DPW-I-01",
                    "name" => "Nombre Nuevo",
                    "period" => "I",
                    "credits" => 3,
                    "hours" => 80,
                ],
            ],
        ]);

        $response->assertRedirect(route("courses.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("courses", [
            "id" => $existing->id,
            "name" => "Nombre Nuevo",
            "credits" => 3,
            "hours" => 80,
        ]);
    }

    public function test_resolve_course_conflicts_creates_as_new_with_edited_code(): void
    {
        Course::create([
            "code" => "DPW-I-01",
            "name" => "Primer Curso",
            "period" => "I",
            "credits" => 3,
            "hours" => 80,
        ]);

        $response = $this->actingAs($this->adminUser)->post(route("courses.import-conflicts.resolve"), [
            "rows" => [
                "course_1" => [
                    "action" => "create",
                    "code" => "DPW-I-01-B", // Edited code
                    "name" => "Segundo Curso",
                    "period" => "I",
                    "credits" => 3,
                    "hours" => 80,
                ],
            ],
        ]);

        $response->assertRedirect(route("courses.index"));

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-I-01-B",
            "name" => "Segundo Curso",
        ]);
    }

    public function test_cancel_course_conflicts_clears_session(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->withSession([
                "import_course_conflicts" => [["temp_id" => "1"]],
                "import_course_saved_count" => 1,
            ])
            ->post(route("courses.import-conflicts.cancel"));

        $response->assertRedirect(route("courses.index"));
        $response->assertSessionMissing("import_course_conflicts");
    }
}
