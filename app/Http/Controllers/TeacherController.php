<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $teachers = Teacher::query()
            ->when($search, function ($query, $search) {
                $query->where('dni', 'like', "%{$search}%")
                    ->orWhere('teacher_code', 'like', "%{$search}%")
                    ->orWhere('paternal_last_name', 'like', "%{$search}%")
                    ->orWhere('maternal_last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%");
            })
            ->orderBy('paternal_last_name')
            ->paginate(10)
            ->withQueryString();

        return view('teachers.index', compact('teachers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dni' => 'required|string|unique:teachers,dni|max:20',
            'teacher_code' => 'required|string|unique:teachers,teacher_code|max:50',
            'paternal_last_name' => 'required|string|max:100',
            'maternal_last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'personal_email' => 'nullable|email|max:255',
            'institutional_email' => 'required|email|unique:teachers,institutional_email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
        ]);

        Teacher::create($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Profesor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher): View
    {
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher): View
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20|unique:teachers,dni,' . $teacher->id,
            'teacher_code' => 'required|string|max:50|unique:teachers,teacher_code,' . $teacher->id,
            'paternal_last_name' => 'required|string|max:100',
            'maternal_last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'personal_email' => 'nullable|email|max:255',
            'institutional_email' => 'required|email|max:255|unique:teachers,institutional_email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Profesor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Profesor eliminado exitosamente.');
    }
}
