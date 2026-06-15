<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Career;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $careerId = $request->input("career_id");

        $query = Course::query()->with(["career", "curriculum"]);

        if ($careerId) {
            $query->where("career_id", $careerId);
        }

        $courses = $query->orderBy("code")->paginate(10)->withQueryString();
        $careers = Career::where("status", "activo")->orderBy("name")->get();

        return view("courses.index", compact("courses", "careers", "careerId"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::where("status", "activo")->orderBy("name")->get();
        $curriculums = \App\Models\Curriculum::orderBy("year", "desc")->orderBy("name")->get();
        return view("courses.create", compact("careers", "curriculums"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "code" => "required|string|max:50|unique:courses,code",
            "credits" => "required|integer|min:1|max:10",
            "hours" => "required|integer|min:0",
            "career_id" => "required|exists:careers,id",
            "curriculum_id" => "required|exists:curriculums,id",
            "is_actualizacion" => "boolean",
        ]);

        $validated["is_actualizacion"] = $request->has("is_actualizacion");

        Course::create($validated);

        return redirect()->route("courses.index")->with("success", "Curso creado exitosamente.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $careers = Career::where("status", "activo")->orderBy("name")->get();
        $curriculums = \App\Models\Curriculum::orderBy("year", "desc")->orderBy("name")->get();
        return view("courses.edit", compact("course", "careers", "curriculums"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "code" => "required|string|max:50|unique:courses,code," . $course->id,
            "credits" => "required|integer|min:1|max:10",
            "hours" => "required|integer|min:0",
            "career_id" => "required|exists:careers,id",
            "curriculum_id" => "required|exists:curriculums,id",
            "is_actualizacion" => "boolean",
        ]);

        $validated["is_actualizacion"] = $request->has("is_actualizacion");

        $course->update($validated);

        return redirect()->route("courses.index")->with("success", "Curso actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route("courses.index")->with("success", "Curso eliminado exitosamente.");
    }
}
