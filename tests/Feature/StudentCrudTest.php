<?php

namespace Tests\Feature;

use App\Models\Curriculum;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $teacherUser;
    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherUser = User::factory()->create([
            "role" => "teacher",
        ]);

        $this->adminUser = User::factory()->create([
            "role" => "admin",
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

    public function test_create_student_validation_fails_when_required_fields_are_missing(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), []);

        $response->assertSessionHasErrors([
            "dni",
            "student_code",
            "study_program",
            "paternal_last_name",
            "maternal_last_name",
            "first_name",
            "institutional_email",
            "admission_date",
        ]);

        $this->assertDatabaseCount("students", 0);
    }

    public function test_create_student_validation_fails_for_duplicate_dni_code_and_email(): void
    {
        Student::create([
            "dni" => "77889900",
            "student_code" => "EST2026001",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Lopez",
            "maternal_last_name" => "Gomez",
            "first_name" => "Mateo",
            "institutional_email" => "mlopez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        // Duplicate DNI
        $responseDni = $this->actingAs($this->teacherUser)->post(route("students.store"), [
            "dni" => "77889900",
            "student_code" => "EST2026002",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Perez",
            "maternal_last_name" => "Rios",
            "first_name" => "Lucia",
            "institutional_email" => "lperez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);
        $responseDni->assertSessionHasErrors(["dni" => "El DNI ya ha sido registrado."]);

        // Duplicate student_code
        $responseCode = $this->actingAs($this->teacherUser)->post(route("students.store"), [
            "dni" => "11223344",
            "student_code" => "EST2026001",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Perez",
            "maternal_last_name" => "Rios",
            "first_name" => "Lucia",
            "institutional_email" => "lperez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);
        $responseCode->assertSessionHasErrors(["student_code" => "El código de estudiante ya ha sido registrado."]);

        // Duplicate institutional_email
        $responseEmail = $this->actingAs($this->teacherUser)->post(route("students.store"), [
            "dni" => "11223344",
            "student_code" => "EST2026002",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Perez",
            "maternal_last_name" => "Rios",
            "first_name" => "Lucia",
            "institutional_email" => "mlopez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);
        $responseEmail->assertSessionHasErrors(["institutional_email" => "El correo institucional ya ha sido registrado."]);
    }

    public function test_create_student_validation_fails_for_invalid_institutional_email_domain(): void
    {
        $invalidEmailData = [
            "dni" => "44556677",
            "student_code" => "EST2026003",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Diaz",
            "maternal_last_name" => "Cruz",
            "first_name" => "Valeria",
            "institutional_email" => "valeria.diaz@gmail.com",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $invalidEmailData);

        $response->assertSessionHasErrors(["institutional_email"]);
        $this->assertDatabaseCount("students", 0);
    }

    public function test_create_student_validation_fails_for_invalid_document_type_and_gender(): void
    {
        $invalidEnumData = [
            "document_type" => "PASAPORTE",
            "dni" => "55667788",
            "student_code" => "EST2026004",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Mendoza",
            "maternal_last_name" => "Flores",
            "first_name" => "Raul",
            "gender" => "NoEspecificado",
            "institutional_email" => "rmendoza@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $invalidEnumData);

        $response->assertSessionHasErrors(["document_type", "gender"]);
        $this->assertDatabaseCount("students", 0);
    }

    public function test_create_student_with_foreign_document_type_ce(): void
    {
        $ceStudentData = [
            "document_type" => "CE",
            "dni" => "CE00123456",
            "student_code" => "EST2026005",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Smith",
            "maternal_last_name" => "Johnson",
            "first_name" => "Emily",
            "gender" => "Femenino",
            "institutional_email" => "esmith@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $ceStudentData);

        $response->assertRedirect(route("students.index"));
        $this->assertDatabaseHas("students", [
            "document_type" => "CE",
            "dni" => "CE00123456",
            "first_name" => "Emily",
        ]);
    }

    public function test_create_student_validation_fails_when_graduation_date_is_before_admission_date(): void
    {
        $invalidDatesData = [
            "dni" => "66778899",
            "student_code" => "EST2026006",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Soto",
            "maternal_last_name" => "Paz",
            "first_name" => "Renato",
            "institutional_email" => "rsoto@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "graduation_date" => "2025-12-31",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $invalidDatesData);

        $response->assertSessionHasErrors(["graduation_date"]);
        $this->assertDatabaseCount("students", 0);
    }

    public function test_create_student_succeeds_with_valid_graduation_date_and_curriculum(): void
    {
        $curriculum = Curriculum::create([
            "name" => "Plan de Estudios 2026",
            "year" => 2026,
        ]);

        $validData = [
            "dni" => "77889911",
            "student_code" => "EST2026007",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Soto",
            "maternal_last_name" => "Paz",
            "first_name" => "Renato",
            "institutional_email" => "rsoto@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "graduation_date" => "2028-12-15",
            "curriculum_id" => $curriculum->id,
            "shift" => "Noche",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $validData);

        $response->assertRedirect(route("students.index"));
        $this->assertDatabaseHas("students", [
            "dni" => "77889911",
            "curriculum_id" => $curriculum->id,
            "shift" => "Noche",
        ]);
    }

    public function test_create_student_validation_fails_for_non_existent_curriculum_id(): void
    {
        $invalidCurriculumData = [
            "dni" => "88990011",
            "student_code" => "EST2026008",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Rios",
            "maternal_last_name" => "Salas",
            "first_name" => "Diana",
            "institutional_email" => "drios@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "curriculum_id" => 99999,
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $invalidCurriculumData);

        $response->assertSessionHasErrors(["curriculum_id"]);
        $this->assertDatabaseCount("students", 0);
    }

    public function test_create_student_validation_fails_when_field_lengths_exceed_limits(): void
    {
        $oversizedData = [
            "dni" => str_repeat("1", 25),
            "student_code" => str_repeat("A", 55),
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => str_repeat("P", 105),
            "maternal_last_name" => str_repeat("M", 105),
            "first_name" => str_repeat("F", 105),
            "institutional_email" => "toolong@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $oversizedData);

        $response->assertSessionHasErrors([
            "dni",
            "student_code",
            "paternal_last_name",
            "maternal_last_name",
            "first_name",
        ]);
    }

    public function test_create_and_update_student_photo_handling(): void
    {
        Storage::fake("public");

        $photo = UploadedFile::fake()->image("avatar.jpg", 200, 200);

        $studentData = [
            "dni" => "33445566",
            "student_code" => "EST2026009",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Gutierrez",
            "maternal_last_name" => "Chavez",
            "first_name" => "Fabiola",
            "institutional_email" => "fgutierrez@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "photo" => $photo,
        ];

        $createResponse = $this->actingAs($this->teacherUser)
            ->post(route("students.store"), $studentData);

        $createResponse->assertRedirect(route("students.index"));

        $student = Student::where("dni", "33445566")->first();
        $this->assertNotNull($student);
        $this->assertNotNull($student->photo_path);
        Storage::disk("public")->assertExists($student->photo_path);

        $oldPhotoPath = $student->photo_path;

        // Replace photo with a new one
        $newPhoto = UploadedFile::fake()->image("new_avatar.png", 200, 200);
        $updateData = [
            "dni" => "33445566",
            "student_code" => "EST2026009",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Gutierrez",
            "maternal_last_name" => "Chavez",
            "first_name" => "Fabiola",
            "institutional_email" => "fgutierrez@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "photo" => $newPhoto,
        ];

        $updateResponse = $this->actingAs($this->teacherUser)
            ->put(route("students.update", $student), $updateData);

        $updateResponse->assertRedirect(route("students.index"));

        $student->refresh();
        $this->assertNotEquals($oldPhotoPath, $student->photo_path);
        Storage::disk("public")->assertMissing($oldPhotoPath);
        Storage::disk("public")->assertExists($student->photo_path);

        // Remove photo via checkbox
        $removePhotoData = [
            "dni" => "33445566",
            "student_code" => "EST2026009",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Gutierrez",
            "maternal_last_name" => "Chavez",
            "first_name" => "Fabiola",
            "institutional_email" => "fgutierrez@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "remove_photo" => "1",
        ];

        $removeResponse = $this->actingAs($this->teacherUser)
            ->put(route("students.update", $student), $removePhotoData);

        $removeResponse->assertRedirect(route("students.index"));

        $student->refresh();
        $this->assertNull($student->photo_path);
    }

    public function test_photo_upload_validation_fails_for_invalid_file_type_and_size(): void
    {
        Storage::fake("public");

        // Non-image file (PDF)
        $pdfFile = UploadedFile::fake()->create("document.pdf", 500, "application/pdf");

        $responseInvalidMime = $this->actingAs($this->teacherUser)->post(route("students.store"), [
            "dni" => "12121212",
            "student_code" => "EST2026010",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Parra",
            "maternal_last_name" => "Silva",
            "first_name" => "Cesar",
            "institutional_email" => "cparra@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "photo" => $pdfFile,
        ]);
        $responseInvalidMime->assertSessionHasErrors(["photo"]);

        // File too large (> 2048 KB)
        $largeImage = UploadedFile::fake()->create("huge_photo.jpg", 3000, "image/jpeg");

        $responseTooLarge = $this->actingAs($this->teacherUser)->post(route("students.store"), [
            "dni" => "12121212",
            "student_code" => "EST2026010",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Parra",
            "maternal_last_name" => "Silva",
            "first_name" => "Cesar",
            "institutional_email" => "cparra@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "photo" => $largeImage,
        ]);
        $responseTooLarge->assertSessionHasErrors(["photo"]);
    }

    public function test_update_student_can_retain_own_unique_values(): void
    {
        $student = Student::create([
            "dni" => "44332211",
            "student_code" => "EST2026011",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Alvarez",
            "maternal_last_name" => "Ponce",
            "first_name" => "Sergio",
            "institutional_email" => "salvarez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        $updateData = [
            "dni" => "44332211",
            "student_code" => "EST2026011",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Alvarez",
            "maternal_last_name" => "Ponce",
            "first_name" => "Sergio Andres",
            "institutional_email" => "salvarez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->put(route("students.update", $student), $updateData);

        $response->assertRedirect(route("students.index"));
        $response->assertSessionHasNoErrors();

        $student->refresh();
        $this->assertEquals("Sergio Andres", $student->first_name);
    }

    public function test_update_student_fails_when_duplicating_another_student_unique_values(): void
    {
        $studentA = Student::create([
            "dni" => "10203040",
            "student_code" => "EST2026012",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Vargas",
            "maternal_last_name" => "Tello",
            "first_name" => "Mario",
            "institutional_email" => "mvargas@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        $studentB = Student::create([
            "dni" => "50607080",
            "student_code" => "EST2026013",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Ruiz",
            "maternal_last_name" => "Castillo",
            "first_name" => "Rosa",
            "institutional_email" => "rruiz@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        // Try to update studentB with studentA's DNI
        $conflictData = [
            "dni" => "10203040",
            "student_code" => "EST2026013",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Ruiz",
            "maternal_last_name" => "Castillo",
            "first_name" => "Rosa",
            "institutional_email" => "rruiz@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ];

        $response = $this->actingAs($this->teacherUser)
            ->put(route("students.update", $studentB), $conflictData);

        $response->assertSessionHasErrors(["dni"]);
    }

    public function test_teacher_cannot_delete_student_but_admin_can(): void
    {
        Storage::fake("public");

        $photo = UploadedFile::fake()->image("to_delete.jpg");
        $photoPath = $photo->store("students", "public");

        $student = Student::create([
            "dni" => "90909090",
            "student_code" => "EST2026014",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Bazan",
            "maternal_last_name" => "Correa",
            "first_name" => "Guillermo",
            "institutional_email" => "gbazan@sam.edu.pe",
            "admission_date" => "2026-03-01",
            "photo_path" => $photoPath,
        ]);

        Storage::disk("public")->assertExists($photoPath);

        // Teacher attempt
        $teacherResponse = $this->actingAs($this->teacherUser)
            ->delete(route("students.destroy", $student));

        $teacherResponse->assertForbidden();
        $this->assertDatabaseHas("students", ["id" => $student->id]);
        Storage::disk("public")->assertExists($photoPath);

        // Admin attempt
        $adminResponse = $this->actingAs($this->adminUser)
            ->delete(route("students.destroy", $student));

        $adminResponse->assertRedirect(route("students.index"));
        $adminResponse->assertSessionHas("success");

        $this->assertDatabaseMissing("students", ["id" => $student->id]);
        Storage::disk("public")->assertMissing($photoPath);
    }

    public function test_students_index_search_and_filter_extreme_cases(): void
    {
        Student::create([
            "dni" => "11112222",
            "student_code" => "EST2026AAA",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Zapata",
            "maternal_last_name" => "Acosta",
            "first_name" => "Alberto",
            "institutional_email" => "azapata@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        Student::create([
            "dni" => "33334444",
            "student_code" => "EST2026BBB",
            "study_program" => "Contabilidad",
            "paternal_last_name" => "Benitez",
            "maternal_last_name" => "Bravo",
            "first_name" => "Bernardo",
            "institutional_email" => "bbenitez@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        // Search by DNI
        $responseDni = $this->actingAs($this->teacherUser)
            ->get(route("students.index", ["search" => "11112222"]));
        $responseDni->assertOk();
        $responseDni->assertSee("Zapata");
        $responseDni->assertDontSee("Benitez");

        // Search by student code
        $responseCode = $this->actingAs($this->teacherUser)
            ->get(route("students.index", ["search" => "EST2026BBB"]));
        $responseCode->assertOk();
        $responseCode->assertSee("Benitez");
        $responseCode->assertDontSee("Zapata");

        // Search with no matches
        $responseNoMatch = $this->actingAs($this->teacherUser)
            ->get(route("students.index", ["search" => "NONEXISTENT_QUERY_999"]));
        $responseNoMatch->assertOk();
        $responseNoMatch->assertDontSee("Zapata");
        $responseNoMatch->assertDontSee("Benitez");
    }

    public function test_check_dni_endpoint_returns_available_for_new_dni(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->getJson(route("students.check-dni", ["dni" => "77889955", "document_type" => "DNI"]));

        $response->assertOk();
        $response->assertJson([
            "valid" => true,
            "exists" => false,
            "available" => true,
        ]);
    }

    public function test_check_dni_endpoint_returns_taken_for_existing_dni(): void
    {
        Student::create([
            "dni" => "77889966",
            "student_code" => "EST2026CHK",
            "study_program" => "Diseño y programación web",
            "paternal_last_name" => "Reyes",
            "maternal_last_name" => "Poma",
            "first_name" => "Carlos",
            "institutional_email" => "creyes@sam.edu.pe",
            "admission_date" => "2026-03-01",
        ]);

        $response = $this->actingAs($this->teacherUser)
            ->getJson(route("students.check-dni", ["dni" => "77889966", "document_type" => "DNI"]));

        $response->assertOk();
        $response->assertJson([
            "valid" => true,
            "exists" => true,
            "available" => false,
        ]);
        $response->assertJsonPath("student.student_code", "EST2026CHK");
    }

    public function test_check_dni_endpoint_handles_invalid_length_and_empty(): void
    {
        // Too short for DNI
        $responseShort = $this->actingAs($this->teacherUser)
            ->getJson(route("students.check-dni", ["dni" => "1234", "document_type" => "DNI"]));

        $responseShort->assertOk();
        $responseShort->assertJson([
            "valid" => false,
            "available" => false,
        ]);

        // Empty DNI
        $responseEmpty = $this->actingAs($this->teacherUser)
            ->getJson(route("students.check-dni", ["dni" => ""]));

        $responseEmpty->assertOk();
        $responseEmpty->assertJson([
            "valid" => false,
            "available" => false,
        ]);
    }
}
