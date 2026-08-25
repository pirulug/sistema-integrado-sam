<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of system activity logs for administrators.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");
        $module = $request->input("module");
        $action = $request->input("action");
        $userId = $request->input("user_id");
        $dateRange = $request->input("date_range", "all");

        $query = ActivityLog::with("user")
            ->latest()
            ->search($search)
            ->byModule($module)
            ->byAction($action)
            ->byUser($userId)
            ->byDateRange($dateRange);

        $logs = $query->paginate(20)->withQueryString();

        // Statistics metrics
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate("created_at", Carbon::today())->count();
        $deletionsCount = ActivityLog::where("action", "deleted")->count();

        $topModuleRecord = ActivityLog::select("module", DB::raw("count(*) as total"))
            ->groupBy("module")
            ->orderByDesc("total")
            ->first();
        $topModuleName = $topModuleRecord ? $topModuleRecord->module : "Ninguno";

        // Filter options
        $users = User::orderBy("name")->get(["id", "name", "email", "role"]);

        $modules = [
            "Estudiantes",
            "Profesores",
            "Usuarios",
            "Mallas Curriculares",
            "Cursos",
            "EFSRT",
            "Seguimiento de Titulación",
        ];

        $actions = [
            "created" => "Creación",
            "updated" => "Modificación",
            "deleted" => "Eliminación",
            "imported" => "Importación",
            "toggle_course" => "Aprobación de Curso",
            "bulk_courses" => "Acción Masiva Cursos",
            "update_efsrt" => "Actualización EFSRT",
            "degree_update" => "Registro Titulación",
            "degree_reverted" => "Reversión Titulación",
            "password_reset" => "Restablecimiento Contraseña",
            "conflict_resolution" => "Resolución Conflictos",
        ];

        return view("activity_logs.index", compact(
            "logs",
            "search",
            "module",
            "action",
            "userId",
            "dateRange",
            "totalLogs",
            "todayLogs",
            "deletionsCount",
            "topModuleName",
            "users",
            "modules",
            "actions"
        ));
    }

    /**
     * Display or return JSON details of a single activity log entry.
     */
    public function show(ActivityLog $activityLog): JsonResponse|View
    {
        $activityLog->load("user");

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                "log" => $activityLog,
                "created_at_formatted" => $activityLog->created_at->format("d/m/Y H:i:s"),
                "diff" => $this->buildDiffData($activityLog),
            ]);
        }

        return view("activity_logs.show", compact("activityLog"));
    }

    /**
     * Build comparative diff structure for old vs new values.
     */
    private function buildDiffData(ActivityLog $log): array
    {
        $old = $log->old_values ?? [];
        $new = $log->new_values ?? [];

        $allKeys = array_unique(array_merge(array_keys($old), array_keys($new)));
        $diff = [];

        foreach ($allKeys as $key) {
            $oldVal = $old[$key] ?? null;
            $newVal = $new[$key] ?? null;

            $diff[] = [
                "field" => $key,
                "old" => is_array($oldVal) ? json_encode($oldVal, JSON_UNESCAPED_UNICODE) : (string)$oldVal,
                "new" => is_array($newVal) ? json_encode($newVal, JSON_UNESCAPED_UNICODE) : (string)$newVal,
                "changed" => $oldVal !== $newVal,
            ];
        }

        return $diff;
    }
}
