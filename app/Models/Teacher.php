<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "dni",
        "teacher_code",
        "paternal_last_name",
        "maternal_last_name",
        "first_name",
        "personal_email",
        "institutional_email",
        "phone",
        "mobile",
        "photo_path",
        "hire_date",
    ];

    /**
     * Get the user account associated with the teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->paternal_last_name} {$this->maternal_last_name}, {$this->first_name}";
    }

    /**
     * Get photo URL or null.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path) {
            return asset("storage/" . $this->photo_path);
        }
        return null;
    }
}
