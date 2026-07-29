<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $courses = Course::query()
            ->when($search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('period', 'like', "%{$search}%");
            })
            ->orderBy('period')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('courses.index', compact('courses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $curriculums = Curriculum::all();
        return view('courses.create', compact('curriculums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code|max:50',
            'name' => 'required|string|max:255',
            'period' => 'nullable|string|max:50',
            'credits' => 'required|integer|min:0',
            'hours' => 'required|integer|min:0',
            'curriculums' => 'nullable|array',
            'curriculums.*' => 'exists:curriculums,id',
        ]);

        $course = Course::create($validated);

        if ($request->has('curriculums')) {
            $course->curriculums()->sync($request->input('curriculums'));
        }

        return redirect()->route('courses.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): View
    {
        $course->load('curriculums');
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        $curriculums = Curriculum::all();
        $course->load('curriculums');
        return view('courses.edit', compact('course', 'curriculums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'period' => 'nullable|string|max:50',
            'credits' => 'required|integer|min:0',
            'hours' => 'required|integer|min:0',
            'curriculums' => 'nullable|array',
            'curriculums.*' => 'exists:curriculums,id',
        ]);

        $course->update($validated);

        $course->curriculums()->sync($request->input('curriculums', []));

        return redirect()->route('courses.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }
}
