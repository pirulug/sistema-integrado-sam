<?php

use App\Models\User;
use App\Models\Teacher;

test("guest cannot access teacher index", function () {
    $response = $this->get("/teachers");

    $response->assertRedirect("/login");
});

test("authenticated user can access teacher index", function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get("/teachers");

    $response->assertStatus(200);
});

test("authenticated user can view teacher details", function () {
    $user = User::factory()->create();
    $teacher = Teacher::factory()->create();

    $response = $this->actingAs($user)->get("/teachers/" . $teacher->id);

    $response->assertStatus(200);
    $response->assertSee($teacher->name);
});

test("authenticated user can create teacher", function () {
    $user = User::factory()->create();

    $teacherData = [
        "name" => "Profesor X",
        "document_number" => "87654321",
        "email" => "profesorx@example.com",
        "phone" => "555-4321",
        "specialty" => "Telepatía",
        "status" => "activo",
        "hire_date" => "2026-06-01",
    ];

    $response = $this->actingAs($user)->post("/teachers", $teacherData);

    $response->assertRedirect("/teachers");
    $this->assertDatabaseHas("teachers", [
        "document_number" => "87654321",
        "name" => "Profesor X",
    ]);
});

test("authenticated user can update teacher", function () {
    $user = User::factory()->create();
    $teacher = Teacher::factory()->create([
        "name" => "Old Name",
        "document_number" => "22222222",
    ]);

    $updateData = [
        "name" => "New Name",
        "document_number" => "22222222",
        "specialty" => "Física Cuántica",
        "status" => "inactivo",
        "hire_date" => "2026-06-01",
    ];

    $response = $this->actingAs($user)->put("/teachers/" . $teacher->id, $updateData);

    $response->assertRedirect("/teachers");
    $this->assertDatabaseHas("teachers", [
        "id" => $teacher->id,
        "name" => "New Name",
        "status" => "inactivo",
    ]);
});

test("authenticated user can delete teacher", function () {
    $user = User::factory()->create();
    $teacher = Teacher::factory()->create();

    $response = $this->actingAs($user)->delete("/teachers/" . $teacher->id);

    $response->assertRedirect("/teachers");
    $this->assertDatabaseMissing("teachers", [
        "id" => $teacher->id,
    ]);
});
