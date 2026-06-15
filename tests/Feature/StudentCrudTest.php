<?php

use App\Models\User;
use App\Models\Student;

test("guest cannot access student index", function () {
    $response = $this->get("/students");

    $response->assertRedirect("/login");
});

test("authenticated user can access student index", function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get("/students");

    $response->assertStatus(200);
});

test("authenticated user can view student details", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $response = $this->actingAs($user)->get("/students/" . $student->id);

    $response->assertStatus(200);
    $response->assertSee($student->name);
});

test("authenticated user can create student", function () {
    $user = User::factory()->create();

    $studentData = [
        "name" => "Pepito Perez",
        "document_number" => "98765432",
        "personal_email" => "pepito@example.com",
        "institutional_email" => "pepito@sam.edu.pe",
        "phone" => "555-1234",
        "status" => "matriculado",
        "enrollment_date" => "2026-06-01",
        "entry_year" => 2026,
    ];

    $response = $this->actingAs($user)->post("/students", $studentData);

    $response->assertRedirect("/students");
    $this->assertDatabaseHas("students", [
        "document_number" => "98765432",
        "name" => "Pepito Perez",
        "entry_year" => 2026,
    ]);
});

test("authenticated user can update student", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create([
        "name" => "Old Name",
        "document_number" => "11111111",
    ]);

    $updateData = [
        "name" => "New Name",
        "document_number" => "11111111", // keep same unique document
        "status" => "egresado",
        "enrollment_date" => "2026-06-01",
        "graduation_date" => "2026-06-02",
        "entry_year" => 2025,
        "graduation_year" => 2026,
    ];

    $response = $this->actingAs($user)->put("/students/" . $student->id, $updateData);

    $response->assertRedirect("/students");
    $this->assertDatabaseHas("students", [
        "id" => $student->id,
        "name" => "New Name",
        "status" => "egresado",
        "entry_year" => 2025,
        "graduation_year" => 2026,
    ]);
});

test("authenticated user can delete student", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $response = $this->actingAs($user)->delete("/students/" . $student->id);

    $response->assertRedirect("/students");
    $this->assertDatabaseMissing("students", [
        "id" => $student->id,
    ]);
});
