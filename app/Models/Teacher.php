<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;

    protected $fillable = [
        "name",
        "document_number",
        "email",
        "phone",
        "specialty",
        "status",
        "hire_date",
    ];

    /**
     * Get the careers/study programs that the teacher belongs to.
     */
    public function careers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Career::class)->withTimestamps();
    }
}
