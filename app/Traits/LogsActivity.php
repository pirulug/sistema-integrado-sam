<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait LogsActivity
{
    /**
     * Boot the LogsActivity trait for Eloquent models.
     */
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            $model->recordModelActivity("created");
        });

        static::updated(function (Model $model) {
            $model->recordModelActivity("updated");
        });

        static::deleted(function (Model $model) {
            $model->recordModelActivity("deleted");
        });
    }

    /**
     * List of attribute keys to ignore from automatic logging.
     */
    public function getIgnoredActivityAttributes(): array
    {
        return [
            "password",
            "remember_token",
            "created_at",
            "updated_at",
            "email_verified_at",
            "two_factor_secret",
            "two_factor_recovery_codes",
        ];
    }

    /**
     * Get the human-readable module name for this model.
     */
    public function getActivityModuleName(): string
    {
        $class = class_basename($this);

        return match ($class) {
            "Student" => "Estudiantes",
            "Teacher" => "Profesores",
            "User" => "Usuarios",
            "Curriculum" => "Mallas Curriculares",
            "Course" => "Cursos",
            "Efsrt" => "EFSRT",
            default => $class,
        };
    }

    /**
     * Get a human-readable identifier label for this model record.
     */
    public function getActivitySubjectLabel(): string
    {
        if (isset($this->full_name)) {
            $dni = $this->dni ? " (DNI: {$this->dni})" : "";
            return "{$this->full_name}{$dni}";
        }

        if (isset($this->name)) {
            $code = isset($this->code) ? " [{$this->code}]" : "";
            $year = isset($this->year) ? " ({$this->year})" : "";
            return "{$this->name}{$code}{$year}";
        }

        if (isset($this->module_name)) {
            return "{$this->module}: {$this->module_name}";
        }

        return "ID #{$this->getKey()}";
    }

    /**
     * Record the activity event for this model.
     */
    protected function recordModelActivity(string $action): void
    {
        $ignored = $this->getIgnoredActivityAttributes();
        $module = $this->getActivityModuleName();
        $label = $this->getActivitySubjectLabel();

        $oldValues = null;
        $newValues = null;
        $description = "";

        if ($action === "created") {
            $newValues = Arr::except($this->getAttributes(), $ignored);
            $description = "Registró nuevo {$module}: {$label}";
        } elseif ($action === "updated") {
            $dirty = Arr::except($this->getDirty(), $ignored);

            if (empty($dirty)) {
                return;
            }

            $oldValues = [];
            $newValues = [];

            foreach ($dirty as $key => $newValue) {
                $oldValues[$key] = $this->getOriginal($key);
                $newValues[$key] = $newValue;
            }

            $changedKeys = implode(", ", array_keys($dirty));
            $description = "Actualizó campos ({$changedKeys}) en {$module}: {$label}";
        } elseif ($action === "deleted") {
            $oldValues = Arr::except($this->getOriginal(), $ignored);
            $description = "Eliminó registro de {$module}: {$label}";
        }

        ActivityLog::record(
            action: $action,
            module: $module,
            description: $description,
            subjectLabel: $label,
            subject: $this,
            oldValues: $oldValues,
            newValues: $newValues
        );
    }
}
