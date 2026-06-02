<?php

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect("/login");
});

Auth::routes();

Route::get("/home", [App\Http\Controllers\HomeController::class, "index"])->name("home");

Route::resource("students", App\Http\Controllers\StudentController::class)->middleware("auth");
