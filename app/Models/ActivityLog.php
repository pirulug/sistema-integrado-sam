<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "user_name",
        "user_role",
        "action",
        "module",
        "subject_type",
        "subject_id",
        "subject_label",
        "description",
        "old_values",
        "new_values",
        "ip_address",
        "user_agent",
    ];

    protected function casts(): array
    {
        return [
            "old_values" => "array",
            "new_values" => "array",
            "created_at" => "datetime",
        ];
    }

    /**
     * User who performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quick helper to record an activity log entry.
     */
    public static function record(
        string $action,
        string $module,
        string $description,
        ?string $subjectLabel = null,
        ?Model $subject = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): self {
        $user = Auth::user();

        return self::create([
            "user_id" => $user?->id,
            "user_name" => $user?->name ?? "Sistema / Invitado",
            "user_role" => $user?->role ?? "system",
            "action" => $action,
            "module" => $module,
            "subject_type" => $subject ? get_class($subject) : null,
            "subject_id" => $subject?->getKey(),
            "subject_label" => $subjectLabel,
            "description" => $description,
            "old_values" => $oldValues,
            "new_values" => $newValues,
            "ip_address" => Request::ip(),
            "user_agent" => Request::userAgent(),
        ]);
    }

    /**
     * Scope for searching keyword across description, user name and subject label.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where("description", "like", "%{$search}%")
                ->orWhere("user_name", "like", "%{$search}%")
                ->orWhere("subject_label", "like", "%{$search}%")
                ->orWhere("action", "like", "%{$search}%")
                ->orWhere("module", "like", "%{$search}%");
        });
    }

    /**
     * Scope for filtering by module.
     */
    public function scopeByModule(Builder $query, ?string $module): Builder
    {
        if (empty($module)) {
            return $query;
        }

        return $query->where("module", $module);
    }

    /**
     * Scope for filtering by action.
     */
    public function scopeByAction(Builder $query, ?string $action): Builder
    {
        if (empty($action)) {
            return $query;
        }

        return $query->where("action", $action);
    }

    /**
     * Scope for filtering by user ID.
     */
    public function scopeByUser(Builder $query, $userId): Builder
    {
        if (empty($userId)) {
            return $query;
        }

        return $query->where("user_id", $userId);
    }

    /**
     * Scope for date range preset filtering.
     */
    public function scopeByDateRange(Builder $query, ?string $range): Builder
    {
        if (empty($range)) {
            return $query;
        }

        return match ($range) {
            "today" => $query->whereDate("created_at", Carbon::today()),
            "yesterday" => $query->whereDate("created_at", Carbon::yesterday()),
            "this_week" => $query->whereBetween("created_at", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            "this_month" => $query->whereBetween("created_at", [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]),
            "last_30_days" => $query->where("created_at", ">=", Carbon::now()->subDays(30)),
            default => $query,
        };
    }
}
