<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "document_type",
        "dni",
        "student_code",
        "study_program",
        "paternal_last_name",
        "maternal_last_name",
        "first_name",
        "gender",
        "personal_email",
        "institutional_email",
        "phone",
        "mobile",
        "photo_path",
        "admission_date",
        "graduation_date",
        "degree_date",
        "degree_modality",
        "curriculum_id",
        "shift",
    ];

    /**
     * Get full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->paternal_last_name} {$this->maternal_last_name}, {$this->first_name}";
    }

    /**
     * Get photo URL or null.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path) {
            return asset("storage/" . $this->photo_path);
        }
        return null;
    }

    /**
     * Get document label (e.g. 'DNI: 12345678' or 'CE: 123456789').
     */
    public function getDocumentFormattedAttribute(): string
    {
        $type = $this->document_type ?: "DNI";
        return "{$type}: {$this->dni}";
    }

    /**
     * Get associated curriculum.
     */
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    /**
     * The courses that belong to the student.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    /**
     * The EFSRT records that belong to the student.
     */
    public function efsrts(): BelongsToMany
    {
        return $this->belongsToMany(Efsrt::class)
            ->withPivot(["company_name", "practice_line", "activities", "hours", "start_date", "end_date", "status"])
            ->withTimestamps();
    }

    /**
     * Approved courses of the assigned curriculum.
     */
    public function approvedCourses()
    {
        if (!$this->curriculum) {
            return collect();
        }
        $approvedIds = $this->courses->pluck("id");
        return $this->curriculum->courses->whereIn("id", $approvedIds);
    }

    /**
     * Pending courses of the assigned curriculum.
     */
    public function pendingCourses()
    {
        if (!$this->curriculum) {
            return collect();
        }
        $approvedIds = $this->courses->pluck("id");
        return $this->curriculum->courses->whereNotIn("id", $approvedIds);
    }

    /**
     * EFSRT status list mapped to the student.
     */
    public function efsrtStatusList()
    {
        if (!$this->curriculum) {
            return collect();
        }
        $studentEfsrts = $this->efsrts->keyBy("id");
        return $this->curriculum->efsrts->map(function ($efsrt) use ($studentEfsrts) {
            $studentEfs = $studentEfsrts->get($efsrt->id);
            return [
                "id" => $efsrt->id,
                "module" => $efsrt->module,
                "module_name" => $efsrt->module_name,
                "competency" => $efsrt->competency,
                "period" => $efsrt->period,
                "hours" => $efsrt->hours,
                "credits" => $efsrt->credits,
                "practice_lines" => $efsrt->practice_lines,
                "status" => $studentEfs ? $studentEfs->pivot->status : "pending",
                "pivot" => $studentEfs ? $studentEfs->pivot : null,
            ];
        });
    }

    /**
     * General graduation status attribute.
     */
    public function getOverallStatusAttribute(): string
    {
        if ($this->degree_date) {
            return 'Titulado';
        }
        
        if (!$this->curriculum) {
            return 'Sin Malla';
        }
        
        $pendingCount = $this->pendingCourses()->count();
        
        $efsrts = $this->efsrtStatusList();
        $allEfsrtsApproved = $efsrts->isNotEmpty() && $efsrts->every(function ($efsrt) {
            return $efsrt['status'] === 'approved';
        });
        
        if ($pendingCount === 0 && $allEfsrtsApproved) {
            return 'Apto';
        }
        
        return 'En Proceso';
    }
}
