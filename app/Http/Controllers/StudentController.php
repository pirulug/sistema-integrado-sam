<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input("status");
        $search = $request->input("search");
        $careerId = $request->input("career_id");
        $shift = $request->input("shift");
        $year = $request->input("year");

        $query = Student::query()->with(["careers.courses", "courses", "efsrtRecords", "job"]);

        if ($status && $status !== "todos") {
            if ($status === "titulado") {
                $query->whereHas("careers", function ($q) {
                    $q->whereNotNull("career_student.graduation_year");
                });
            } else {
                $query->where("status", $status);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%" . $search . "%")
                  ->orWhere("document_number", "like", "%" . $search . "%")
                  ->orWhere("phone", "like", "%" . $search . "%")
                  ->orWhere("whatsapp", "like", "%" . $search . "%")
                  ->orWhere("student_code", "like", "%" . $search . "%")
                  ->orWhere("personal_email", "like", "%" . $search . "%")
                  ->orWhere("institutional_email", "like", "%" . $search . "%");
            });
        }

        if ($careerId && $careerId !== "todos") {
            $query->whereHas("careers", function ($q) use ($careerId) {
                $q->where("careers.id", $careerId);
            });
        }

        if ($shift && $shift !== "todos") {
            $query->whereHas("careers", function ($q) use ($shift) {
                $q->where("career_student.shift", $shift);
            });
        }

        if ($year) {
            $query->where(function ($q) use ($year) {
                $q->whereHas("careers", function ($sub) use ($year) {
                    $sub->where("career_student.entry_year", $year)
                        ->orWhere("career_student.graduation_year", $year);
                })
                ->orWhere("entry_year", $year)
                ->orWhere("graduation_year", $year);
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $careers = \App\Models\Career::orderBy("name")->get();

        return view("students.index", compact("students", "status", "careers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = \App\Models\Career::where("status", "activo")->orderBy("name")->get();
        return view("students.create", compact("careers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "careers" => "nullable|array",
            "careers.*" => "exists:careers,id",
            "career_shifts" => "nullable|array",
            "career_shifts.*" => "in:Mañana,Tarde,Noche",
            "career_entry_years" => "nullable|array",
            "career_entry_years.*" => "nullable|integer|min:1900|max:2100",
            "name" => "required|string|max:255",
            "student_code" => "nullable|string|max:50|unique:students,student_code",
            "document_number" => "required|string|max:50|unique:students,document_number",
            "personal_email" => "nullable|email|max:255",
            "institutional_email" => "nullable|email|max:255",
            "phone" => "nullable|string|max:50",
            "whatsapp" => "nullable|string|max:50",
            "status" => "required|in:matriculado,egresado,retirado",
            "enrollment_date" => "required|date",
            "graduation_date" => "nullable|date|required_if:status,egresado",
        ]);

        $careers = $request->input("careers", []);
        $careerShifts = $request->input("career_shifts", []);
        $careerEntryYears = $request->input("career_entry_years", []);

        $firstCareerId = !empty($careers) ? $careers[0] : null;
        $studentEntryYear = $request->input("entry_year") ?? ($firstCareerId && isset($careerEntryYears[$firstCareerId]) ? $careerEntryYears[$firstCareerId] : date("Y"));

        $validated["entry_year"] = $studentEntryYear;
        $validated["graduation_year"] = null;

        $student = Student::create($validated);
        
        $syncData = [];
        foreach ($careers as $careerId) {
            $syncData[$careerId] = [
                "shift" => $careerShifts[$careerId] ?? "Mañana",
                "entry_year" => $careerEntryYears[$careerId] ?? date("Y"),
                "graduation_year" => null,
            ];
        }
        $student->careers()->sync($syncData);

        // Manage EFSRT records
        $student->efsrtRecords()->whereNotIn("career_id", $careers)->delete();
        foreach ($careers as $careerId) {
            foreach (["MODULO I", "MODULO II", "MODULO III"] as $module) {
                $student->efsrtRecords()->firstOrCreate([
                    "career_id" => $careerId,
                    "module_name" => $module,
                ], [
                    "status" => "pendiente"
                ]);
            }
        }

        return redirect()->route("students.index")->with("success", "Estudiante creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(["careers", "courses", "job"]);

        $careerIds = $student->careers->pluck("id");
        $registeredCourseIds = $student->courses->pluck("id");

        $availableCourses = \App\Models\Course::whereIn("career_id", $careerIds)
            ->whereNotIn("id", $registeredCourseIds)
            ->orderBy("name")
            ->get();

        return view("students.show", compact("student", "availableCourses"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $careers = \App\Models\Career::where("status", "activo")->orderBy("name")->get();
        return view("students.edit", compact("student", "careers"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            "careers" => "nullable|array",
            "careers.*" => "exists:careers,id",
            "career_shifts" => "nullable|array",
            "career_shifts.*" => "in:Mañana,Tarde,Noche",
            "career_entry_years" => "nullable|array",
            "career_entry_years.*" => "nullable|integer|min:1900|max:2100",
            "career_graduation_years" => "nullable|array",
            "career_graduation_years.*" => "nullable|integer|min:1900|max:2100",
            "name" => "required|string|max:255",
            "student_code" => "nullable|string|max:50|unique:students,student_code," . $student->id,
            "document_number" => "required|string|max:50|unique:students,document_number," . $student->id,
            "personal_email" => "nullable|email|max:255",
            "institutional_email" => "nullable|email|max:255",
            "phone" => "nullable|string|max:50",
            "whatsapp" => "nullable|string|max:50",
            "status" => "required|in:matriculado,egresado,retirado",
            "enrollment_date" => "required|date",
            "graduation_date" => "nullable|date|required_if:status,egresado",
        ]);

        $careers = $request->input("careers", []);
        $careerShifts = $request->input("career_shifts", []);
        $careerEntryYears = $request->input("career_entry_years", []);

        $student->loadMissing('careers');
        $existingCareers = $student->careers->keyBy('id');

        $firstCareerId = !empty($careers) ? $careers[0] : null;
        $studentEntryYear = $request->input("entry_year") ?? ($firstCareerId && isset($careerEntryYears[$firstCareerId]) ? $careerEntryYears[$firstCareerId] : date("Y"));

        $syncData = [];
        foreach ($careers as $careerId) {
            $existingPivot = $existingCareers->get($careerId);
            $syncData[$careerId] = [
                "shift" => $careerShifts[$careerId] ?? "Mañana",
                "entry_year" => $careerEntryYears[$careerId] ?? date("Y"),
                "graduation_year" => $existingPivot ? $existingPivot->pivot->graduation_year : null,
            ];
        }
        $student->careers()->sync($syncData);

        $studentGraduationYear = null;
        foreach ($syncData as $cData) {
            if (!empty($cData["graduation_year"])) {
                $studentGraduationYear = $cData["graduation_year"];
                break;
            }
        }

        $validated["entry_year"] = $studentEntryYear;
        $validated["graduation_year"] = $studentGraduationYear;
        $student->update($validated);

        // Update or delete student job info if titled (has graduation_year on any career)
        $isTitled = false;
        foreach ($syncData as $cData) {
            if (!empty($cData["graduation_year"])) {
                $isTitled = true;
                break;
            }
        }

        if (!$isTitled) {
            $student->job()->delete();
        }

        // Manage EFSRT records
        $student->efsrtRecords()->whereNotIn("career_id", $careers)->delete();
        foreach ($careers as $careerId) {
            foreach (["MODULO I", "MODULO II", "MODULO III"] as $module) {
                $student->efsrtRecords()->firstOrCreate([
                    "career_id" => $careerId,
                    "module_name" => $module,
                ], [
                    "status" => "pendiente"
                ]);
            }
        }

        return redirect()->route("students.index")->with("success", "Estudiante actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route("students.index")->with("success", "Estudiante eliminado exitosamente.");
    }
}
