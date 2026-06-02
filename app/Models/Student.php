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
        "document_number",
        "email",
        "phone",
        "status",
        "enrollment_date",
        "graduation_date",
    ];

    /**
     * Get the careers that the student belongs to.
     */
    public function careers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Career::class)->withTimestamps();
    }
}
