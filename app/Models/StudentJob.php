<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentJob extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "current_job",
        "workplace",
        "is_related",
    ];

    /**
     * Get the student that owns the job.
     */
    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
