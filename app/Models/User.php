<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\LogsActivity;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(["name", "dni", "email", "password", "role", "photo_path"])]
#[Hidden(["password", "remember_token"])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    /**
     * Get the teacher profile associated with the user.
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Check if user is an Administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === "admin";
    }

    /**
     * Check if user is a Teacher.
     */
    public function isTeacher(): bool
    {
        return $this->role === "teacher";
    }

    /**
     * Check if user is an Auditor / Observer.
     */
    public function isAuditor(): bool
    {
        return $this->role === "auditor";
    }

    /**
     * Check if user can view administrative modules (Admin or Auditor).
     */
    public function canViewAdminModules(): bool
    {
        return in_array($this->role, ["admin", "auditor"]);
    }

    /**
     * Check if user has permission to create, edit, or modify data.
     */
    public function canManage(): bool
    {
        return in_array($this->role, ["admin", "teacher"]);
    }

    /**
     * Check if user is a Student.
     */
    public function isStudent(): bool
    {
        return $this->role === "student";
    }

    /**
     * Get photo URL or null.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path) {
            return asset("storage/" . $this->photo_path);
        }
        if ($this->teacher && $this->teacher->photo_path) {
            return asset("storage/" . $this->teacher->photo_path);
        }
        return null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }
}
