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
     * Display the graduation tracking panel.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $curriculumId = $request->input('curriculum_id');
        $shift = $request->input('shift');
        $status = $request->input('status');

        $studentsQuery = Student::with(['curriculum', 'courses', 'efsrts']);

        if ($search) {
             $studentsQuery->where(function($q) use ($search) {
                 $q->where('dni', 'like', "%{$search}%")
                   ->orWhere('student_code', 'like', "%{$search}%")
                   ->orWhere('paternal_last_name', 'like', "%{$search}%")
                   ->orWhere('maternal_last_name', 'like', "%{$search}%")
                   ->orWhere('first_name', 'like', "%{$search}%");
             });
        }

        if ($curriculumId) {
            $studentsQuery->where('curriculum_id', $curriculumId);
        }

        if ($shift) {
            $studentsQuery->where('shift', $shift);
        }

        $students = $studentsQuery->get();

        // Filter by general graduation status in memory
        if ($status) {
            $students = $students->filter(function($student) use ($status) {
                return $student->overall_status === $status;
            });
        }

        $curriculums = Curriculum::all();

        return view('graduation.index', compact(
            'students', 
            'curriculums', 
            'search', 
            'curriculumId', 
            'shift', 
            'status'
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
     * Register degree date to set student status to Titulado.
     */
    public function titular(Request $request, Student $student)
    {
        $validated = $request->validate([
            'degree_date' => 'required|date',
        ]);

        $student->update([
            'degree_date' => $validated['degree_date'],
        ]);

        return redirect()->back()->with('success', 'Estudiante titulado exitosamente.');
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
        $approvedIds = $student->courses()->pluck('course_id')->toArray();

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
