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

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");

        $curriculums = Curriculum::query()
            ->when($search, function ($query, $search) {
                $query->where("name", "like", "%{$search}%")
                    ->orWhere("year", "like", "%{$search}%");
            })
            ->orderBy("year", "desc")
            ->paginate(10)
            ->withQueryString();

        return view("curriculums.index", compact("curriculums", "search"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("curriculums.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "year" => "required|string|max:4",
        ]);

        Curriculum::create($validated);

        return redirect()->route("curriculums.index")
            ->with("success", "Malla curricular creada exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum): View
    {
        $curriculum->load(["courses", "efsrts"]);
        return view("curriculums.show", compact("curriculum"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum): View
    {
        return view("curriculums.edit", compact("curriculum"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curriculum $curriculum): RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "year" => "required|string|max:4",
        ]);

        $curriculum->update($validated);

        return redirect()->route("curriculums.index")
            ->with("success", "Malla curricular actualizada exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum): RedirectResponse
    {
        $curriculum->delete();

        return redirect()->route("curriculums.index")
            ->with("success", "Malla curricular eliminada exitosamente.");
    }

    /**
     * Download CSV template for combined Curriculum and Courses import in Spanish.
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
            "programa_estudios",
            "periodo",
            "unidad_academica",
            "creditos",
            "horas",
            "codigo_curso",
        ];

        $sampleRows = [
            ["DISEÑO Y PROGRAMACIÓN WEB", "I", "Diseño gráfico para la web", 3, 80, "DPW-I-01"],
            ["DISEÑO Y PROGRAMACIÓN WEB", "I", "Maquetación web", 3, 80, "DPW-I-02"],
            ["DISEÑO Y PROGRAMACIÓN WEB", "II", "Diseño web", 3, 80, "DPW-II-01"],
        ];

        $filename = "plantilla_malla_cursos.csv";

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
     * Import Curriculum and its Courses together from CSV.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            "file" => ["required", "file", "mimes:csv,txt", "max:10240"],
            "delimiter" => ["required", "string", Rule::in([",", ";", "auto", "comma", "semicolon"])],
            "target_mode" => ["required", "string", "in:new,existing"],
            "new_curriculum_name" => ["nullable", "required_if:target_mode,new", "string", "max:255"],
            "new_curriculum_year" => ["nullable", "required_if:target_mode,new", "string", "max:4"],
            "existing_curriculum_id" => ["nullable", "required_if:target_mode,existing", "exists:curriculums,id"],
        ]);

        $file = $request->file("file");
        $filePath = $file->getRealPath();
        $inputDelimiter = $request->input("delimiter");
        $targetMode = $request->input("target_mode");

        // Determine or create curriculum
        if ($targetMode === "new") {
            $curriculum = Curriculum::firstOrCreate([
                "name" => trim($request->input("new_curriculum_name")),
                "year" => trim($request->input("new_curriculum_year")),
            ]);
        } else {
            $curriculum = Curriculum::findOrFail($request->input("existing_curriculum_id"));
        }

        $handle = fopen($filePath, "r");
        if (!$handle) {
            return redirect()->route("curriculums.index")
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
            return redirect()->route("curriculums.index")
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

        // Ensure minimum required columns
        $requiredFields = ["name", "period", "credits", "hours"];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($columnIndices[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            fclose($handle);
            return redirect()->route("curriculums.index")
                ->with("error", "No se encontraron las columnas requeridas (Unidad Académica/Nombre, Periodo, Créditos, Horas). Verifique el separador seleccionado.");
        }

        $createdCount = 0;
        $attachedCount = 0;
        $errors = [];
        $conflicts = [];
        $rowNumber = 1;
        $counters = [];
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

                $name = $getValue("name");
                $period = $getValue("period");
                $credits = (int)$getValue("credits");
                $hours = (int)$getValue("hours");
                $code = $getValue("code");

                if (empty($name) || empty($period)) {
                    $errors[] = "Fila {$rowNumber}: Faltan datos obligatorios (Nombre o Periodo del curso).";
                    continue;
                }

                // Auto-generate code if empty
                if (empty($code)) {
                    if (!isset($counters[$period])) {
                        $counters[$period] = 1;
                    } else {
                        $counters[$period]++;
                    }
                    $code = "DPW-" . $period . "-" . str_pad((string)$counters[$period], 2, "0", STR_PAD_LEFT);
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
                    // Check if it's already the exact same course
                    if ($existingCourse->name === $name && $existingCourse->period === $period) {
                        // Attach to curriculum if not already attached
                        $curriculum->courses()->syncWithoutDetaching([$existingCourse->id]);
                        $attachedCount++;
                        continue;
                    } else {
                        $reasons[] = "El código '{$code}' ya existe en el sistema con otro nombre o periodo ('{$existingCourse->name}')";
                    }
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
                    $curriculum->courses()->syncWithoutDetaching([$course->id]);
                    $createdCount++;
                    $seenCodesInBatch[$code] = $rowNumber;
                }
            }

            fclose($handle);
            DB::commit();
        } catch (\Throwable $e) {
            fclose($handle);
            DB::rollBack();
            return redirect()->route("curriculums.index")
                ->with("error", "Ocurrió un error inesperado al procesar el archivo: " . $e->getMessage());
        }

        if (!empty($conflicts)) {
            session([
                "import_curriculum_conflicts" => $conflicts,
                "import_curriculum_saved_count" => $createdCount + $attachedCount,
                "import_curriculum_id" => $curriculum->id,
            ]);

            return redirect()->route("curriculums.import-conflicts")
                ->with("info", "Se vincularon " . ($createdCount + $attachedCount) . " cursos a la malla. Se encontraron " . count($conflicts) . " cursos con códigos duplicados para revisión.");
        }

        $message = "Malla '{$curriculum->name}' importada exitosamente con {$createdCount} nuevos cursos registrados.";
        if ($attachedCount > 0) {
            $message .= " ({$attachedCount} cursos existentes vinculados).";
        }

        $response = redirect()->route("curriculums.show", $curriculum)->with("success", $message);
        if (!empty($errors)) {
            $response->with("import_errors", array_slice($errors, 0, 50));
        }

        return $response;
    }

    /**
     * Show interactive review screen for curriculum course conflicts.
     */
    public function showConflicts(): View|RedirectResponse
    {
        $conflicts = session("import_curriculum_conflicts");
        $curriculumId = session("import_curriculum_id");

        if (empty($conflicts) || !is_array($conflicts) || !$curriculumId) {
            return redirect()->route("curriculums.index")
                ->with("info", "No hay cursos pendientes de resolución de conflictos.");
        }

        $curriculum = Curriculum::findOrFail($curriculumId);
        $savedCount = (int)session("import_curriculum_saved_count", 0);

        return view("curriculums.import_conflicts", compact("conflicts", "savedCount", "curriculum"));
    }

    /**
     * Process user resolutions for curriculum course conflicts.
     */
    public function resolveConflicts(Request $request): RedirectResponse
    {
        $rows = $request->input("rows", []);
        $curriculumId = session("import_curriculum_id");

        if (empty($rows) || !is_array($rows) || !$curriculumId) {
            session()->forget(["import_curriculum_conflicts", "import_curriculum_saved_count", "import_curriculum_id"]);
            return redirect()->route("curriculums.index")
                ->with("info", "No se recibieron cursos para procesar.");
        }

        $curriculum = Curriculum::findOrFail($curriculumId);
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

                    $curriculum->courses()->syncWithoutDetaching([$targetCourse->id]);
                } elseif ($action === "create") {
                    $conflict = Course::where("code", $code)->exists();
                    if ($conflict) {
                        $errors[] = "No se pudo crear el curso con código '{$code}': Ya existe un curso con ese código.";
                        continue;
                    }

                    $newCourse = Course::create($courseData);
                    $curriculum->courses()->syncWithoutDetaching([$newCourse->id]);
                    $createdCount++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route("curriculums.import-conflicts")
                ->with("error", "Ocurrió un error al procesar las resoluciones: " . $e->getMessage());
        }

        session()->forget(["import_curriculum_conflicts", "import_curriculum_saved_count", "import_curriculum_id"]);

        $message = "Resolución de cursos finalizada: {$createdCount} creados, {$updatedCount} actualizados, {$ignoredCount} omitidos.";
        $response = redirect()->route("curriculums.show", $curriculum)->with("success", $message);

        if (!empty($errors)) {
            $response->with("import_errors", $errors);
        }

        return $response;
    }

    /**
     * Cancel and discard pending conflict records for curriculum courses.
     */
    public function cancelConflicts(): RedirectResponse
    {
        $curriculumId = session("import_curriculum_id");
        session()->forget(["import_curriculum_conflicts", "import_curriculum_saved_count", "import_curriculum_id"]);

        if ($curriculumId) {
            return redirect()->route("curriculums.show", $curriculumId)
                ->with("info", "Se han cancelado y descartado los cursos pendientes en conflicto.");
        }

        return redirect()->route("curriculums.index")
            ->with("info", "Se han cancelado y descartado los cursos pendientes en conflicto.");
    }

    /**
     * Map of normalized CSV header keys to database fields.
     */
    private function getHeaderMapping(): array
    {
        return [
            "unidadacademica" => "name",
            "nombre" => "name",
            "nombrecurso" => "name",
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
            "codigocurso" => "code",
            "codigo" => "code",
            "code" => "code",
            "programaestudios" => "program",
            "programaestudio" => "program",
            "programa" => "program",
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
