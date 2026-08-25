<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curriculum extends Model
{
    use HasFactory, LogsActivity;

    protected $table = "curriculums";

    protected $fillable = [
        "name",
        "year",
    ];

    /**
     * The students that belong to the curriculum.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * The courses that belong to the curriculum.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, "course_curriculum")->withTimestamps();
    }

    /**
     * The EFSRT records that belong to the curriculum.
     */
    public function efsrts(): BelongsToMany
    {
        return $this->belongsToMany(Efsrt::class, "curriculum_efsrt")->withTimestamps();
    }
}
