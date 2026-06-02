<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input("status");

        $query = Teacher::query();

        if ($status && $status !== "todos") {
            $query->where("status", $status);
        }

        $teachers = $query->latest()->paginate(10)->withQueryString();

        return view("teachers.index", compact("teachers", "status"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("teachers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "document_number" => "required|string|max:50|unique:teachers,document_number",
            "email" => "nullable|email|max:255|unique:teachers,email",
            "phone" => "nullable|string|max:50",
            "specialty" => "required|string|max:255",
            "status" => "required|in:activo,inactivo",
            "hire_date" => "required|date",
        ]);

        Teacher::create($validated);

        return redirect()->route("teachers.index")->with("success", "Profesor creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view("teachers.show", compact("teacher"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view("teachers.edit", compact("teacher"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "document_number" => "required|string|max:50|unique:teachers,document_number," . $teacher->id,
            "email" => "nullable|email|max:255|unique:teachers,email," . $teacher->id,
            "phone" => "nullable|string|max:50",
            "specialty" => "required|string|max:255",
            "status" => "required|in:activo,inactivo",
            "hire_date" => "required|date",
        ]);

        $teacher->update($validated);

        return redirect()->route("teachers.index")->with("success", "Profesor actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route("teachers.index")->with("success", "Profesor eliminado exitosamente.");
    }
}
