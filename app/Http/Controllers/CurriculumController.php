<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $curriculums = Curriculum::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%");
            })
            ->orderBy('year', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('curriculums.index', compact('curriculums', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('curriculums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|string|max:4',
        ]);

        Curriculum::create($validated);

        return redirect()->route('curriculums.index')
            ->with('success', 'Malla curricular creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum): View
    {
        $curriculum->load(['courses', 'efsrts']);
        return view('curriculums.show', compact('curriculum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum): View
    {
        return view('curriculums.edit', compact('curriculum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curriculum $curriculum): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|string|max:4',
        ]);

        $curriculum->update($validated);

        return redirect()->route('curriculums.index')
            ->with('success', 'Malla curricular actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum): RedirectResponse
    {
        $curriculum->delete();

        return redirect()->route('curriculums.index')
            ->with('success', 'Malla curricular eliminada exitosamente.');
    }
}
