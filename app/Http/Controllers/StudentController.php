<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input("status");

        $query = Student::query()->with("careers");

        if ($status && $status !== "todos") {
            $query->where("status", $status);
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view("students.index", compact("students", "status"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = \App\Models\Career::where("status", "activo")->orderBy("name")->get();
        return view("students.create", compact("careers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "careers" => "nullable|array",
            "careers.*" => "exists:careers,id",
            "name" => "required|string|max:255",
            "document_number" => "required|string|max:50|unique:students,document_number",
            "email" => "nullable|email|max:255",
            "phone" => "nullable|string|max:50",
            "status" => "required|in:matriculado,egresado,retirado",
            "enrollment_date" => "required|date",
            "graduation_date" => "nullable|date|required_if:status,egresado",
        ]);

        $student = Student::create($validated);
        $student->careers()->sync($request->input("careers", []));

        return redirect()->route("students.index")->with("success", "Estudiante creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load("careers");
        return view("students.show", compact("student"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $careers = \App\Models\Career::where("status", "activo")->orderBy("name")->get();
        return view("students.edit", compact("student", "careers"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            "careers" => "nullable|array",
            "careers.*" => "exists:careers,id",
            "name" => "required|string|max:255",
            "document_number" => "required|string|max:50|unique:students,document_number," . $student->id,
            "email" => "nullable|email|max:255",
            "phone" => "nullable|string|max:50",
            "status" => "required|in:matriculado,egresado,retirado",
            "enrollment_date" => "required|date",
            "graduation_date" => "nullable|date|required_if:status,egresado",
        ]);

        $student->update($validated);
        $student->careers()->sync($request->input("careers", []));

        return redirect()->route("students.index")->with("success", "Estudiante actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route("students.index")->with("success", "Estudiante eliminado exitosamente.");
    }
}
