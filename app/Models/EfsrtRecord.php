<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EfsrtRecord extends Model
{
    use HasFactory;

    protected $table = "efsrt_records";

    protected $fillable = [
        "student_id",
        "career_id",
        "module_name",
        "grade",
        "hours",
        "company",
        "status",
    ];

    /**
     * Get the student who owns this record.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the career professional program that this record belongs to.
     */
    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }
}
