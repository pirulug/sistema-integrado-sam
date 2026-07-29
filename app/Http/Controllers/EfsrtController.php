<?php

namespace App\Http\Controllers;

use App\Models\Efsrt;
use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EfsrtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $efsrts = Efsrt::query()
            ->when($search, function ($query, $search) {
                $query->where('module', 'like', "%{$search}%")
                    ->orWhere('module_name', 'like', "%{$search}%");
            })
            ->orderBy('module')
            ->paginate(10)
            ->withQueryString();

        return view('efsrts.index', compact('efsrts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $curriculums = Curriculum::all();
        return view('efsrts.create', compact('curriculums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'module' => 'required|string|max:50',
            'module_name' => 'nullable|string|max:255',
            'curriculums' => 'nullable|array',
            'curriculums.*' => 'exists:curriculums,id',
        ]);

        $efsrt = Efsrt::create($validated);

        if ($request->has('curriculums')) {
            $efsrt->curriculums()->sync($request->input('curriculums'));
        }

        return redirect()->route('efsrts.index')
            ->with('success', 'Módulo EFSRT creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Efsrt $efsrt): View
    {
        $efsrt->load('curriculums');
        return view('efsrts.show', compact('efsrt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Efsrt $efsrt): View
    {
        $curriculums = Curriculum::all();
        $efsrt->load('curriculums');
        return view('efsrts.edit', compact('efsrt', 'curriculums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Efsrt $efsrt): RedirectResponse
    {
        $validated = $request->validate([
            'module' => 'required|string|max:50',
            'module_name' => 'nullable|string|max:255',
            'curriculums' => 'nullable|array',
            'curriculums.*' => 'exists:curriculums,id',
        ]);

        $efsrt->update($validated);

        $efsrt->curriculums()->sync($request->input('curriculums', []));

        return redirect()->route('efsrts.index')
            ->with('success', 'Módulo EFSRT actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Efsrt $efsrt): RedirectResponse
    {
        $efsrt->delete();

        return redirect()->route('efsrts.index')
            ->with('success', 'Módulo EFSRT eliminado exitosamente.');
    }
}
