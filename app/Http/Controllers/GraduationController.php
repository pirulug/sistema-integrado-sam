<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Efsrt;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GraduationController extends Controller
{
    /**
     * Display the graduation tracking panel with infinite scroll pagination (3 items per batch).
     */
    public function index(Request $request)
    {
        $search = $request->input("search");
        $curriculumId = $request->input("curriculum_id");
        $shift = $request->input("shift");
        $status = $request->input("status");

        // Fast metrics calculation
        $totalCount = Student::count();
        $tituladosCount = Student::whereNotNull("degree_date")->count();
        $sinMallaCount = Student::whereNull("curriculum_id")->count();

        // Query active students for Aptos and En Proceso metrics
        $activeStudents = Student::with(["curriculum.courses:id,curriculum_id", "curriculum.efsrts:id,curriculum_id", "courses:id", "efsrts:id"])
            ->whereNull("degree_date")
            ->whereNotNull("curriculum_id")
            ->get(["id", "curriculum_id", "degree_date"]);

        $aptosStudentIds = $activeStudents->filter(fn($s) => $s->overall_status === "Apto")->pluck("id")->toArray();
        $enProcesoStudentIds = $activeStudents->filter(fn($s) => $s->overall_status === "En Proceso")->pluck("id")->toArray();

        $aptosCount = count($aptosStudentIds);
        $enProcesoCount = count($enProcesoStudentIds);

        // Build the paginated students query
        $studentsQuery = Student::with([
            "curriculum.courses",
            "curriculum.efsrts",
            "courses",
            "efsrts"
        ]);

        if ($search) {
            $studentsQuery->where(function($q) use ($search) {
                $q->where("dni", "like", "%{$search}%")
                  ->orWhere("student_code", "like", "%{$search}%")
                  ->orWhere("paternal_last_name", "like", "%{$search}%")
                  ->orWhere("maternal_last_name", "like", "%{$search}%")
                  ->orWhere("first_name", "like", "%{$search}%");
            });
        }

        if ($curriculumId) {
            $studentsQuery->where("curriculum_id", $curriculumId);
        }

        if ($shift) {
            $studentsQuery->where("shift", $shift);
        }

        if ($status === "Titulado") {
            $studentsQuery->whereNotNull("degree_date");
        } elseif ($status === "Sin Malla") {
            $studentsQuery->whereNull("curriculum_id");
        } elseif ($status === "Apto") {
            $studentsQuery->whereIn("id", $aptosStudentIds);
        } elseif ($status === "En Proceso") {
            $studentsQuery->whereIn("id", $enProcesoStudentIds);
        }

        // Paginate 3 by 3 to prevent memory exhaustion
        $students = $studentsQuery->paginate(3)->withQueryString();

        // AJAX / Infinite Scroll request response
        if ($request->ajax() || $request->header("X-Requested-With") === "XMLHttpRequest" || $request->wantsJson()) {
            return response()->json([
                "html" => view("graduation.partials.student_cards", compact("students"))->render(),
                "next_page_url" => $students->nextPageUrl(),
                "has_more" => $students->hasMorePages(),
                "current_page" => $students->currentPage(),
                "total" => $students->total(),
            ]);
        }

        $curriculums = Curriculum::all();

        return view("graduation.index", compact(
            "students", 
            "curriculums", 
            "search", 
            "curriculumId", 
            "shift", 
            "status",
            "totalCount",
            "tituladosCount",
            "aptosCount",
            "enProcesoCount",
            "sinMallaCount"
        ));
    }

    /**
     * Toggle the completion/approval status of a course for a student (via AJAX).
     */
    public function toggleCourse(Student $student, Course $course): JsonResponse
    {
        $student->courses()->toggle($course->id);
        
        $isApproved = $student->courses()->where('course_id', $course->id)->exists();
        $pendingCount = $student->pendingCourses()->count();
        $overallStatus = $student->overall_status;

        return response()->json([
            'success' => true,
            'approved' => $isApproved,
            'pending_count' => $pendingCount,
            'overall_status' => $overallStatus,
        ]);
    }

    /**
     * Update the EFSRT module status and details for a student.
     */
    public function updateEfsrt(Request $request, Student $student, Efsrt $efsrt)
    {
        $validated = $request->validate([
            "company_name" => "nullable|string|max:255",
            "practice_line" => "nullable|string|max:255",
            "activities" => "nullable|string",
            "hours" => "nullable|integer|min:0",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date|after_or_equal:start_date",
            "status" => "required|in:pending,approved,rejected",
        ]);

        if ($student->efsrts()->where("efsrt_id", $efsrt->id)->exists()) {
            $student->efsrts()->updateExistingPivot($efsrt->id, $validated);
        } else {
            $student->efsrts()->attach($efsrt->id, $validated);
        }

        return redirect()->back()->with("success", "Práctica EFSRT del estudiante actualizada correctamente.");
    }

    /**
     * Register or update degree date and modality to set or edit student status.
     */
    public function titular(Request $request, Student $student)
    {
        $validated = $request->validate([
            "degree_date" => "nullable|date",
            "degree_modality" => "nullable|string|max:255",
            "action" => "nullable|string|in:save,remove",
        ]);

        if ($request->input("action") === "remove") {
            $student->update([
                "degree_date" => null,
                "degree_modality" => null,
            ]);
            return redirect()->back()->with("success", "Estado de titulación revertido correctamente.");
        }

        if (empty($validated["degree_date"])) {
            return redirect()->back()->with("error", "La fecha de titulación es obligatoria para confirmar la titulación.");
        }

        $student->update([
            "degree_date" => $validated["degree_date"],
            "degree_modality" => $validated["degree_modality"] ?? null,
        ]);

        return redirect()->back()->with("success", "Información de titulación actualizada exitosamente.");
    }

    /**
     * Perform bulk course approval/disapproval for a student or period (via AJAX).
     */
    public function bulkCourses(Request $request, Student $student): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:approve_all,clear_all,approve_period,clear_period',
            'period' => 'nullable|string|max:10',
        ]);

        $action = $validated['action'];
        $period = $validated['period'] ?? null;

        if (!$student->curriculum) {
            return response()->json(['success' => false, 'error' => 'Estudiante sin malla asignada.']);
        }

        $coursesQuery = $student->curriculum->courses();
        if ($period) {
            $coursesQuery->where('period', $period);
        }
        $courseIds = $coursesQuery->pluck('courses.id')->toArray();

        if ($action === 'approve_all' || $action === 'approve_period') {
            $student->courses()->syncWithoutDetaching($courseIds);
        } elseif ($action === 'clear_all' || $action === 'clear_period') {
            $student->courses()->detach($courseIds);
        }

        $pendingCount = $student->pendingCourses()->count();
        $overallStatus = $student->overall_status;
        $approvedIds = $student->courses()->pluck('courses.id')->map(fn($id) => (int)$id)->toArray();

        return response()->json([
            'success' => true,
            'approved_ids' => $approvedIds,
            'pending_count' => $pendingCount,
            'overall_status' => $overallStatus,
        ]);
    }

    /**
     * Public lookup of student graduation tracking by DNI.
     */
    public function publicLookup(Request $request)
    {
        $dni = $request->query('dni');
        
        if (!$dni) {
            return redirect()->route('home')->with('error', 'Por favor, ingrese un número de DNI.');
        }

        $student = Student::with(['curriculum', 'courses', 'efsrts'])
            ->where('dni', $dni)
            ->first();

        if (!$student) {
            return redirect()->route('home')->with('error', 'El DNI ingresado no corresponde a ningún estudiante registrado.');
        }

        return view('graduation.public_show', compact('student'));
    }
}
