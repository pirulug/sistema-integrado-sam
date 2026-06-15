<?php

use App\Models\User;
use App\Models\Student;
use App\Models\Career;
use App\Models\Course;

test("guest cannot register a course for a student", function () {
    $student = Student::factory()->create();
    $course = Course::factory()->create();

    $response = $this->post("/students/{$student->id}/courses", [
        "course_id" => $course->id,
        "grade" => 15,
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/login");
});

test("authenticated user can register course for a student in their career", function () {
    $user = User::factory()->create();
    $career = Career::factory()->create(["status" => "activo"]);
    
    $student = Student::factory()->create();
    $student->careers()->attach($career->id);

    $course = Course::create([
        "name" => "Introduction to Testing",
        "code" => "TEST-101",
        "credits" => 4,
        "career_id" => $career->id,
    ]);

    $response = $this->actingAs($user)->post("/students/{$student->id}/courses", [
        "course_id" => $course->id,
        "grade" => 15,
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/students/{$student->id}/courses/edit");
    $this->assertDatabaseHas("course_student", [
        "student_id" => $student->id,
        "course_id" => $course->id,
        "grade" => 15,
        "status" => "aprobado",
    ]);
});

test("cannot register a course belonging to another career", function () {
    $user = User::factory()->create();
    $career1 = Career::factory()->create(["status" => "activo"]);
    $career2 = Career::factory()->create(["status" => "activo"]);
    
    $student = Student::factory()->create();
    $student->careers()->attach($career1->id); // only career 1

    $course = Course::create([
        "name" => "Course of Career 2",
        "code" => "CAR2-101",
        "credits" => 3,
        "career_id" => $career2->id,
    ]);

    $response = $this->actingAs($user)->from("/students/{$student->id}/courses/edit")->post("/students/{$student->id}/courses", [
        "course_id" => $course->id,
        "grade" => 15,
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/students/{$student->id}/courses/edit");
    $response->assertSessionHasErrors("course_id");
    $this->assertDatabaseMissing("course_student", [
        "student_id" => $student->id,
        "course_id" => $course->id,
    ]);
});

test("cannot register duplicate courses for a student", function () {
    $user = User::factory()->create();
    $career = Career::factory()->create(["status" => "activo"]);
    
    $student = Student::factory()->create();
    $student->careers()->attach($career->id);

    $course = Course::create([
        "name" => "Introduction to Testing",
        "code" => "TEST-101",
        "credits" => 4,
        "career_id" => $career->id,
    ]);

    // First insertion
    $student->courses()->attach($course->id, ["grade" => 10, "status" => "desaprobado"]);

    // Attempt duplicate
    $response = $this->actingAs($user)->from("/students/{$student->id}/courses/edit")->post("/students/{$student->id}/courses", [
        "course_id" => $course->id,
        "grade" => 15,
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/students/{$student->id}/courses/edit");
    $response->assertSessionHasErrors("course_id");
    
    // Grade should remain 10 / desaprobado
    $this->assertDatabaseHas("course_student", [
        "student_id" => $student->id,
        "course_id" => $course->id,
        "grade" => 10,
        "status" => "desaprobado",
    ]);
});

test("authenticated user can update course grade and status for a student", function () {
    $user = User::factory()->create();
    $career = Career::factory()->create(["status" => "activo"]);
    
    $student = Student::factory()->create();
    $student->careers()->attach($career->id);

    $course = Course::create([
        "name" => "Introduction to Testing",
        "code" => "TEST-101",
        "credits" => 4,
        "career_id" => $career->id,
    ]);

    $student->courses()->attach($course->id, ["grade" => 10, "status" => "desaprobado"]);

    $response = $this->actingAs($user)->put("/students/{$student->id}/courses/{$course->id}", [
        "grade" => 18,
        "status" => "aprobado",
    ]);

    $response->assertRedirect("/students/{$student->id}/courses/edit");
    $this->assertDatabaseHas("course_student", [
        "student_id" => $student->id,
        "course_id" => $course->id,
        "grade" => 18,
        "status" => "aprobado",
    ]);
});

test("authenticated user can delete course record from student history", function () {
    $user = User::factory()->create();
    $career = Career::factory()->create(["status" => "activo"]);
    
    $student = Student::factory()->create();
    $student->careers()->attach($career->id);

    $course = Course::create([
        "name" => "Introduction to Testing",
        "code" => "TEST-101",
        "credits" => 4,
        "career_id" => $career->id,
    ]);

    $student->courses()->attach($course->id, ["grade" => 10, "status" => "desaprobado"]);

    $response = $this->actingAs($user)->delete("/students/{$student->id}/courses/{$course->id}");

    $response->assertRedirect("/students/{$student->id}/courses/edit");
    $this->assertDatabaseMissing("course_student", [
        "student_id" => $student->id,
        "course_id" => $course->id,
    ]);
});

test("guest cannot access edit courses page", function () {
    $student = Student::factory()->create();
    $response = $this->get("/students/{$student->id}/courses/edit");
    $response->assertRedirect("/login");
});

test("authenticated user can access edit courses page", function () {
    $user = User::factory()->create();
    $career = Career::factory()->create(["status" => "activo"]);
    $student = Student::factory()->create();
    $student->careers()->attach($career->id);

    $response = $this->actingAs($user)->get("/students/{$student->id}/courses/edit");
    $response->assertStatus(200);
    $response->assertSee("Historial Académico");
});
