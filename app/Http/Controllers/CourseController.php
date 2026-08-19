<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");

        $courses = Course::query()
            ->when($search, function ($query, $search) {
                $query->where("code", "like", "%{$search}%")
                    ->orWhere("name", "like", "%{$search}%")
                    ->orWhere("period", "like", "%{$search}%");
            })
            ->orderBy("period")
            ->orderBy("name")
            ->paginate(10)
            ->withQueryString();

        $curriculums = Curriculum::all();

        return view("courses.index", compact("courses", "search", "curriculums"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $curriculums = Curriculum::all();
        return view("courses.create", compact("curriculums"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "code" => "required|string|unique:courses,code|max:50",
            "name" => "required|string|max:255",
            "period" => "nullable|string|max:50",
            "credits" => "required|integer|min:0",
            "hours" => "required|integer|min:0",
            "curriculums" => "nullable|array",
            "curriculums.*" => "exists:curriculums,id",
        ]);

        $course = Course::create($validated);

        if ($request->has("curriculums")) {
            $course->curriculums()->sync($request->input("curriculums"));
        }

        return redirect()->route("courses.index")
            ->with("success", "Curso creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): View
    {
        $course->load("curriculums");
        return view("courses.show", compact("course"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        $curriculums = Curriculum::all();
        $course->load("curriculums");
        return view("courses.edit", compact("course", "curriculums"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            "code" => "required|string|max:50|unique:courses,code," . $course->id,
            "name" => "required|string|max:255",
            "period" => "nullable|string|max:50",
            "credits" => "required|integer|min:0",
            "hours" => "required|integer|min:0",
            "curriculums" => "nullable|array",
            "curriculums.*" => "exists:curriculums,id",
        ]);

        $course->update($validated);

        $course->curriculums()->sync($request->input("curriculums", []));

        return redirect()->route("courses.index")
            ->with("success", "Curso actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route("courses.index")
            ->with("success", "Curso eliminado exitosamente.");
    }

    /**
     * Download CSV template for standalone courses import in Spanish.
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
            "codigo",
            "nombre",
            "periodo",
            "creditos",
            "horas",
        ];

        $sampleRows = [
            ["DPW-I-01", "Diseño gráfico para la web", "I", 3, 80],
            ["DPW-I-02", "Maquetación web", "I", 3, 80],
            ["DPW-II-01", "Diseño web", "II", 3, 80],
        ];

        $filename = "plantilla_cursos.csv";

        return response()->streamDownload(function () use ($headers, $sampleRows, $delimiter) {
            $output = fopen("php://output", "w");
            // UTF-8 BOM for Excel compatibility
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, $headers, $delimiter);
            foreach ($sampleRows as $row) {
                fputcsv($output, $row, $delimiter);
            }
            fclose($output);
        }, $filename, [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Import standalone courses from uploaded CSV file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            "file" => ["required", "file", "mimes:csv,txt", "max:10240"],
            "delimiter" => ["required", "string", Rule::in([",", ";", "auto", "comma", "semicolon"])],
            "curriculum_id" => ["nullable", "exists:curriculums,id"],
        ]);

        $file = $request->file("file");
        $filePath = $file->getRealPath();
        $inputDelimiter = $request->input("delimiter");
        $curriculumId = $request->input("curriculum_id");

        $handle = fopen($filePath, "r");
        if (!$handle) {
            return redirect()->route("courses.index")
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
            return redirect()->route("courses.index")
                ->with("error", "El archivo CSV está vacío o el separador seleccionado no coincide.");
        }

        // Remove UTF-8 BOM
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

        $requiredFields = ["code", "name", "period", "credits", "hours"];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($columnIndices[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            fclose($handle);
            return redirect()->route("courses.index")
                ->with("error", "No se encontraron todas las columnas requeridas (Código, Nombre, Periodo, Créditos, Horas). Verifique el separador seleccionado.");
        }

        $createdCount = 0;
        $errors = [];
        $conflicts = [];
        $rowNumber = 1;
        $seenCodesInBatch = [];

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rowNumber++;

                if (empty(array_filter($row, function ($v) { return trim($v) !== ""; }))) {
                    continue;
                }

                $getValue = function (string $field) use ($columnIndices, $row) {
                    if (isset($columnIndices[$field]) && isset($row[$columnIndices[$field]])) {
                        return trim($row[$columnIndices[$field]]);
                    }
                    return "";
                };

                $code = $getValue("code");
                $name = $getValue("name");
                $period = $getValue("period");
                $credits = (int)$getValue("credits");
                $hours = (int)$getValue("hours");

                if (empty($code) || empty($name) || empty($period)) {
                    $errors[] = "Fila {$rowNumber}: Faltan datos obligatorios (Código, Nombre o Periodo).";
                    continue;
                }

                $courseData = [
                    "code" => $code,
                    "name" => $name,
                    "period" => $period,
                    "credits" => $credits,
                    "hours" => $hours,
                ];

                $existingCourse = Course::where("code", $code)->first();
                $reasons = [];

                if ($existingCourse) {
                    $reasons[] = "El código '{$code}' ya existe en el sistema ('{$existingCourse->name}')";
                }

                if (isset($seenCodesInBatch[$code])) {
                    $reasons[] = "Código repetido en este archivo (fila {$seenCodesInBatch[$code]})";
                }

                if (!empty($reasons)) {
                    $conflicts[] = [
                        "temp_id" => "course_" . $rowNumber . "_" . uniqid(),
                        "row_number" => $rowNumber,
                        "reasons" => $reasons,
                        "existing_course_id" => $existingCourse ? $existingCourse->id : null,
                        "existing_summary" => $existingCourse ? "{$existingCourse->name} (Código: {$existingCourse->code}, Periodo: {$existingCourse->period}, Créditos: {$existingCourse->credits})" : null,
                        "data" => $courseData,
                        "action" => $existingCourse ? "update" : "create",
                    ];
                } else {
                    $course = Course::create($courseData);
                    if ($curriculumId) {
                        $course->curriculums()->syncWithoutDetaching([$curriculumId]);
                    }
                    $createdCount++;
                    $seenCodesInBatch[$code] = $rowNumber;
                }
            }

            fclose($handle);
            DB::commit();
        } catch (\Throwable $e) {
            fclose($handle);
            DB::rollBack();
            return redirect()->route("courses.index")
                ->with("error", "Ocurrió un error inesperado al procesar el archivo: " . $e->getMessage());
        }

        if (!empty($conflicts)) {
            session([
                "import_course_conflicts" => $conflicts,
                "import_course_saved_count" => $createdCount,
                "import_course_curriculum_id" => $curriculumId,
            ]);

            return redirect()->route("courses.import-conflicts")
                ->with("info", "Se registraron {$createdCount} cursos sin conflicto. Se encontraron " . count($conflicts) . " cursos con códigos duplicados para revisión.");
        }

        $message = "Importación completada exitosamente. {$createdCount} cursos registrados.";
        $response = redirect()->route("courses.index")->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", array_slice($errors, 0, 50));
        }

        return $response;
    }

    /**
     * Show interactive review screen for standalone course import conflicts.
     */
    public function showConflicts(): View|RedirectResponse
    {
        $conflicts = session("import_course_conflicts");
        if (empty($conflicts) || !is_array($conflicts)) {
            return redirect()->route("courses.index")
                ->with("info", "No hay cursos pendientes de resolución de conflictos.");
        }

        $savedCount = (int)session("import_course_saved_count", 0);
        $curriculumId = session("import_course_curriculum_id");
        $curriculums = Curriculum::all();

        return view("courses.import_conflicts", compact("conflicts", "savedCount", "curriculumId", "curriculums"));
    }

    /**
     * Process user resolutions for course conflicts.
     */
    public function resolveConflicts(Request $request): RedirectResponse
    {
        $rows = $request->input("rows", []);
        $defaultCurriculumId = session("import_course_curriculum_id");

        if (empty($rows) || !is_array($rows)) {
            session()->forget(["import_course_conflicts", "import_course_saved_count", "import_course_curriculum_id"]);
            return redirect()->route("courses.index")
                ->with("info", "No se recibieron cursos para procesar.");
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

                $existingId = !empty($rowData["existing_course_id"]) ? (int)$rowData["existing_course_id"] : null;
                $code = trim($rowData["code"] ?? "");
                $name = trim($rowData["name"] ?? "");
                $period = trim($rowData["period"] ?? "");
                $credits = (int)($rowData["credits"] ?? 0);
                $hours = (int)($rowData["hours"] ?? 0);
                $rowCurriculumId = !empty($rowData["curriculum_id"]) ? (int)$rowData["curriculum_id"] : $defaultCurriculumId;

                if (empty($code) || empty($name) || empty($period)) {
                    $errors[] = "Fila con código '{$code}': Faltan campos obligatorios.";
                    continue;
                }

                $courseData = [
                    "code" => $code,
                    "name" => $name,
                    "period" => $period,
                    "credits" => $credits,
                    "hours" => $hours,
                ];

                if ($action === "update") {
                    $targetCourse = null;
                    if ($existingId) {
                        $targetCourse = Course::find($existingId);
                    }
                    if (!$targetCourse) {
                        $targetCourse = Course::where("code", $code)->first();
                    }

                    if (!$targetCourse) {
                        $targetCourse = Course::create($courseData);
                        $createdCount++;
                    } else {
                        // Check if new code conflicts with another course
                        $conflict = Course::where("id", "!=", $targetCourse->id)
                            ->where("code", $code)
                            ->exists();

                        if ($conflict) {
                            $errors[] = "No se pudo actualizar el curso {$code}: El código ya pertenece a otro curso.";
                            continue;
                        }

                        $targetCourse->update($courseData);
                        $updatedCount++;
                    }

                    if ($rowCurriculumId) {
                        $targetCourse->curriculums()->syncWithoutDetaching([$rowCurriculumId]);
                    }
                } elseif ($action === "create") {
                    $conflict = Course::where("code", $code)->exists();
                    if ($conflict) {
                        $errors[] = "No se pudo crear el curso con código '{$code}': Ya existe un curso con ese código.";
                        continue;
                    }

                    $newCourse = Course::create($courseData);
                    if ($rowCurriculumId) {
                        $newCourse->curriculums()->syncWithoutDetaching([$rowCurriculumId]);
                    }
                    $createdCount++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route("courses.import-conflicts")
                ->with("error", "Ocurrió un error al procesar las resoluciones: " . $e->getMessage());
        }

        session()->forget(["import_course_conflicts", "import_course_saved_count", "import_course_curriculum_id"]);

        $message = "Resolución de cursos finalizada: {$createdCount} creados, {$updatedCount} actualizados, {$ignoredCount} omitidos.";
        $response = redirect()->route("courses.index")->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", $errors);
        }

        return $response;
    }

    /**
     * Cancel and discard pending conflict records for standalone courses.
     */
    public function cancelConflicts(): RedirectResponse
    {
        session()->forget(["import_course_conflicts", "import_course_saved_count", "import_course_curriculum_id"]);
        return redirect()->route("courses.index")
            ->with("info", "Se han cancelado y descartado los cursos pendientes en conflicto.");
    }

    /**
     * Map of normalized CSV header keys to database fields.
     */
    private function getHeaderMapping(): array
    {
        return [
            "codigo" => "code",
            "codigocurso" => "code",
            "code" => "code",
            "nombre" => "name",
            "nombrecurso" => "name",
            "unidadacademica" => "name",
            "curso" => "name",
            "asignatura" => "name",
            "periodo" => "period",
            "periodoacademico" => "period",
            "ciclo" => "period",
            "semestre" => "period",
            "creditos" => "credits",
            "credito" => "credits",
            "horas" => "hours",
            "hora" => "hours",
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
}
