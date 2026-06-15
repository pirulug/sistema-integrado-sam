<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    /**
     * Show the page to manage student's academic course history.
     */
    public function edit(Request $request, Student $student)
    {
        $student->load(["careers", "courses"]);

        $editCourseId = $request->query("edit_course_id");
        $editingCourse = null;
        if ($editCourseId) {
            $editingCourse = $student->courses()->where("course_id", $editCourseId)->first();
        }

        $careerIds = $student->careers->pluck("id");
        $registeredCourseIds = $student->courses->pluck("id");

        // Available courses to register: belongs to the student's career(s) and is not registered yet.
        $availableCourses = \App\Models\Course::whereIn("career_id", $careerIds)
            ->whereNotIn("id", $registeredCourseIds)
            ->orderBy("name")
            ->get();

        return view("students.courses.edit", compact("student", "availableCourses", "editingCourse"));
    }

    /**
     * Store a course record for the student.
     */
    public function store(Request $request, Student $student)
    {
        $validated = $request->validate([
            "course_id" => "required|exists:courses,id",
            "grade" => "nullable|integer|min:0|max:20",
            "status" => "required|in:aprobado,desaprobado",
        ]);

        $course = Course::findOrFail($request->input("course_id"));

        // Validate that course belongs to student's careers professional programs
        if (!$student->careers->pluck("id")->contains($course->career_id)) {
            return back()->withErrors([
                "course_id" => "El curso seleccionado no pertenece a ninguna de las carreras del estudiante.",
            ])->withInput();
        }

        // Validate duplicates
        if ($student->courses()->where("course_id", $course->id)->exists()) {
            return back()->withErrors([
                "course_id" => "Este curso ya está registrado en el historial del estudiante.",
            ])->withInput();
        }

        $student->courses()->attach($course->id, [
            "grade" => $validated["grade"],
            "status" => $validated["status"],
        ]);

        return redirect()->route("students.courses.edit", $student->id)->with("success", "Curso registrado exitosamente en el historial.");
    }

    /**
     * Update a course record for the student.
     */
    public function update(Request $request, Student $student, Course $course)
    {
        $validated = $request->validate([
            "grade" => "nullable|integer|min:0|max:20",
            "status" => "required|in:aprobado,desaprobado",
        ]);

        $student->courses()->updateExistingPivot($course->id, [
            "grade" => $validated["grade"],
            "status" => $validated["status"],
        ]);

        return redirect()->route("students.courses.edit", $student->id)->with("success", "Historial de curso actualizado exitosamente.");
    }

    /**
     * Remove a course record from the student.
     */
    public function destroy(Student $student, Course $course)
    {
        $student->courses()->detach($course->id);

        return redirect()->route("students.courses.edit", $student->id)->with("success", "Registro de curso eliminado del historial.");
    }
}
