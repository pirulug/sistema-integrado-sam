<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Efsrt extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'module_name',
    ];

    /**
     * The curriculums that belong to the EFSRT module.
     */
    public function curriculums(): BelongsToMany
    {
        return $this->belongsToMany(Curriculum::class, 'curriculum_efsrt')->withTimestamps();
    }

    /**
     * The students that belong to the EFSRT module.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
                    ->withPivot(['company_name', 'hours', 'start_date', 'end_date', 'status'])
                    ->withTimestamps();
    }
}
