<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Career;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $careerId = $request->input("career_id");

        $query = Curriculum::query()->with("career");

        if ($careerId) {
            $query->where("career_id", $careerId);
        }

        $curriculums = $query->orderBy("year", "desc")->orderBy("name")->paginate(10)->withQueryString();
        $careers = Career::where("status", "activo")->orderBy("name")->get();

        return view("curriculums.index", compact("curriculums", "careers", "careerId"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::where("status", "activo")->orderBy("name")->get();
        return view("curriculums.create", compact("careers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "year" => "required|integer|min:1900|max:2100",
            "career_id" => "required|exists:careers,id",
        ]);

        Curriculum::create($validated);

        return redirect()->route("curriculums.index")->with("success", "Malla curricular creada exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum)
    {
        $curriculum->load(["career", "courses.career"]);

        // Group courses by period parsed from their academic code (e.g. CONT-201 -> period 2)
        $groupedCourses = $curriculum->courses->groupBy(function ($course) {
            if (preg_match('/-(\d)/', $course->code, $matches)) {
                return (int)$matches[1];
            }
            return 1; // Default fallback to period 1
        })->sortKeys();

        $romanPeriods = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
        ];

        return view("curriculums.show", compact("curriculum", "groupedCourses", "romanPeriods"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum)
    {
        $careers = Career::where("status", "activo")->orderBy("name")->get();
        return view("curriculums.edit", compact("curriculum", "careers"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curriculum $curriculum)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "year" => "required|integer|min:1900|max:2100",
            "career_id" => "required|exists:careers,id",
        ]);

        $curriculum->update($validated);

        return redirect()->route("curriculums.index")->with("success", "Malla curricular actualizada exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {
        $curriculum->delete();

        return redirect()->route("curriculums.index")->with("success", "Malla curricular eliminada exitosamente.");
    }
}
