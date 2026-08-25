<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherUser = User::updateOrCreate(
            ["email" => "teacher@gmail.com"],
            [
                "name" => "Maria Elena Ramirez Soto",
                "dni" => "87654321",
                "password" => Hash::make("teacher123"),
                "role" => "teacher",
            ]
        );

        Teacher::updateOrCreate(
            ["dni" => "87654321"],
            [
                "user_id" => $teacherUser->id,
                "teacher_code" => "DOC2026001",
                "paternal_last_name" => "Ramirez",
                "maternal_last_name" => "Soto",
                "first_name" => "Maria Elena",
                "personal_email" => "maria.ramirez@gmail.com",
                "institutional_email" => "mramirez@sam.edu.pe",
                "phone" => "013456789",
                "mobile" => "912345678",
                "hire_date" => "2020-03-01",
            ]
        );
    }
}
