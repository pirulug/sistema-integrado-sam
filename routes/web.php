<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EfsrtController;
use App\Http\Controllers\GraduationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $curriculum = \App\Models\Curriculum::with('courses')->first();
    $coursesByPeriod = $curriculum ? $curriculum->courses->groupBy('period') : collect();
    return view('landing', compact('coursesByPeriod'));
})->name('home');

Route::get('/consulta', [GraduationController::class, 'publicLookup'])->name('graduation.public-lookup');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teacher & Admin routes
    Route::middleware("role:teacher")->group(function () {
        Route::get("students/template", [StudentController::class, "downloadTemplate"])->name("students.template");
        Route::post("students/import", [StudentController::class, "import"])->name("students.import");
        Route::get("students/import-conflicts", [StudentController::class, "showConflicts"])->name("students.import-conflicts");
        Route::post("students/import-conflicts/resolve", [StudentController::class, "resolveConflicts"])->name("students.import-conflicts.resolve");
        Route::post("students/import-conflicts/cancel", [StudentController::class, "cancelConflicts"])->name("students.import-conflicts.cancel");
        Route::resource("students", StudentController::class);
        Route::resource('curriculums', CurriculumController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('efsrts', EfsrtController::class);

        Route::get('/graduation', [GraduationController::class, 'index'])->name('graduation.index');
        Route::post('/graduation/{student}/toggle-course/{course}', [GraduationController::class, 'toggleCourse'])->name('graduation.toggle-course');
        Route::post('/graduation/{student}/update-efsrt/{efsrt}', [GraduationController::class, 'updateEfsrt'])->name('graduation.update-efsrt');
        Route::post('/graduation/{student}/titular', [GraduationController::class, 'titular'])->name('graduation.titular');
        Route::post('/graduation/{student}/bulk-courses', [GraduationController::class, 'bulkCourses'])->name('graduation.bulk-courses');
    });

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('teachers', TeacherController::class);
    });
});

require __DIR__.'/auth.php';
