<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    /** @use HasFactory<\Database\Factories\CareerFactory> */
    use HasFactory;

    protected $fillable = [
        "name",
        "code",
        "description",
        "status",
        "shifts",
    ];

    protected $casts = [
        "shifts" => "array",
    ];

    /**
     * Get the students enrolled in this career.
     */
    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withPivot("shift", "entry_year", "graduation_year", "title_date")->withTimestamps();
    }

    /**
     * Get the teachers appointed to this career.
     */
    public function teachers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }

    /**
     * Get the courses that belong to this career.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the curriculums associated with this career.
     */
    public function curriculums(): HasMany
    {
        return $this->hasMany(Curriculum::class);
    }
}

