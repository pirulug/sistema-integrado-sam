<?php

use App\Models\User;
use App\Models\Student;
use App\Models\EfsrtRecord;

test("automatically creates 3 efsrt records when student is created", function () {
    $student = Student::factory()->create();

    $this->assertDatabaseHas("efsrt_records", [
        "student_id" => $student->id,
        "module_name" => "MODULO I",
        "status" => "pendiente",
    ]);

    $this->assertDatabaseHas("efsrt_records", [
        "student_id" => $student->id,
        "module_name" => "MODULO II",
        "status" => "pendiente",
    ]);

    $this->assertDatabaseHas("efsrt_records", [
        "student_id" => $student->id,
        "module_name" => "MODULO III",
        "status" => "pendiente",
    ]);

    expect($student->efsrtRecords)->toHaveCount(3);
});

test("guest cannot update efsrt records", function () {
    $student = Student::factory()->create();
    $efsrt = $student->efsrtRecords()->first();

    $response = $this->put("/students/{$student->id}/efsrt/{$efsrt->id}", [
        "grade" => 15,
        "hours" => 200,
        "company" => "Empresa Test",
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/login");
});

test("authenticated user can update student efsrt records", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();
    $efsrt = $student->efsrtRecords()->first();

    $response = $this->actingAs($user)->put("/students/{$student->id}/efsrt/{$efsrt->id}", [
        "grade" => 18,
        "hours" => 250,
        "company" => "Google LLC",
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/students/{$student->id}");
    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt->id,
        "student_id" => $student->id,
        "grade" => 18,
        "hours" => 250,
        "company" => "Google LLC",
        "status" => "aprobado",
    ]);
});

test("cannot update efsrt record using another student's route", function () {
    $user = User::factory()->create();
    $student1 = Student::factory()->create();
    $student2 = Student::factory()->create();
    
    $efsrtOfStudent1 = $student1->efsrtRecords()->first();

    // Try to update student 1's efsrt using student 2's route
    $response = $this->actingAs($user)->put("/students/{$student2->id}/efsrt/{$efsrtOfStudent1->id}", [
        "grade" => 18,
        "hours" => 250,
        "company" => "Google LLC",
        "status" => "aprobado",
    ]);

    $response->assertStatus(403);
});

test("guest cannot access edit efsrt page", function () {
    $student = Student::factory()->create();
    $response = $this->get("/students/{$student->id}/efsrt/edit");

    $response->assertRedirect("/login");
});

test("authenticated user can access edit efsrt page", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $response = $this->actingAs($user)->get("/students/{$student->id}/efsrt/edit");

    $response->assertStatus(200);
    $response->assertSee("Editar Módulos EFSRT");
});

test("authenticated user can update student EFSRT records via separate EFSRT edit form", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create([
        "name" => "Pepito",
        "document_number" => "12345678",
        "entry_year" => 2024,
    ]);

    $efsrt1 = $student->efsrtRecords()->where("module_name", "MODULO I")->first();
    $efsrt2 = $student->efsrtRecords()->where("module_name", "MODULO II")->first();
    $efsrt3 = $student->efsrtRecords()->where("module_name", "MODULO III")->first();

    $payload = [
        "efsrt" => [
            $efsrt1->id => [
                "company" => "Microsoft Corp",
                "hours" => 300,
                "grade" => 16,
                "status" => "aprobado",
            ],
            $efsrt2->id => [
                "company" => "Amazon Inc",
                "hours" => 200,
                "grade" => 14,
                "status" => "aprobado",
            ],
            $efsrt3->id => [
                "company" => "",
                "hours" => 0,
                "grade" => null,
                "status" => "pendiente",
            ],
        ],
    ];

    $response = $this->actingAs($user)->put("/students/{$student->id}/efsrt/all", $payload);

    $response->assertRedirect("/students/{$student->id}");

    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt1->id,
        "company" => "Microsoft Corp",
        "hours" => 300,
        "grade" => 16,
        "status" => "aprobado",
    ]);

    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt2->id,
        "company" => "Amazon Inc",
        "hours" => 200,
        "grade" => 14,
        "status" => "aprobado",
    ]);

    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt3->id,
        "company" => null,
        "hours" => 0,
        "grade" => null,
        "status" => "pendiente",
    ]);
});

test("authenticated user can batch update student EFSRT statuses using the checklist form", function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $efsrt1 = $student->efsrtRecords()->where("module_name", "MODULO I")->first();
    $efsrt2 = $student->efsrtRecords()->where("module_name", "MODULO II")->first();
    $efsrt3 = $student->efsrtRecords()->where("module_name", "MODULO III")->first();

    // Mark MODULO I and MODULO III as approved, leaving MODULO II pending
    $payload = [
        "approved_modules" => [
            $efsrt1->id,
            $efsrt3->id,
        ],
    ];

    $response = $this->actingAs($user)->put("/students/{$student->id}/efsrt", $payload);

    $response->assertRedirect("/students/{$student->id}");

    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt1->id,
        "status" => "aprobado",
    ]);

    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt2->id,
        "status" => "pendiente",
    ]);

    $this->assertDatabaseHas("efsrt_records", [
        "id" => $efsrt3->id,
        "status" => "aprobado",
    ]);
});
