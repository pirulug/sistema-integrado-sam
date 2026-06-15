<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentGraduationController extends Controller
{
    /**
     * Show the page to edit student graduation/titulación.
     */
    public function edit(Student $student)
    {
        $student->load(["careers.courses", "courses", "efsrtRecords", "job"]);

        $careersData = [];

        foreach ($student->careers as $career) {
            // Calculate pending courses for this specific career
            $careerCourses = $career->courses;
            $passedCourseIds = $student->courses
                ->filter(fn($c) => $c->pivot->status === 'aprobado')
                ->pluck('id')
                ->toArray();
            $pendingCourses = $careerCourses->filter(fn($c) => !in_array($c->id, $passedCourseIds));
            $pendingCount = $pendingCourses->count();

            // Calculate incomplete EFSRT records for this specific career
            $careerEfsrt = $student->efsrtRecords->where('career_id', $career->id);
            $incompleteEfsrt = $careerEfsrt->filter(fn($e) => $e->status !== 'aprobado');
            $efsrtComplete = ($careerEfsrt->where('status', 'aprobado')->count() === 3);

            $isEligible = ($pendingCount === 0 && $efsrtComplete);

            $careersData[] = [
                'career' => $career,
                'is_eligible' => $isEligible,
                'pending_courses' => $pendingCourses,
                'incomplete_efsrt' => $incompleteEfsrt,
                'graduation_year' => $career->pivot->graduation_year,
                'title_date' => $career->pivot->title_date,
            ];
        }

        return view("students.graduation.edit", compact("student", "careersData"));
    }

    /**
     * Update student graduation/titulación info.
     */
    public function update(Request $request, Student $student)
    {
        $student->load(["careers.courses", "courses", "efsrtRecords"]);

        // Validate graduation years, title dates and job information
        $request->validate([
            "career_graduation_years" => "nullable|array",
            "career_graduation_years.*" => "nullable|integer|min:1900|max:2100",
            "career_title_dates" => "nullable|array",
            "career_title_dates.*" => "nullable|date",
            "current_job" => "nullable|string|max:255",
            "workplace" => "nullable|string|max:255",
            "is_related" => "nullable|boolean",
        ]);

        $graduationYears = $request->input("career_graduation_years", []);
        $titleDates = $request->input("career_title_dates", []);
        $syncData = [];
        $isTitled = false;

        foreach ($student->careers as $career) {
            $submittedYear = $graduationYears[$career->id] ?? null;
            $submittedTitleDate = $titleDates[$career->id] ?? null;

            if (!empty($submittedYear) || !empty($submittedTitleDate)) {
                // Calculate pending courses
                $careerCourses = $career->courses;
                $passedCourseIds = $student->courses
                    ->filter(fn($c) => $c->pivot->status === 'aprobado')
                    ->pluck('id')
                    ->toArray();
                $pendingCount = $careerCourses->filter(fn($c) => !in_array($c->id, $passedCourseIds))->count();

                // Calculate EFSRT
                $careerEfsrt = $student->efsrtRecords->where('career_id', $career->id);
                $efsrtComplete = ($careerEfsrt->where('status', 'aprobado')->count() === 3);

                // Enforce strict business logic validation
                if ($pendingCount > 0 || !$efsrtComplete) {
                    return back()->withErrors([
                        "career_graduation_years.{$career->id}" => "La carrera {$career->name} no es elegible para titulación debido a requisitos pendientes."
                    ])->withInput();
                }

                $isTitled = true;
            }

            $syncData[$career->id] = [
                "graduation_year" => !empty($submittedYear) ? $submittedYear : null,
                "title_date" => !empty($submittedTitleDate) ? $submittedTitleDate : null,
                "shift" => $career->pivot->shift,
                "entry_year" => $career->pivot->entry_year,
            ];
        }

        // Save pivot graduation years and title dates
        foreach ($syncData as $careerId => $pivotData) {
            $student->careers()->updateExistingPivot($careerId, $pivotData);
        }

        // Set student-wide graduation year and date to the first career's graduation year and title date
        $firstCareer = $student->careers->first();
        $studentGraduationYear = null;
        $studentGraduationDate = null;
        if ($firstCareer) {
            $studentGraduationYear = $graduationYears[$firstCareer->id] ?? null;
            $studentGraduationDate = $titleDates[$firstCareer->id] ?? null;
        }

        $studentUpdateData = [
            "graduation_year" => $studentGraduationYear,
            "graduation_date" => $studentGraduationDate,
        ];

        // Automatically set status to egresado if titled
        if ($isTitled) {
            $studentUpdateData["status"] = "egresado";
        }
        $student->update($studentUpdateData);

        // Save job info if titled, otherwise delete
        if ($isTitled) {
            $student->job()->updateOrCreate([], [
                "current_job" => $request->input("current_job"),
                "workplace" => $request->input("workplace"),
                "is_related" => $request->boolean("is_related"),
            ]);
        } else {
            $student->job()->delete();
        }

        return redirect()->route("students.show", $student->id)->with("success", "Información de titulación actualizada exitosamente.");
    }
}
