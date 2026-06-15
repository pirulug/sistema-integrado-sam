<?php

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect("/login");
});

Auth::routes();

Route::get("/home", [App\Http\Controllers\HomeController::class, "index"])->name("home");

Route::resource("students", App\Http\Controllers\StudentController::class)->middleware("auth");

Route::resource("teachers", App\Http\Controllers\TeacherController::class)->middleware("auth");

Route::resource("careers", App\Http\Controllers\CareerController::class)->middleware("auth");

Route::resource("courses", App\Http\Controllers\CourseController::class)->middleware("auth");

Route::post("students/{student}/courses", [App\Http\Controllers\StudentCourseController::class, "store"])
    ->name("students.courses.store")
    ->middleware("auth");

Route::put("students/{student}/courses/{course}", [App\Http\Controllers\StudentCourseController::class, "update"])
    ->name("students.courses.update")
    ->middleware("auth");

Route::delete("students/{student}/courses/{course}", [App\Http\Controllers\StudentCourseController::class, "destroy"])
    ->name("students.courses.destroy")
    ->middleware("auth");

Route::get("students/{student}/efsrt/edit", [App\Http\Controllers\StudentEfsrtController::class, "edit"])
    ->name("students.efsrt.edit")
    ->middleware("auth");

Route::put("students/{student}/efsrt/all", [App\Http\Controllers\StudentEfsrtController::class, "updateAll"])
    ->name("students.efsrt.updateAll")
    ->middleware("auth");

Route::put("students/{student}/efsrt/{efsrt}", [App\Http\Controllers\StudentEfsrtController::class, "update"])
    ->name("students.efsrt.update")
    ->middleware("auth");

Route::put("students/{student}/efsrt", [App\Http\Controllers\StudentEfsrtController::class, "updateBatch"])
    ->name("students.efsrt.updateBatch")
    ->middleware("auth");

Route::get("students/{student}/courses/edit", [App\Http\Controllers\StudentCourseController::class, "edit"])
    ->name("students.courses.edit")
    ->middleware("auth");

Route::get("students/{student}/graduation", [App\Http\Controllers\StudentGraduationController::class, "edit"])
    ->name("students.graduation.edit")
    ->middleware("auth");

Route::put("students/{student}/graduation", [App\Http\Controllers\StudentGraduationController::class, "update"])
    ->name("students.graduation.update")
    ->middleware("auth");


