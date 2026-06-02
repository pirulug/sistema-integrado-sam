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
