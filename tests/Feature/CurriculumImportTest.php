<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CurriculumImportTest extends TestCase
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

    public function test_teacher_can_download_comma_template(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->get(route("curriculums.template", ["delimiter" => ","]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("programa_estudios,periodo,unidad_academica", $content);
    }

    public function test_teacher_can_download_semicolon_template(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->get(route("curriculums.template", ["delimiter" => ";"]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("programa_estudios;periodo;unidad_academica", $content);
    }

    public function test_import_curriculum_and_courses_creates_new_curriculum_and_generates_codes(): void
    {
        $csvContent = "Programa Estudios,Periodo,Unidad Académica,Créditos,Horas\n" .
            "DISEÑO Y PROGRAMACIÓN WEB,I,Diseño gráfico para la web,3,80\n" .
            "DISEÑO Y PROGRAMACIÓN WEB,I,Maquetación web,3,80\n" .
            "DISEÑO Y PROGRAMACIÓN WEB,II,Diseño web,3,80";

        $file = UploadedFile::fake()->createWithContent("malla_unidades.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("curriculums.import"), [
            "file" => $file,
            "delimiter" => ",",
            "target_mode" => "new",
            "new_curriculum_name" => "Malla Curricular 2026",
            "new_curriculum_year" => "2026",
        ]);

        $this->assertDatabaseHas("curriculums", [
            "name" => "Malla Curricular 2026",
            "year" => "2026",
        ]);

        $curriculum = Curriculum::where("name", "Malla Curricular 2026")->first();
        $response->assertRedirect(route("curriculums.show", $curriculum));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-I-01",
            "name" => "Diseño gráfico para la web",
            "period" => "I",
            "credits" => 3,
            "hours" => 80,
        ]);

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-I-02",
            "name" => "Maquetación web",
        ]);

        $this->assertDatabaseHas("courses", [
            "code" => "DPW-II-01",
            "name" => "Diseño web",
        ]);

        // Check relationship in pivot table
        $this->assertCount(3, $curriculum->courses);
    }

    public function test_import_courses_into_existing_curriculum_with_semicolon(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Malla Existente",
            "year" => "2025",
        ]);

        $csvContent = "periodo;unidad_academica;creditos;horas;codigo_curso\n" .
            "III;Base de Datos;4;96;BD-III-01";

        $file = UploadedFile::fake()->createWithContent("cursos_semicolon.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("curriculums.import"), [
            "file" => $file,
            "delimiter" => ";",
            "target_mode" => "existing",
            "existing_curriculum_id" => $curriculum->id,
        ]);

        $response->assertRedirect(route("curriculums.show", $curriculum));

        $this->assertDatabaseHas("courses", [
            "code" => "BD-III-01",
            "name" => "Base de Datos",
            "period" => "III",
        ]);

        $this->assertTrue($curriculum->courses()->where("code", "BD-III-01")->exists());
    }

    public function test_import_detects_course_code_conflict_and_redirects_to_conflicts(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        // Existing course with same code but different name
        Course::create([
            "code" => "DPW-I-01",
            "name" => "Curso Antiguo Diferente",
            "period" => "I",
            "credits" => 2,
            "hours" => 48,
        ]);

        $csvContent = "Periodo,Unidad Académica,Créditos,Horas,Código\n" .
            "I,Diseño gráfico para la web,3,80,DPW-I-01";

        $file = UploadedFile::fake()->createWithContent("conflicto.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("curriculums.import"), [
            "file" => $file,
            "delimiter" => ",",
            "target_mode" => "existing",
            "existing_curriculum_id" => $curriculum->id,
        ]);

        $response->assertRedirect(route("curriculums.import-conflicts"));
        $response->assertSessionHas("import_curriculum_conflicts");
    }

    public function test_resolve_curriculum_conflicts_updates_and_links(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        $existingCourse = Course::create([
            "code" => "DPW-I-01",
            "name" => "Antiguo Nombre",
            "period" => "I",
            "credits" => 2,
            "hours" => 48,
        ]);

        $response = $this->actingAs($this->teacherUser)
            ->withSession([
                "import_curriculum_id" => $curriculum->id,
                "import_curriculum_conflicts" => [["temp_id" => "1"]],
            ])
            ->post(route("curriculums.import-conflicts.resolve"), [
                "rows" => [
                    "course_1" => [
                        "action" => "update",
                        "existing_course_id" => $existingCourse->id,
                        "code" => "DPW-I-01",
                        "name" => "Nombre Actualizado",
                        "period" => "I",
                        "credits" => 3,
                        "hours" => 80,
                    ],
                ],
            ]);

        $response->assertRedirect(route("curriculums.show", $curriculum));

        $this->assertDatabaseHas("courses", [
            "id" => $existingCourse->id,
            "name" => "Nombre Actualizado",
            "credits" => 3,
            "hours" => 80,
        ]);

        $this->assertTrue($curriculum->courses()->where("courses.id", $existingCourse->id)->exists());
    }

    public function test_cancel_curriculum_conflicts_clears_session(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        $response = $this->actingAs($this->teacherUser)
            ->withSession([
                "import_curriculum_id" => $curriculum->id,
                "import_curriculum_conflicts" => [["temp_id" => "1"]],
            ])
            ->post(route("curriculums.import-conflicts.cancel"));

        $response->assertRedirect(route("curriculums.show", $curriculum));
        $response->assertSessionMissing("import_curriculum_conflicts");
    }
}
