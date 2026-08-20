<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Curriculum;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where("dni", "like", "%{$search}%")
                    ->orWhere("student_code", "like", "%{$search}%")
                    ->orWhere("paternal_last_name", "like", "%{$search}%")
                    ->orWhere("maternal_last_name", "like", "%{$search}%")
                    ->orWhere("first_name", "like", "%{$search}%")
                    ->orWhere("study_program", "like", "%{$search}%");
            })
            ->orderBy("paternal_last_name")
            ->paginate(10)
            ->withQueryString();

        $curriculums = Curriculum::all();

        return view("students.index", compact("students", "search", "curriculums"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $curriculums = Curriculum::all();
        return view("students.create", compact("curriculums"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "dni" => "required|string|unique:students,dni|max:20",
            "student_code" => "required|string|unique:students,student_code|max:50",
            "study_program" => "required|string|max:255",
            "paternal_last_name" => "required|string|max:100",
            "maternal_last_name" => "required|string|max:100",
            "first_name" => "required|string|max:100",
            "gender" => "nullable|string|in:Masculino,Femenino",
            "personal_email" => "nullable|email|max:255",
            "institutional_email" => "required|email|unique:students,institutional_email|max:255",
            "phone" => "nullable|string|max:20",
            "mobile" => "nullable|string|max:20",
            "admission_date" => "required|date",
            "graduation_date" => "nullable|date|after_or_equal:admission_date",
            "curriculum_id" => "nullable|exists:curriculums,id",
            "shift" => "nullable|string|max:50",
        ]);

        Student::create($validated);

        return redirect()->route("students.index")
            ->with("success", "Estudiante creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        return view("students.show", compact("student"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $curriculums = Curriculum::all();
        return view("students.edit", compact("student", "curriculums"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            "dni" => "required|string|max:20|unique:students,dni," . $student->id,
            "student_code" => "required|string|max:50|unique:students,student_code," . $student->id,
            "study_program" => "required|string|max:255",
            "paternal_last_name" => "required|string|max:100",
            "maternal_last_name" => "required|string|max:100",
            "first_name" => "required|string|max:100",
            "gender" => "nullable|string|in:Masculino,Femenino",
            "personal_email" => "nullable|email|max:255",
            "institutional_email" => "required|email|max:255|unique:students,institutional_email," . $student->id,
            "phone" => "nullable|string|max:20",
            "mobile" => "nullable|string|max:20",
            "admission_date" => "required|date",
            "graduation_date" => "nullable|date|after_or_equal:admission_date",
            "curriculum_id" => "nullable|exists:curriculums,id",
            "shift" => "nullable|string|max:50",
        ]);

        $student->update($validated);

        return redirect()->route("students.index")
            ->with("success", "Estudiante actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route("students.index")
            ->with("success", "Estudiante eliminado exitosamente.");
    }

    /**
     * Download CSV template for students import in Spanish.
     */
    public function downloadTemplate(Request $request): StreamedResponse
    {
        $delimiter = $request->query("delimiter", ",");
        if ($delimiter === "semicolon" || $delimiter === ";") {
            $delimiter = ";";
        } else {
            $delimiter = ",";
        }

        $headers = [
            "dni",
            "codigo",
            "apellido_paterno",
            "apellido_materno",
            "nombres",
            "genero",
            "programa_estudio",
            "email_institucional",
            "email_personal",
            "telefono",
            "celular",
            "fecha_ingreso",
            "fecha_egreso",
            "turno",
        ];

        $sampleRow = [
            "71234567",
            "EST2026010",
            "Gomez",
            "Perez",
            "Carlos",
            "Masculino",
            "Diseño y programación web",
            "cgomez@instituto.edu.pe",
            "carlos.gomez@gmail.com",
            "014567890",
            "987654321",
            "2026-03-01",
            "",
            "Diurno (Mañana)",
        ];

        $filename = "plantilla_estudiantes.csv";

        return response()->streamDownload(function () use ($headers, $sampleRow, $delimiter) {
            $output = fopen("php://output", "w");
            // UTF-8 BOM for Excel compatibility
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, $headers, $delimiter);
            fputcsv($output, $sampleRow, $delimiter);
            fclose($output);
        }, $filename, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Import students from uploaded CSV file.
     * Non-conflicting rows are inserted directly; conflicting rows are saved in session for user review.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            "file" => ["required", "file", "mimes:csv,txt", "max:10240"],
            "delimiter" => ["required", "string", Rule::in([",", ";", "auto", "comma", "semicolon"])],
            "default_curriculum_id" => ["nullable", "exists:curriculums,id"],
        ]);

        $file = $request->file("file");
        $filePath = $file->getRealPath();
        $inputDelimiter = $request->input("delimiter");
        $defaultCurriculumId = $request->input("default_curriculum_id");

        $handle = fopen($filePath, "r");
        if (!$handle) {
            return redirect()->route("students.index")
                ->with("error", "No se pudo abrir el archivo CSV.");
        }

        // Determine delimiter
        $delimiter = $inputDelimiter;
        if ($delimiter === "comma") {
            $delimiter = ",";
        } elseif ($delimiter === "semicolon") {
            $delimiter = ";";
        } elseif ($delimiter === "auto") {
            $firstLine = fgets($handle);
            rewind($handle);
            $commaCount = substr_count($firstLine, ",");
            $semicolonCount = substr_count($firstLine, ";");
            $delimiter = $semicolonCount > $commaCount ? ";" : ",";
        }

        // Read header row
        $rawHeaders = fgetcsv($handle, 0, $delimiter);
        if (!$rawHeaders || empty(array_filter($rawHeaders))) {
            fclose($handle);
            return redirect()->route("students.index")
                ->with("error", "El archivo CSV está vacío o el separador seleccionado no coincide.");
        }

        // Remove UTF-8 BOM from the first header if present
        $rawHeaders[0] = preg_replace("/^\xEF\xBB\xBF/", "", $rawHeaders[0]);

        $headerMap = $this->getHeaderMapping();
        $columnIndices = [];

        foreach ($rawHeaders as $index => $headerName) {
            $normalized = $this->normalizeHeader((string)$headerName);
            if (isset($headerMap[$normalized])) {
                $field = $headerMap[$normalized];
                $columnIndices[$field] = $index;
            }
        }

        // Ensure minimum required columns can be resolved
        $requiredFields = ["dni", "student_code", "paternal_last_name", "maternal_last_name", "first_name"];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($columnIndices[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            fclose($handle);
            return redirect()->route("students.index")
                ->with("error", "No se encontraron todas las columnas requeridas en el archivo CSV. Columnas faltantes: " . implode(", ", $missingFields) . ". Asegúrese de seleccionar el delimitador correcto.");
        }

        $createdCount = 0;
        $errors = [];
        $conflicts = [];
        $rowNumber = 1;
        $seenDnisInBatch = [];
        $seenCodesInBatch = [];

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rowNumber++;

                // Skip completely empty lines
                if (empty(array_filter($row, function ($v) { return trim($v) !== ""; }))) {
                    continue;
                }

                $getValue = function (string $field) use ($columnIndices, $row) {
                    if (isset($columnIndices[$field]) && isset($row[$columnIndices[$field]])) {
                        return trim($row[$columnIndices[$field]]);
                    }
                    return "";
                };

                $dni = $getValue("dni");
                $studentCode = $getValue("student_code");
                $paternalLastName = $getValue("paternal_last_name");
                $maternalLastName = $getValue("maternal_last_name");
                $firstName = $getValue("first_name");
                $genderRaw = $getValue("gender");
                $studyProgram = $getValue("study_program");
                $institutionalEmail = $getValue("institutional_email");
                $personalEmail = $getValue("personal_email");
                $phone = $getValue("phone");
                $mobile = $getValue("mobile");
                $admissionDateRaw = $getValue("admission_date");
                $graduationDateRaw = $getValue("graduation_date");
                $degreeDateRaw = $getValue("degree_date");
                $shift = $getValue("shift");
                $curriculumVal = $getValue("curriculum_id");

                // Validations for essential fields
                if (empty($dni) || empty($studentCode) || empty($paternalLastName) || empty($maternalLastName) || empty($firstName)) {
                    $errors[] = "Fila {$rowNumber}: Faltan datos obligatorios (DNI, código, nombres o apellidos).";
                    continue;
                }

                $gender = null;
                if (!empty($genderRaw)) {
                    $genderClean = mb_strtolower($genderRaw, "UTF-8");
                    if (in_array($genderClean, ["masculino", "m", "hombre", "varon", "varón"])) {
                        $gender = "Masculino";
                    } elseif (in_array($genderClean, ["femenino", "f", "mujer"])) {
                        $gender = "Femenino";
                    }
                }

                if (empty($studyProgram)) {
                    $studyProgram = "Diseño y programación web";
                }

                if (empty($institutionalEmail)) {
                    $institutionalEmail = strtolower($studentCode) . "@instituto.edu.pe";
                }

                $admissionDate = $this->parseDate($admissionDateRaw, Carbon::today()->format("Y-m-d"));
                $graduationDate = $this->parseDate($graduationDateRaw);
                $degreeDate = $this->parseDate($degreeDateRaw);

                $curriculumId = !empty($curriculumVal) && is_numeric($curriculumVal)
                    ? (int)$curriculumVal
                    : $defaultCurriculumId;

                $studentData = [
                    "dni" => $dni,
                    "student_code" => $studentCode,
                    "study_program" => $studyProgram,
                    "paternal_last_name" => $paternalLastName,
                    "maternal_last_name" => $maternalLastName,
                    "first_name" => $firstName,
                    "gender" => $gender,
                    "personal_email" => !empty($personalEmail) ? $personalEmail : null,
                    "institutional_email" => $institutionalEmail,
                    "phone" => !empty($phone) ? $phone : null,
                    "mobile" => !empty($mobile) ? $mobile : null,
                    "admission_date" => $admissionDate,
                    "graduation_date" => $graduationDate,
                    "degree_date" => $degreeDate,
                    "curriculum_id" => $curriculumId,
                    "shift" => !empty($shift) ? $shift : null,
                ];

                // Detect conflicts against DB
                $existingByDni = Student::where("dni", $dni)->first();
                $existingByCode = Student::where("student_code", $studentCode)->first();
                $existingByEmail = Student::where("institutional_email", $institutionalEmail)->first();

                $reasons = [];
                $existingStudent = $existingByDni ?? $existingByCode ?? $existingByEmail;

                if ($existingByDni) {
                    $reasons[] = "DNI ya registrado en base de datos";
                }
                if ($existingByCode) {
                    $reasons[] = "Código de estudiante ya registrado en base de datos";
                }
                if ($existingByEmail) {
                    $reasons[] = "Correo institucional ya registrado en base de datos";
                }

                // Detect duplicates within current CSV file
                if (isset($seenDnisInBatch[$dni])) {
                    $reasons[] = "DNI repetido en este archivo (aparece en fila {$seenDnisInBatch[$dni]})";
                }
                if (isset($seenCodesInBatch[$studentCode])) {
                    $reasons[] = "Código repetido en este archivo (aparece en fila {$seenCodesInBatch[$studentCode]})";
                }

                if (!empty($reasons)) {
                    // Conflict detected: save for interactive review
                    $conflicts[] = [
                        "temp_id" => "row_" . $rowNumber . "_" . uniqid(),
                        "row_number" => $rowNumber,
                        "reasons" => $reasons,
                        "existing_student_id" => $existingStudent ? $existingStudent->id : null,
                        "existing_summary" => $existingStudent ? "{$existingStudent->full_name} (DNI: {$existingStudent->dni}, Código: {$existingStudent->student_code})" : null,
                        "data" => $studentData,
                        "action" => $existingStudent ? "update" : "create",
                    ];
                } else {
                    // No conflict: create immediately
                    Student::create($studentData);
                    $createdCount++;
                    $seenDnisInBatch[$dni] = $rowNumber;
                    $seenCodesInBatch[$studentCode] = $rowNumber;
                }
            }

            fclose($handle);
            DB::commit();
        } catch (\Throwable $e) {
            fclose($handle);
            DB::rollBack();
            return redirect()->route("students.index")
                ->with("error", "Ocurrió un error inesperado al procesar el archivo: " . $e->getMessage());
        }

        // If there are conflicts, redirect to interactive conflict resolution screen
        if (!empty($conflicts)) {
            session([
                "import_pending_conflicts" => $conflicts,
                "import_saved_count" => $createdCount,
            ]);

            return redirect()->route("students.import-conflicts")
                ->with("info", "Se registraron {$createdCount} estudiantes sin conflicto. Se encontraron " . count($conflicts) . " registros con duplicados o similitudes para revisión.");
        }

        $message = "Importación completada exitosamente. {$createdCount} estudiantes registrados.";
        $response = redirect()->route("students.index")->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", array_slice($errors, 0, 50));
        }

        return $response;
    }

    /**
     * Show interactive review screen for import conflicts.
     */
    public function showConflicts(): View|RedirectResponse
    {
        $conflicts = session("import_pending_conflicts");
        if (empty($conflicts) || !is_array($conflicts)) {
            return redirect()->route("students.index")
                ->with("info", "No hay registros pendientes de resolución de conflictos.");
        }

        $savedCount = (int)session("import_saved_count", 0);
        $curriculums = Curriculum::all();

        return view("students.import_conflicts", compact("conflicts", "savedCount", "curriculums"));
    }

    /**
     * Process user resolutions for import conflicts.
     */
    public function resolveConflicts(Request $request): RedirectResponse
    {
        $rows = $request->input("rows", []);
        if (empty($rows) || !is_array($rows)) {
            session()->forget(["import_pending_conflicts", "import_saved_count"]);
            return redirect()->route("students.index")
                ->with("info", "No se recibieron registros para procesar.");
        }

        $createdCount = 0;
        $updatedCount = 0;
        $ignoredCount = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($rows as $tempId => $rowData) {
                $action = $rowData["action"] ?? "ignore";

                if ($action === "ignore") {
                    $ignoredCount++;
                    continue;
                }

                $existingId = !empty($rowData["existing_student_id"]) ? (int)$rowData["existing_student_id"] : null;
                $dni = trim($rowData["dni"] ?? "");
                $studentCode = trim($rowData["student_code"] ?? "");
                $firstName = trim($rowData["first_name"] ?? "");
                $genderRaw = trim($rowData["gender"] ?? "");
                $paternalLastName = trim($rowData["paternal_last_name"] ?? "");
                $maternalLastName = trim($rowData["maternal_last_name"] ?? "");
                $studyProgram = trim($rowData["study_program"] ?? "Diseño y programación web");
                $institutionalEmail = trim($rowData["institutional_email"] ?? "");
                $personalEmail = trim($rowData["personal_email"] ?? "");
                $phone = trim($rowData["phone"] ?? "");
                $mobile = trim($rowData["mobile"] ?? "");
                $admissionDate = $this->parseDate($rowData["admission_date"] ?? null, Carbon::today()->format("Y-m-d"));
                $graduationDate = $this->parseDate($rowData["graduation_date"] ?? null);
                $shift = trim($rowData["shift"] ?? "");
                $curriculumId = !empty($rowData["curriculum_id"]) && is_numeric($rowData["curriculum_id"]) ? (int)$rowData["curriculum_id"] : null;

                if (empty($dni) || empty($studentCode) || empty($firstName) || empty($paternalLastName) || empty($maternalLastName)) {
                    $errors[] = "Fila con DNI '{$dni}': Faltan campos obligatorios.";
                    continue;
                }

                $gender = null;
                if (!empty($genderRaw)) {
                    $genderClean = mb_strtolower($genderRaw, "UTF-8");
                    if (in_array($genderClean, ["masculino", "m", "hombre", "varon", "varón"])) {
                        $gender = "Masculino";
                    } elseif (in_array($genderClean, ["femenino", "f", "mujer"])) {
                        $gender = "Femenino";
                    }
                }

                if (empty($institutionalEmail)) {
                    $institutionalEmail = strtolower($studentCode) . "@instituto.edu.pe";
                }

                $studentData = [
                    "dni" => $dni,
                    "student_code" => $studentCode,
                    "study_program" => $studyProgram,
                    "paternal_last_name" => $paternalLastName,
                    "maternal_last_name" => $maternalLastName,
                    "first_name" => $firstName,
                    "gender" => $gender,
                    "personal_email" => !empty($personalEmail) ? $personalEmail : null,
                    "institutional_email" => $institutionalEmail,
                    "phone" => !empty($phone) ? $phone : null,
                    "mobile" => !empty($mobile) ? $mobile : null,
                    "admission_date" => $admissionDate,
                    "graduation_date" => $graduationDate,
                    "curriculum_id" => $curriculumId,
                    "shift" => !empty($shift) ? $shift : null,
                ];

                if ($action === "update") {
                    $targetStudent = null;
                    if ($existingId) {
                        $targetStudent = Student::find($existingId);
                    }
                    if (!$targetStudent) {
                        $targetStudent = Student::where("dni", $dni)
                            ->orWhere("student_code", $studentCode)
                            ->orWhere("institutional_email", $institutionalEmail)
                            ->first();
                    }

                    if (!$targetStudent) {
                        Student::create($studentData);
                        $createdCount++;
                    } else {
                        // Check if new values conflict with OTHER students
                        $conflict = Student::where("id", "!=", $targetStudent->id)
                            ->where(function ($q) use ($dni, $studentCode, $institutionalEmail) {
                                $q->where("dni", $dni)
                                    ->orWhere("student_code", $studentCode)
                                    ->orWhere("institutional_email", $institutionalEmail);
                            })
                            ->exists();

                        if ($conflict) {
                            $errors[] = "No se pudo actualizar {$dni}: El DNI, código o email ya pertenece a otro estudiante.";
                            continue;
                        }

                        $targetStudent->update($studentData);
                        $updatedCount++;
                    }
                } elseif ($action === "create") {
                    $conflict = Student::where("dni", $dni)
                        ->orWhere("student_code", $studentCode)
                        ->orWhere("institutional_email", $institutionalEmail)
                        ->exists();

                    if ($conflict) {
                        $errors[] = "No se pudo registrar {$dni} como nuevo: Ya existe un registro con ese DNI, código o email.";
                        continue;
                    }

                    Student::create($studentData);
                    $createdCount++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route("students.import-conflicts")
                ->with("error", "Ocurrió un error al procesar las resoluciones: " . $e->getMessage());
        }

        session()->forget(["import_pending_conflicts", "import_saved_count"]);

        $message = "Resolución de importación finalizada: {$createdCount} creados, {$updatedCount} actualizados, {$ignoredCount} omitidos.";
        $response = redirect()->route("students.index")->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", $errors);
        }

        return $response;
    }

    /**
     * Cancel and discard pending conflict records.
     */
    public function cancelConflicts(): RedirectResponse
    {
        session()->forget(["import_pending_conflicts", "import_saved_count"]);
        return redirect()->route("students.index")
            ->with("info", "Se han cancelado y descartado los registros pendientes en conflicto.");
    }

    /**
     * Map of normalized CSV header keys to database fields.
     */
    private function getHeaderMapping(): array
    {
        return [
            "dni" => "dni",
            "documento" => "dni",
            "cedula" => "dni",
            "studentcode" => "student_code",
            "codigo" => "student_code",
            "codigoestudiante" => "student_code",
            "codestudiante" => "student_code",
            "paternallastname" => "paternal_last_name",
            "apellidopaterno" => "paternal_last_name",
            "primerapellido" => "paternal_last_name",
            "apellidopat" => "paternal_last_name",
            "maternallastname" => "maternal_last_name",
            "apellidomaterno" => "maternal_last_name",
            "segundoapellido" => "maternal_last_name",
            "apellidomat" => "maternal_last_name",
            "firstname" => "first_name",
            "nombres" => "first_name",
            "nombre" => "first_name",
            "gender" => "gender",
            "genero" => "gender",
            "sexo" => "gender",
            "studyprogram" => "study_program",
            "programaestudio" => "study_program",
            "programadeestudio" => "study_program",
            "programa" => "study_program",
            "carrera" => "study_program",
            "institutionalemail" => "institutional_email",
            "emailinstitucional" => "institutional_email",
            "correoinstitucional" => "institutional_email",
            "personalemail" => "personal_email",
            "emailpersonal" => "personal_email",
            "correopersonal" => "personal_email",
            "email" => "personal_email",
            "correo" => "personal_email",
            "phone" => "phone",
            "telefono" => "phone",
            "telefonofijo" => "phone",
            "mobile" => "mobile",
            "celular" => "mobile",
            "movil" => "mobile",
            "admissiondate" => "admission_date",
            "fechaingreso" => "admission_date",
            "fechadeingreso" => "admission_date",
            "ingreso" => "admission_date",
            "graduationdate" => "graduation_date",
            "fechaegreso" => "graduation_date",
            "fechadegreso" => "graduation_date",
            "egreso" => "graduation_date",
            "degreedate" => "degree_date",
            "fechatitulacion" => "degree_date",
            "fechadetitulacion" => "degree_date",
            "titulacion" => "degree_date",
            "curriculumid" => "curriculum_id",
            "mallacurricular" => "curriculum_id",
            "malla" => "curriculum_id",
            "shift" => "shift",
            "turno" => "shift",
        ];
    }

    /**
     * Clean and normalize a CSV column header name.
     */
    private function normalizeHeader(string $header): string
    {
        $header = trim($header);
        $header = mb_strtolower($header, "UTF-8");
        $unwanted = [
            "á" => "a", "é" => "e", "í" => "i", "ó" => "o", "ú" => "u",
            "Á" => "a", "É" => "e", "Í" => "i", "Ó" => "o", "Ú" => "u",
            "ñ" => "n", "Ñ" => "n",
        ];
        $header = strtr($header, $unwanted);
        $header = preg_replace("/[^a-z0-9]/", "", $header);
        return $header;
    }

    /**
     * Flexible date parser for various string formats.
     */
    private function parseDate(?string $value, ?string $default = null): ?string
    {
        if (empty($value)) {
            return $default;
        }

        $value = trim($value);

        if (preg_match("/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/", $value, $matches)) {
            return sprintf("%04d-%02d-%02d", $matches[3], $matches[2], $matches[1]);
        }

        if (preg_match("/^(\d{1,2})-(\d{1,2})-(\d{4})$/", $value, $matches)) {
            return sprintf("%04d-%02d-%02d", $matches[3], $matches[2], $matches[1]);
        }

        try {
            return Carbon::parse($value)->format("Y-m-d");
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
