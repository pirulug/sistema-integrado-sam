<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('dni', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('paternal_last_name', 'like', "%{$search}%")
                    ->orWhere('maternal_last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('study_program', 'like', "%{$search}%");
            })
            ->orderBy('paternal_last_name')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $curriculums = Curriculum::all();
        return view('students.create', compact('curriculums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dni' => 'required|string|unique:students,dni|max:20',
            'student_code' => 'required|string|unique:students,student_code|max:50',
            'study_program' => 'required|string|max:255',
            'paternal_last_name' => 'required|string|max:100',
            'maternal_last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'personal_email' => 'nullable|email|max:255',
            'institutional_email' => 'required|email|unique:students,institutional_email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'admission_date' => 'required|date',
            'graduation_date' => 'nullable|date|after_or_equal:admission_date',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'shift' => 'nullable|string|max:50',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Estudiante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $curriculums = Curriculum::all();
        return view('students.edit', compact('student', 'curriculums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20|unique:students,dni,' . $student->id,
            'student_code' => 'required|string|max:50|unique:students,student_code,' . $student->id,
            'study_program' => 'required|string|max:255',
            'paternal_last_name' => 'required|string|max:100',
            'maternal_last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'personal_email' => 'nullable|email|max:255',
            'institutional_email' => 'required|email|max:255|unique:students,institutional_email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'admission_date' => 'required|date',
            'graduation_date' => 'nullable|date|after_or_equal:admission_date',
            'curriculum_id' => 'nullable|exists:curriculums,id',
            'shift' => 'nullable|string|max:50',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Estudiante eliminado exitosamente.');
    }
}
