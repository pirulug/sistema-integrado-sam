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
        $search = $request->input("search");
        $curriculumId = $request->input("curriculum_id");

        $curriculums = Curriculum::orderBy("year", "desc")->get();

        $efsrts = Efsrt::query()
            ->with("curriculums")
            ->when($curriculumId, function ($query, $curriculumId) {
                $query->whereHas("curriculums", function ($q) use ($curriculumId) {
                    $q->where("curriculums.id", $curriculumId);
                });
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where("module", "like", "%{$search}%")
                        ->orWhere("module_name", "like", "%{$search}%")
                        ->orWhere("period", "like", "%{$search}%")
                        ->orWhere("competency", "like", "%{$search}%");
                });
            })
            ->orderBy("module")
            ->paginate(15)
            ->withQueryString();

        return view("efsrts.index", compact("efsrts", "search", "curriculums", "curriculumId"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $curriculums = Curriculum::all();
        return view("efsrts.create", compact("curriculums"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "module" => "required|string|max:50",
            "module_name" => "nullable|string|max:255",
            "competency" => "nullable|string",
            "period" => "nullable|string|max:10",
            "hours" => "nullable|integer|min:0",
            "credits" => "nullable|integer|min:0",
            "practice_lines" => "nullable",
            "curriculums" => "nullable|array",
            "curriculums.*" => "exists:curriculums,id",
        ]);

        if (isset($validated["practice_lines"]) && is_string($validated["practice_lines"])) {
            $decoded = json_decode($validated["practice_lines"], true);
            $validated["practice_lines"] = $decoded !== null ? $decoded : $validated["practice_lines"];
        }

        $efsrt = Efsrt::create($validated);

        if ($request->has("curriculums")) {
            $efsrt->curriculums()->sync($request->input("curriculums"));
        }

        return redirect()->route("efsrts.index")
            ->with("success", "Módulo EFSRT creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Efsrt $efsrt): View
    {
        $efsrt->load("curriculums");
        return view("efsrts.show", compact("efsrt"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Efsrt $efsrt): View
    {
        $curriculums = Curriculum::all();
        $efsrt->load("curriculums");
        return view("efsrts.edit", compact("efsrt", "curriculums"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Efsrt $efsrt): RedirectResponse
    {
        $validated = $request->validate([
            "module" => "required|string|max:50",
            "module_name" => "nullable|string|max:255",
            "competency" => "nullable|string",
            "period" => "nullable|string|max:10",
            "hours" => "nullable|integer|min:0",
            "credits" => "nullable|integer|min:0",
            "practice_lines" => "nullable",
            "curriculums" => "nullable|array",
            "curriculums.*" => "exists:curriculums,id",
        ]);

        if (isset($validated["practice_lines"]) && is_string($validated["practice_lines"])) {
            $decoded = json_decode($validated["practice_lines"], true);
            $validated["practice_lines"] = $decoded !== null ? $decoded : $validated["practice_lines"];
        }

        $efsrt->update($validated);

        $efsrt->curriculums()->sync($request->input("curriculums", []));

        return redirect()->route("efsrts.index")
            ->with("success", "Módulo EFSRT actualizado exitosamente.");
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
