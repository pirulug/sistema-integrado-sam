<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        "name",
        "student_code",
        "document_number",
        "personal_email",
        "institutional_email",
        "phone",
        "whatsapp",
        "status",
        "enrollment_date",
        "graduation_date",
        "entry_year",
        "graduation_year",
    ];

    /**
     * Get the job record associated with the student.
     */
    public function job(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(StudentJob::class);
    }

    /**
     * Get the careers that the student belongs to.
     */
    public function careers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Career::class)->withPivot("shift", "entry_year", "graduation_year", "title_date", "curriculum_id")->withTimestamps();
    }

    /**
     * Get the courses taken by the student.
     */
    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withPivot("grade", "status")->withTimestamps();
    }

    /**
     * Get the EFSRT pre-professional practice records for the student.
     */
    public function efsrtRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EfsrtRecord::class);
    }

    /**
     * Get the courses that the student has not yet passed from their careers.
     */
    public function getPendingCoursesAttribute()
    {
        // Get all courses from the loaded careers matching the student's assigned curriculum
        $allCareerCourses = $this->careers->flatMap(function ($career) {
            $studentCurriculumId = $career->pivot->curriculum_id;
            if (!$studentCurriculumId) {
                return collect();
            }
            return $career->courses()
                ->where('curriculum_id', $studentCurriculumId)
                ->where('is_actualizacion', false)
                ->get();
        })->unique('id');

        // Get the IDs of the courses the student has passed
        $passedCourseIds = $this->courses
            ->filter(function ($course) {
                return $course->pivot->status === 'aprobado';
            })
            ->pluck('id')
            ->toArray();

        // Return courses that are in the careers but not passed
        return $allCareerCourses->filter(function ($course) use ($passedCourseIds) {
            return !in_array($course->id, $passedCourseIds);
        });
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::created(function ($student) {
            $career = Career::first() ?? Career::factory()->create();
            
            // Attach career if not already attached
            if (!$student->careers()->where('career_id', $career->id)->exists()) {
                $student->careers()->attach($career->id, [
                    'shift' => 'Mañana',
                    'entry_year' => $student->entry_year ?? date('Y'),
                ]);
            }

            // Create 3 EFSRT records for this career
            foreach (["MODULO I", "MODULO II", "MODULO III"] as $module) {
                $student->efsrtRecords()->firstOrCreate([
                    "career_id" => $career->id,
                    "module_name" => $module,
                ], [
                    "status" => "pendiente"
                ]);
            }
        });
    }
}

