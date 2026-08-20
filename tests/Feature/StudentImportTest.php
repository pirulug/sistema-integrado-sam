<?php

namespace Tests\Feature;

use App\Models\Curriculum;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StudentImportTest extends TestCase
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
            ->get(route("students.template", ["delimiter" => ","]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("dni,codigo,apellido_paterno", $content);
        $this->assertStringContainsString("genero", $content);
    }

    public function test_teacher_can_download_semicolon_template(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->get(route("students.template", ["delimiter" => ";"]));

        $response->assertOk();
        $response->assertHeader("content-type", "text/csv; charset=UTF-8");
        $content = $response->streamedContent();
        $this->assertStringContainsString("dni;codigo;apellido_paterno", $content);
        $this->assertStringContainsString("genero", $content);
    }

    public function test_import_students_with_comma_delimiter_without_conflicts(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Malla 2026",
            "year" => "2026",
        ]);

        $csvContent = "dni,codigo,apellido_paterno,apellido_materno,nombres,genero,programa_estudio,email_institucional,email_personal,telefono,celular,fecha_ingreso,fecha_egreso,turno\n" .
            "11223344,EST2026001,Flores,Morales,Ana,Femenino,Diseño y programación web,aflores@instituto.edu.pe,ana@gmail.com,012345678,987654321,2026-03-01,,Diurno (Mañana)\n" .
            "22334455,EST2026002,Quispe,Ramos,Luis,Masculino,Diseño y programación web,lquispe@instituto.edu.pe,luis@gmail.com,012345679,987654322,2026-03-01,,Nocturno (Noche)";

        $file = UploadedFile::fake()->createWithContent("estudiantes.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("students.import"), [
            "file" => $file,
            "delimiter" => ",",
            "default_curriculum_id" => $curriculum->id,
        ]);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "11223344",
            "student_code" => "EST2026001",
            "paternal_last_name" => "Flores",
            "first_name" => "Ana",
            "gender" => "Femenino",
            "curriculum_id" => $curriculum->id,
        ]);

        $this->assertDatabaseHas("students", [
            "dni" => "22334455",
            "student_code" => "EST2026002",
            "paternal_last_name" => "Quispe",
            "first_name" => "Luis",
            "gender" => "Masculino",
            "shift" => "Nocturno (Noche)",
        ]);
    }

    public function test_import_students_with_semicolon_delimiter(): void
    {
        $csvContent = "dni;codigo;apellido_paterno;apellido_materno;nombres;genero;programa_estudio;email_institucional;email_personal;telefono;celular;fecha_ingreso;fecha_egreso;turno\n" .
            "33445566;EST2026003;Torres;Castro;Elena;F;Diseño y programación web;etorres@instituto.edu.pe;elena@gmail.com;012345680;987654323;2026-03-01;;Diurno (Tarde)";

        $file = UploadedFile::fake()->createWithContent("estudiantes_semicolon.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("students.import"), [
            "file" => $file,
            "delimiter" => ";",
        ]);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "33445566",
            "student_code" => "EST2026003",
            "paternal_last_name" => "Torres",
            "first_name" => "Elena",
            "gender" => "Femenino",
            "shift" => "Diurno (Tarde)",
        ]);
    }

    public function test_import_students_normalizes_gender_variants(): void
    {
        $csvContent = "dni,codigo,apellido_paterno,apellido_materno,nombres,sexo\n" .
            "66778899,EST2026008,Alvarez,Silva,Pedro,m\n" .
            "77889900,EST2026009,Mendoza,Rios,Carla,mujer";

        $file = UploadedFile::fake()->createWithContent("estudiantes_generos.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("students.import"), [
            "file" => $file,
            "delimiter" => ",",
        ]);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "66778899",
            "student_code" => "EST2026008",
            "gender" => "Masculino",
        ]);

        $this->assertDatabaseHas("students", [
            "dni" => "77889900",
            "student_code" => "EST2026009",
            "gender" => "Femenino",
        ]);
    }

    public function test_import_students_auto_detects_delimiter(): void
    {
        $csvContent = "dni;codigo;apellido_paterno;apellido_materno;nombres\n" .
            "44556677;EST2026004;Vargas;Mendoza;Rosa";

        $file = UploadedFile::fake()->createWithContent("estudiantes_auto.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("students.import"), [
            "file" => $file,
            "delimiter" => "auto",
        ]);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "44556677",
            "student_code" => "EST2026004",
            "first_name" => "Rosa",
        ]);
    }

    public function test_import_detects_duplicate_and_redirects_to_conflicts_view(): void
    {
        $existing = Student::create([
            "dni" => "55667788",
            "student_code" => "EST2026005",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Antiguo",
            "maternal_last_name" => "Paterno",
            "first_name" => "Mario",
            "institutional_email" => "mario.old@instituto.edu.pe",
            "admission_date" => "2026-01-01",
        ]);

        // CSV with 1 clean student and 1 conflicting student
        $csvContent = "dni,codigo,apellido_paterno,apellido_materno,nombres,programa_estudio,email_institucional,fecha_ingreso\n" .
            "99887766,EST2026099,Nuevo,Alumno,Carlos,Diseño y programación web,carlos.nuevo@instituto.edu.pe,2026-02-01\n" .
            "55667788,EST2026005,Duplicado,Paterno,Mario,Diseño y programación web,mario.dupl@instituto.edu.pe,2026-01-01";

        $file = UploadedFile::fake()->createWithContent("conflictos.csv", $csvContent);

        $response = $this->actingAs($this->teacherUser)->post(route("students.import"), [
            "file" => $file,
            "delimiter" => ",",
        ]);

        // Must redirect to conflicts screen
        $response->assertRedirect(route("students.import-conflicts"));
        $response->assertSessionHas("import_pending_conflicts");

        // The clean student was already saved
        $this->assertDatabaseHas("students", [
            "dni" => "99887766",
            "student_code" => "EST2026099",
        ]);

        // Existing student has not been overwritten yet
        $this->assertDatabaseHas("students", [
            "dni" => "55667788",
            "paternal_last_name" => "Antiguo",
        ]);
    }

    public function test_resolve_conflicts_screen_renders_with_session(): void
    {
        $conflicts = [
            [
                "temp_id" => "row_2_test",
                "row_number" => 2,
                "reasons" => ["DNI ya registrado en base de datos"],
                "existing_student_id" => 1,
                "existing_summary" => "Mario Antiguo",
                "data" => [
                    "dni" => "55667788",
                    "student_code" => "EST2026005",
                    "paternal_last_name" => "Duplicado",
                    "maternal_last_name" => "Paterno",
                    "first_name" => "Mario",
                    "institutional_email" => "mario.dupl@instituto.edu.pe",
                    "study_program" => "Diseño y programación web",
                    "admission_date" => "2026-01-01",
                    "graduation_date" => null,
                    "curriculum_id" => null,
                    "shift" => null,
                    "personal_email" => null,
                    "phone" => null,
                    "mobile" => null,
                ],
                "action" => "update",
            ]
        ];

        $response = $this->actingAs($this->teacherUser)
            ->withSession([
                "import_pending_conflicts" => $conflicts,
                "import_saved_count" => 1,
            ])
            ->get(route("students.import-conflicts"));

        $response->assertOk();
        $response->assertSee("Resolución de Conflictos de Importación");
        $response->assertSee("Fila CSV #2");
        $response->assertSee("DNI ya registrado en base de datos");
    }

    public function test_resolve_conflicts_updates_existing_student(): void
    {
        $existing = Student::create([
            "dni" => "55667788",
            "student_code" => "EST2026005",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Antiguo",
            "maternal_last_name" => "Paterno",
            "first_name" => "Mario",
            "gender" => "Masculino",
            "institutional_email" => "mario.old@instituto.edu.pe",
            "admission_date" => "2026-01-01",
        ]);

        $response = $this->actingAs($this->teacherUser)->post(route("students.import-conflicts.resolve"), [
            "rows" => [
                "row_2_test" => [
                    "action" => "update",
                    "existing_student_id" => $existing->id,
                    "dni" => "55667788",
                    "student_code" => "EST2026005",
                    "paternal_last_name" => "Actualizado",
                    "maternal_last_name" => "Paterno",
                    "first_name" => "Mario",
                    "gender" => "Masculino",
                    "institutional_email" => "mario.actualizado@instituto.edu.pe",
                    "study_program" => "Diseño y programación web",
                    "admission_date" => "2026-01-01",
                ],
            ],
        ]);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHas("success");

        $this->assertDatabaseHas("students", [
            "dni" => "55667788",
            "paternal_last_name" => "Actualizado",
            "gender" => "Masculino",
            "institutional_email" => "mario.actualizado@instituto.edu.pe",
        ]);
    }

    public function test_resolve_conflicts_creates_as_new_with_edited_dni(): void
    {
        Student::create([
            "dni" => "55667788",
            "student_code" => "EST2026005",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Existente",
            "maternal_last_name" => "Paterno",
            "first_name" => "Mario",
            "institutional_email" => "mario@instituto.edu.pe",
            "admission_date" => "2026-01-01",
        ]);

        // User changes DNI and Code to avoid conflict and selects 'create'
        $response = $this->actingAs($this->teacherUser)->post(route("students.import-conflicts.resolve"), [
            "rows" => [
                "row_2_test" => [
                    "action" => "create",
                    "dni" => "55667799", // Edited DNI
                    "student_code" => "EST2026006", // Edited Code
                    "paternal_last_name" => "NuevoHermano",
                    "maternal_last_name" => "Paterno",
                    "first_name" => "Luigi",
                    "gender" => "Masculino",
                    "institutional_email" => "luigi@instituto.edu.pe",
                    "study_program" => "Diseño y programación web",
                    "admission_date" => "2026-01-01",
                ],
            ],
        ]);

        $response->assertRedirect(route("students.index"));

        $this->assertDatabaseHas("students", [
            "dni" => "55667799",
            "student_code" => "EST2026006",
            "first_name" => "Luigi",
            "gender" => "Masculino",
        ]);
    }

    public function test_resolve_conflicts_ignores_row(): void
    {
        $response = $this->actingAs($this->teacherUser)->post(route("students.import-conflicts.resolve"), [
            "rows" => [
                "row_2_test" => [
                    "action" => "ignore",
                    "dni" => "88888888",
                    "student_code" => "EST2026888",
                    "paternal_last_name" => "Descartado",
                    "maternal_last_name" => "Descartado",
                    "first_name" => "Descartado",
                ],
            ],
        ]);

        $response->assertRedirect(route("students.index"));

        $this->assertDatabaseMissing("students", [
            "dni" => "88888888",
        ]);
    }

    public function test_cancel_conflicts_clears_session(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->withSession([
                "import_pending_conflicts" => [["temp_id" => "1"]],
                "import_saved_count" => 2,
            ])
            ->post(route("students.import-conflicts.cancel"));

        $response->assertRedirect(route("students.index"));
        $response->assertSessionMissing("import_pending_conflicts");
        $response->assertSessionHas("info");
    }
}
