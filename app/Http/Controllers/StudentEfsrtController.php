<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\EfsrtRecord;
use Illuminate\Http\Request;

class StudentEfsrtController extends Controller
{
    /**
     * Show the form for editing the student's EFSRT records.
     */
    public function edit(Student $student)
    {
        $student->load('efsrtRecords.career');
        return view("students.efsrt.edit", compact("student"));
    }

    /**
     * Update all student's EFSRT records.
     */
    public function updateAll(Request $request, Student $student)
    {
        $validated = $request->validate([
            "efsrt" => "required|array",
            "efsrt.*.company" => "nullable|string|max:255",
            "efsrt.*.hours" => "nullable|integer|min:0",
            "efsrt.*.grade" => "nullable|integer|min:0|max:20",
            "efsrt.*.status" => "required|in:pendiente,aprobado,desaprobado",
        ]);

        foreach ($validated["efsrt"] as $efsrtId => $efsrtData) {
            $efsrt = $student->efsrtRecords()->find($efsrtId);
            if ($efsrt) {
                $efsrt->update([
                    "company" => $efsrtData["company"] ?? null,
                    "hours" => $efsrtData["hours"] ?? null,
                    "grade" => $efsrtData["grade"] ?? null,
                    "status" => $efsrtData["status"] ?? "pendiente",
                ]);
            }
        }

        return redirect()->route("students.show", $student->id)->with("success", "Módulos EFSRT actualizados exitosamente.");
    }

    /**
     * Update the student's EFSRT record.
     */
    public function update(Request $request, Student $student, EfsrtRecord $efsrt)
    {
        // Ensure the record belongs to the student
        if ($efsrt->student_id !== $student->id) {
            abort(403, "Acción no autorizada.");
        }

        $validated = $request->validate([
            "grade" => "nullable|integer|min:0|max:20",
            "hours" => "nullable|integer|min:0",
            "company" => "nullable|string|max:255",
            "status" => "required|in:pendiente,aprobado,desaprobado",
        ]);

        $efsrt->update($validated);

        return redirect()->route("students.show", $student->id)->with("success", "Módulo EFSRT actualizado exitosamente.");
    }

    /**
     * Batch update the student's EFSRT records status (approved/pending).
     */
    public function updateBatch(Request $request, Student $student)
    {
        $validated = $request->validate([
            "approved_modules" => "nullable|array",
            "approved_modules.*" => "exists:efsrt_records,id",
        ]);

        $approvedModules = $request->input("approved_modules", []);

        foreach ($student->efsrtRecords as $efsrt) {
            $isApproved = in_array($efsrt->id, $approvedModules);
            $efsrt->update([
                "status" => $isApproved ? "aprobado" : "pendiente",
            ]);
        }

        return redirect()->route("students.show", $student->id)->with("success", "Módulos EFSRT actualizados exitosamente.");
    }
}
