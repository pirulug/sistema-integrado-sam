<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");

        $teachers = Teacher::query()
            ->when($search, function ($query, $search) {
                $query->where("dni", "like", "%{$search}%")
                    ->orWhere("teacher_code", "like", "%{$search}%")
                    ->orWhere("paternal_last_name", "like", "%{$search}%")
                    ->orWhere("maternal_last_name", "like", "%{$search}%")
                    ->orWhere("first_name", "like", "%{$search}%");
            })
            ->orderBy("paternal_last_name")
            ->paginate(10)
            ->withQueryString();

        return view("teachers.index", compact("teachers", "search"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("teachers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "dni" => "required|string|unique:teachers,dni|max:20",
            "teacher_code" => "required|string|unique:teachers,teacher_code|max:50",
            "paternal_last_name" => "required|string|max:100",
            "maternal_last_name" => "required|string|max:100",
            "first_name" => "required|string|max:100",
            "personal_email" => "nullable|email|max:255",
            "institutional_email" => "required|email|unique:teachers,institutional_email|max:255",
            "phone" => "nullable|string|max:20",
            "mobile" => "nullable|string|max:20",
            "hire_date" => "required|date",
        ]);

        Teacher::create($validated);

        return redirect()->route("teachers.index")
            ->with("success", "Profesor creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher): View
    {
        return view("teachers.show", compact("teacher"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher): View
    {
        return view("teachers.edit", compact("teacher"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            "dni" => "required|string|max:20|unique:teachers,dni," . $teacher->id,
            "teacher_code" => "required|string|max:50|unique:teachers,teacher_code," . $teacher->id,
            "paternal_last_name" => "required|string|max:100",
            "maternal_last_name" => "required|string|max:100",
            "first_name" => "required|string|max:100",
            "personal_email" => "nullable|email|max:255",
            "institutional_email" => "required|email|max:255|unique:teachers,institutional_email," . $teacher->id,
            "phone" => "nullable|string|max:20",
            "mobile" => "nullable|string|max:20",
            "hire_date" => "required|date",
        ]);

        $teacher->update($validated);

        return redirect()->route("teachers.index")
            ->with("success", "Profesor actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route("teachers.index")
            ->with("success", "Profesor eliminado exitosamente.");
    }

    /**
     * Download CSV template for teachers import in Spanish.
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
            "email_institucional",
            "email_personal",
            "telefono",
            "celular",
            "fecha_contratacion",
        ];

        $sampleRow = [
            "87654321",
            "DOC2026010",
            "Ramirez",
            "Soto",
            "Maria Elena",
            "mramirez@instituto.edu.pe",
            "maria.ramirez@gmail.com",
            "013456789",
            "912345678",
            "2026-03-01",
        ];

        $filename = "plantilla_profesores.csv";

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
     * Import teachers from uploaded CSV file.
     * Non-conflicting rows are inserted directly; conflicting rows are saved in session for review.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            "file" => ["required", "file", "mimes:csv,txt", "max:10240"],
            "delimiter" => ["required", "string", Rule::in([",", ";", "auto", "comma", "semicolon"])],
        ]);

        $file = $request->file("file");
        $filePath = $file->getRealPath();
        $inputDelimiter = $request->input("delimiter");

        $handle = fopen($filePath, "r");
        if (!$handle) {
            return redirect()->route("teachers.index")
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
            return redirect()->route("teachers.index")
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
        $requiredFields = ["dni", "teacher_code", "paternal_last_name", "maternal_last_name", "first_name"];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($columnIndices[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            fclose($handle);
            return redirect()->route("teachers.index")
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
                $teacherCode = $getValue("teacher_code");
                $paternalLastName = $getValue("paternal_last_name");
                $maternalLastName = $getValue("maternal_last_name");
                $firstName = $getValue("first_name");
                $institutionalEmail = $getValue("institutional_email");
                $personalEmail = $getValue("personal_email");
                $phone = $getValue("phone");
                $mobile = $getValue("mobile");
                $hireDateRaw = $getValue("hire_date");

                // Validations for essential fields
                if (empty($dni) || empty($teacherCode) || empty($paternalLastName) || empty($maternalLastName) || empty($firstName)) {
                    $errors[] = "Fila {$rowNumber}: Faltan datos obligatorios (DNI, código, nombres o apellidos).";
                    continue;
                }

                if (empty($institutionalEmail)) {
                    $institutionalEmail = strtolower($teacherCode) . "@instituto.edu.pe";
                }

                $hireDate = $this->parseDate($hireDateRaw, Carbon::today()->format("Y-m-d"));

                $teacherData = [
                    "dni" => $dni,
                    "teacher_code" => $teacherCode,
                    "paternal_last_name" => $paternalLastName,
                    "maternal_last_name" => $maternalLastName,
                    "first_name" => $firstName,
                    "personal_email" => !empty($personalEmail) ? $personalEmail : null,
                    "institutional_email" => $institutionalEmail,
                    "phone" => !empty($phone) ? $phone : null,
                    "mobile" => !empty($mobile) ? $mobile : null,
                    "hire_date" => $hireDate,
                ];

                // Detect conflicts against DB
                $existingByDni = Teacher::where("dni", $dni)->first();
                $existingByCode = Teacher::where("teacher_code", $teacherCode)->first();
                $existingByEmail = Teacher::where("institutional_email", $institutionalEmail)->first();

                $reasons = [];
                $existingTeacher = $existingByDni ?? $existingByCode ?? $existingByEmail;

                if ($existingByDni) {
                    $reasons[] = "DNI ya registrado en base de datos";
                }
                if ($existingByCode) {
                    $reasons[] = "Código de profesor ya registrado en base de datos";
                }
                if ($existingByEmail) {
                    $reasons[] = "Correo institucional ya registrado en base de datos";
                }

                // Detect duplicates within current CSV file
                if (isset($seenDnisInBatch[$dni])) {
                    $reasons[] = "DNI repetido en este archivo (aparece en fila {$seenDnisInBatch[$dni]})";
                }
                if (isset($seenCodesInBatch[$teacherCode])) {
                    $reasons[] = "Código repetido en este archivo (aparece en fila {$seenCodesInBatch[$teacherCode]})";
                }

                if (!empty($reasons)) {
                    // Conflict detected: save for interactive review
                    $conflicts[] = [
                        "temp_id" => "row_" . $rowNumber . "_" . uniqid(),
                        "row_number" => $rowNumber,
                        "reasons" => $reasons,
                        "existing_teacher_id" => $existingTeacher ? $existingTeacher->id : null,
                        "existing_summary" => $existingTeacher ? "{$existingTeacher->full_name} (DNI: {$existingTeacher->dni}, Código: {$existingTeacher->teacher_code})" : null,
                        "data" => $teacherData,
                        "action" => $existingTeacher ? "update" : "create",
                    ];
                } else {
                    // No conflict: create immediately
                    Teacher::create($teacherData);
                    $createdCount++;
                    $seenDnisInBatch[$dni] = $rowNumber;
                    $seenCodesInBatch[$teacherCode] = $rowNumber;
                }
            }

            fclose($handle);
            DB::commit();
        } catch (\Throwable $e) {
            fclose($handle);
            DB::rollBack();
            return redirect()->route("teachers.index")
                ->with("error", "Ocurrió un error inesperado al procesar el archivo: " . $e->getMessage());
        }

        // If there are conflicts, redirect to interactive conflict resolution screen
        if (!empty($conflicts)) {
            session([
                "import_teacher_conflicts" => $conflicts,
                "import_teacher_saved_count" => $createdCount,
            ]);

            return redirect()->route("teachers.import-conflicts")
                ->with("info", "Se registraron {$createdCount} profesores sin conflicto. Se encontraron " . count($conflicts) . " registros con duplicados o similitudes para revisión.");
        }

        $message = "Importación completada exitosamente. {$createdCount} profesores registrados.";
        $response = redirect()->route("teachers.index")->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", array_slice($errors, 0, 50));
        }

        return $response;
    }

    /**
     * Show interactive review screen for teacher import conflicts.
     */
    public function showConflicts(): View|RedirectResponse
    {
        $conflicts = session("import_teacher_conflicts");
        if (empty($conflicts) || !is_array($conflicts)) {
            return redirect()->route("teachers.index")
                ->with("info", "No hay registros pendientes de resolución de conflictos.");
        }

        $savedCount = (int)session("import_teacher_saved_count", 0);

        return view("teachers.import_conflicts", compact("conflicts", "savedCount"));
    }

    /**
     * Process user resolutions for teacher import conflicts.
     */
    public function resolveConflicts(Request $request): RedirectResponse
    {
        $rows = $request->input("rows", []);
        if (empty($rows) || !is_array($rows)) {
            session()->forget(["import_teacher_conflicts", "import_teacher_saved_count"]);
            return redirect()->route("teachers.index")
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

                $existingId = !empty($rowData["existing_teacher_id"]) ? (int)$rowData["existing_teacher_id"] : null;
                $dni = trim($rowData["dni"] ?? "");
                $teacherCode = trim($rowData["teacher_code"] ?? "");
                $firstName = trim($rowData["first_name"] ?? "");
                $paternalLastName = trim($rowData["paternal_last_name"] ?? "");
                $maternalLastName = trim($rowData["maternal_last_name"] ?? "");
                $institutionalEmail = trim($rowData["institutional_email"] ?? "");
                $personalEmail = trim($rowData["personal_email"] ?? "");
                $phone = trim($rowData["phone"] ?? "");
                $mobile = trim($rowData["mobile"] ?? "");
                $hireDate = $this->parseDate($rowData["hire_date"] ?? null, Carbon::today()->format("Y-m-d"));

                if (empty($dni) || empty($teacherCode) || empty($firstName) || empty($paternalLastName) || empty($maternalLastName)) {
                    $errors[] = "Fila con DNI '{$dni}': Faltan campos obligatorios.";
                    continue;
                }

                if (empty($institutionalEmail)) {
                    $institutionalEmail = strtolower($teacherCode) . "@instituto.edu.pe";
                }

                $teacherData = [
                    "dni" => $dni,
                    "teacher_code" => $teacherCode,
                    "paternal_last_name" => $paternalLastName,
                    "maternal_last_name" => $maternalLastName,
                    "first_name" => $firstName,
                    "personal_email" => !empty($personalEmail) ? $personalEmail : null,
                    "institutional_email" => $institutionalEmail,
                    "phone" => !empty($phone) ? $phone : null,
                    "mobile" => !empty($mobile) ? $mobile : null,
                    "hire_date" => $hireDate,
                ];

                if ($action === "update") {
                    $targetTeacher = null;
                    if ($existingId) {
                        $targetTeacher = Teacher::find($existingId);
                    }
                    if (!$targetTeacher) {
                        $targetTeacher = Teacher::where("dni", $dni)
                            ->orWhere("teacher_code", $teacherCode)
                            ->orWhere("institutional_email", $institutionalEmail)
                            ->first();
                    }

                    if (!$targetTeacher) {
                        Teacher::create($teacherData);
                        $createdCount++;
                    } else {
                        // Check if new values conflict with OTHER teachers
                        $conflict = Teacher::where("id", "!=", $targetTeacher->id)
                            ->where(function ($q) use ($dni, $teacherCode, $institutionalEmail) {
                                $q->where("dni", $dni)
                                    ->orWhere("teacher_code", $teacherCode)
                                    ->orWhere("institutional_email", $institutionalEmail);
                            })
                            ->exists();

                        if ($conflict) {
                            $errors[] = "No se pudo actualizar {$dni}: El DNI, código o email ya pertenece a otro profesor.";
                            continue;
                        }

                        $targetTeacher->update($teacherData);
                        $updatedCount++;
                    }
                } elseif ($action === "create") {
                    $conflict = Teacher::where("dni", $dni)
                        ->orWhere("teacher_code", $teacherCode)
                        ->orWhere("institutional_email", $institutionalEmail)
                        ->exists();

                    if ($conflict) {
                        $errors[] = "No se pudo registrar {$dni} como nuevo: Ya existe un profesor con ese DNI, código o email.";
                        continue;
                    }

                    Teacher::create($teacherData);
                    $createdCount++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route("teachers.import-conflicts")
                ->with("error", "Ocurrió un error al procesar las resoluciones: " . $e->getMessage());
        }

        session()->forget(["import_teacher_conflicts", "import_teacher_saved_count"]);

        $message = "Resolución de importación finalizada: {$createdCount} creados, {$updatedCount} actualizados, {$ignoredCount} omitidos.";
        $response = redirect()->route("teachers.index")->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", $errors);
        }

        return $response;
    }

    /**
     * Cancel and discard pending conflict records for teachers.
     */
    public function cancelConflicts(): RedirectResponse
    {
        session()->forget(["import_teacher_conflicts", "import_teacher_saved_count"]);
        return redirect()->route("teachers.index")
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
            "codigo" => "teacher_code",
            "codigodocente" => "teacher_code",
            "codigoprofesor" => "teacher_code",
            "teachercode" => "teacher_code",
            "codigoestudiante" => "teacher_code",
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
            "hiredate" => "hire_date",
            "fechacontratacion" => "hire_date",
            "contratacion" => "hire_date",
            "fechaingreso" => "hire_date",
            "ingreso" => "hire_date",
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
