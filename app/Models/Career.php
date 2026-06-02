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
    ];

    /**
     * Get the students enrolled in this career.
     */
    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    /**
     * Get the teachers appointed to this career.
     */
    public function teachers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }
}
