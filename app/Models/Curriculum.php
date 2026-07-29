<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'name',
        'year',
    ];

    /**
     * The courses that belong to the curriculum.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_curriculum')->withTimestamps();
    }

    /**
     * The EFSRT records that belong to the curriculum.
     */
    public function efsrts(): BelongsToMany
    {
        return $this->belongsToMany(Efsrt::class, 'curriculum_efsrt')->withTimestamps();
    }
}
