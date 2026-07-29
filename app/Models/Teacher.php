<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'teacher_code',
        'paternal_last_name',
        'maternal_last_name',
        'first_name',
        'personal_email',
        'institutional_email',
        'phone',
        'mobile',
        'hire_date',
    ];

    /**
     * Get full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->paternal_last_name} {$this->maternal_last_name}, {$this->first_name}";
    }
}
