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

        $registeredCourseIds = $student->courses->pluck("id");

        // Available courses to register: regular courses of student's curriculum map + update courses
        $availableCoursesQuery = \App\Models\Course::whereNotIn("id", $registeredCourseIds);

        $careerIds = $student->careers->pluck("id");
        $curriculums = \App\Models\Curriculum::whereIn('career_id', $careerIds)->get()->keyBy('id');

        if ($student->careers->isEmpty()) {
            $availableCourses = collect();
        } else {
            $availableCoursesQuery->where(function ($query) use ($student) {
                foreach ($student->careers as $career) {
                    $studentCurriculumId = $career->pivot->curriculum_id;
                    if ($studentCurriculumId) {
                        // Regular courses matching the curriculum
                        $query->orWhere(function ($q) use ($career, $studentCurriculumId) {
                            $q->where('career_id', $career->id)
                              ->where('is_actualizacion', false)
                              ->where('curriculum_id', $studentCurriculumId);
                        });
                    }
                    // Update courses for the career
                    $query->orWhere(function ($q) use ($career) {
                        $q->where('career_id', $career->id)
                          ->where('is_actualizacion', true);
                    });
                }
            });
            $availableCourses = $availableCoursesQuery->orderBy("name")->get();
        }

        return view("students.courses.edit", compact("student", "availableCourses", "editingCourse", "curriculums"));
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
