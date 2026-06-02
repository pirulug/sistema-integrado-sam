<?php

test("the root path redirects to login", function () {
    $response = $this->get("/");

    $response->assertStatus(302);
});

test("the login page returns a successful response", function () {
    $response = $this->get("/login");

    $response->assertStatus(200);
});

test("it can create a student", function () {
    \App\Models\Student::factory()->create([
        "name" => "Juan Perez",
        "document_number" => "12345678",
        "status" => "matriculado",
    ]);

    $this->assertDatabaseHas("students", [
        "name" => "Juan Perez",
        "document_number" => "12345678",
        "status" => "matriculado",
    ]);
});
