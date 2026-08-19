<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Efsrt;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a complete statistics dashboard.
     */
    public function index()
    {
        $students = Student::with(["curriculum", "courses", "efsrts"])->get();
        $totalStudents = $students->count();

        // 1. Graduation Status Metrics
        $statusCounts = [
            "Titulado" => 0,
            "Apto" => 0,
            "En Proceso" => 0,
            "Sin Malla" => 0,
        ];

        foreach ($students as $student) {
            $st = $student->overall_status;
            if (isset($statusCounts[$st])) {
                $statusCounts[$st]++;
            } else {
                $statusCounts[$st] = 1;
            }
        }

        $tituladosCount = $statusCounts["Titulado"] ?? 0;
        $aptosCount = $statusCounts["Apto"] ?? 0;
        $enProcesoCount = $statusCounts["En Proceso"] ?? 0;
        $sinMallaCount = $statusCounts["Sin Malla"] ?? 0;

        $safeTotal = max(1, $totalStudents);
        $tituladosPct = round(($tituladosCount / $safeTotal) * 100, 1);
        $aptosPct = round(($aptosCount / $safeTotal) * 100, 1);
        $enProcesoPct = round(($enProcesoCount / $safeTotal) * 100, 1);
        $sinMallaPct = round(($sinMallaCount / $safeTotal) * 100, 1);

        // 2. Global Resources Totals
        $totalTeachers = Teacher::count();
        $totalCurriculums = Curriculum::count();
        $totalCourses = Course::count();
        $totalCredits = Course::sum("credits");
        $totalHours = Course::sum("hours");

        // 3. Students by Shift (Turno)
        $shiftsRaw = [
            "Diurno (Mañana)" => 0,
            "Diurno (Tarde)" => 0,
            "Nocturno (Noche)" => 0,
            "Sin Turno" => 0,
        ];
        foreach ($students as $student) {
            $sh = $student->shift ?: "Sin Turno";
            if (isset($shiftsRaw[$sh])) {
                $shiftsRaw[$sh]++;
            } else {
                $shiftsRaw[$sh] = 1;
            }
        }

        // 4. Students by Admission Year (Cohorts)
        $cohorts = [];
        foreach ($students as $student) {
            if ($student->admission_date) {
                $year = Carbon::parse($student->admission_date)->year;
                $cohorts[$year] = ($cohorts[$year] ?? 0) + 1;
            }
        }
        ksort($cohorts);

        // 5. Curriculums with student distribution
        $curriculumsStats = Curriculum::withCount(["students", "courses"])->get();

        // 6. Courses by Academic Period (I to VI)
        $periodsOrder = ["I", "II", "III", "IV", "V", "VI"];
        $coursesByPeriod = Course::select("period", DB::raw("count(*) as total_courses"), DB::raw("sum(credits) as total_credits"), DB::raw("sum(hours) as total_hours"))
            ->groupBy("period")
            ->get()
            ->keyBy("period");

        // 7. EFSRT Practices Statistics
        $efsrtStats = [
            "total_approved" => 0,
            "total_pending" => 0,
            "total_rejected" => 0,
        ];

        $efsrtModuleStats = [];
        $allEfsrts = Efsrt::all();
        foreach ($allEfsrts as $ef) {
            $efsrtModuleStats[$ef->id] = [
                "module" => $ef->module,
                "name" => $ef->module_name,
                "approved" => 0,
                "pending" => 0,
                "rejected" => 0,
            ];
        }

        foreach ($students as $student) {
            foreach ($student->efsrtStatusList() as $efs) {
                $st = $efs["status"] ?? "pending";
                if ($st === "approved") {
                    $efsrtStats["total_approved"]++;
                } elseif ($st === "rejected") {
                    $efsrtStats["total_rejected"]++;
                } else {
                    $efsrtStats["total_pending"]++;
                }

                if (isset($efsrtModuleStats[$efs["id"]])) {
                    $efsrtModuleStats[$efs["id"]][$st]++;
                }
            }
        }

        // 8. Recent Students & Aptos Pending Graduation
        $recentStudents = Student::latest()->take(6)->get();
        $aptosStudents = $students->filter(fn($s) => $s->overall_status === "Apto")->take(5);

        return view("dashboard", compact(
            "totalStudents",
            "tituladosCount",
            "aptosCount",
            "enProcesoCount",
            "sinMallaCount",
            "tituladosPct",
            "aptosPct",
            "enProcesoPct",
            "sinMallaPct",
            "totalTeachers",
            "totalCurriculums",
            "totalCourses",
            "totalCredits",
            "totalHours",
            "shiftsRaw",
            "cohorts",
            "curriculumsStats",
            "periodsOrder",
            "coursesByPeriod",
            "efsrtStats",
            "efsrtModuleStats",
            "recentStudents",
            "aptosStudents"
        ));
    }
}
