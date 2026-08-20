<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
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
        "admission_date",
        "graduation_date",
        "degree_date",
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
                    ->withPivot(['company_name', 'hours', 'start_date', 'end_date', 'status'])
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
        return $this->curriculum->courses()->whereIn('courses.id', $this->courses->pluck('id'))->get();
    }

    /**
     * Pending courses of the assigned curriculum.
     */
    public function pendingCourses()
    {
        if (!$this->curriculum) {
            return collect();
        }
        return $this->curriculum->courses()->whereNotIn('courses.id', $this->courses->pluck('id'))->get();
    }

    /**
     * EFSRT status list mapped to the student.
     */
    public function efsrtStatusList()
    {
        if (!$this->curriculum) {
            return collect();
        }
        $studentEfsrts = $this->efsrts->keyBy('id');
        return $this->curriculum->efsrts->map(function ($efsrt) use ($studentEfsrts) {
            $studentEfs = $studentEfsrts->get($efsrt->id);
            return [
                'id' => $efsrt->id,
                'module' => $efsrt->module,
                'module_name' => $efsrt->module_name,
                'status' => $studentEfs ? $studentEfs->pivot->status : 'pending',
                'pivot' => $studentEfs ? $studentEfs->pivot : null,
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
