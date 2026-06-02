<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input("status");

        $query = Career::query();

        if ($status && $status !== "todos") {
            $query->where("status", $status);
        }

        $careers = $query->latest()->paginate(10)->withQueryString();

        return view("careers.index", compact("careers", "status"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("careers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255|unique:careers,name",
            "code" => "nullable|string|max:50|unique:careers,code",
            "description" => "nullable|string",
            "status" => "required|in:activo,inactivo",
        ]);

        Career::create($validated);

        return redirect()->route("careers.index")->with("success", "Programa de estudio creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career)
    {
        $students = $career->students()->latest()->paginate(10, ["*"], "students_page")->withQueryString();
        $teachers = $career->teachers()->latest()->paginate(10, ["*"], "teachers_page")->withQueryString();
        return view("careers.show", compact("career", "students", "teachers"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $career)
    {
        return view("careers.edit", compact("career"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $career)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255|unique:careers,name," . $career->id,
            "code" => "nullable|string|max:50|unique:careers,code," . $career->id,
            "description" => "nullable|string",
            "status" => "required|in:activo,inactivo",
        ]);

        $career->update($validated);

        return redirect()->route("careers.index")->with("success", "Programa de estudio actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();

        return redirect()->route("careers.index")->with("success", "Programa de estudio eliminado exitosamente.");
    }
}
