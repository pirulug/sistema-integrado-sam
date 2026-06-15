<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create curriculums table
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year');
            $table->foreignId('career_id')->constrained('careers')->onDelete('cascade');
            $table->timestamps();
        });

        // 2. Add curriculum_id columns
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('curriculum_id')->nullable()->after('career_id')->constrained('curriculums')->onDelete('cascade');
        });

        Schema::table('career_student', function (Blueprint $table) {
            $table->foreignId('curriculum_id')->nullable()->after('title_date')->constrained('curriculums')->onDelete('set null');
        });

        // 3. Migrate existing data
        // Fetch unique (career_id, curriculum) combinations from courses table
        if (Schema::hasColumn('courses', 'curriculum')) {
            $courseMallas = DB::table('courses')
                ->select('career_id', 'curriculum')
                ->groupBy('career_id', 'curriculum')
                ->get();

            foreach ($courseMallas as $malla) {
                $career = DB::table('careers')->where('id', $malla->career_id)->first();
                $careerName = $career ? $career->name : '';
                $year = is_numeric($malla->curriculum) ? (int)$malla->curriculum : 2024;
                
                // Insert new curriculum record
                $curriculumId = DB::table('curriculums')->insertGetId([
                    'name' => "Malla " . $malla->curriculum . ($careerName ? " - " . $careerName : ""),
                    'year' => $year,
                    'career_id' => $malla->career_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Map courses to this curriculum
                DB::table('courses')
                    ->where('career_id', $malla->career_id)
                    ->where('curriculum', $malla->curriculum)
                    ->update(['curriculum_id' => $curriculumId]);

                // Map career_student pivot records to this curriculum
                if (Schema::hasColumn('career_student', 'curriculum')) {
                    DB::table('career_student')
                        ->where('career_id', $malla->career_id)
                        ->where('curriculum', $malla->curriculum)
                        ->update(['curriculum_id' => $curriculumId]);
                }
            }
        }

        // Fill remaining empty career_student curriculum_ids using a fallback matching the career default
        $pivotRecords = DB::table('career_student')->whereNull('curriculum_id')->get();
        foreach ($pivotRecords as $record) {
            // Find any curriculum for this career, preferably a 2024 one
            $fallbackCurr = DB::table('curriculums')
                ->where('career_id', $record->career_id)
                ->orderByDesc('year')
                ->first();

            if (!$fallbackCurr) {
                // Create a default one if none exists
                $career = DB::table('careers')->where('id', $record->career_id)->first();
                $careerName = $career ? $career->name : '';
                $fallbackCurrId = DB::table('curriculums')->insertGetId([
                    'name' => "Malla 2024" . ($careerName ? " - " . $careerName : ""),
                    'year' => 2024,
                    'career_id' => $record->career_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $fallbackCurrId = $fallbackCurr->id;
            }

            DB::table('career_student')
                ->where('id', $record->id)
                ->update(['curriculum_id' => $fallbackCurrId]);
        }

        // 4. Drop old curriculum string columns
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('curriculum');
        });

        Schema::table('career_student', function (Blueprint $table) {
            $table->dropColumn('curriculum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back string columns
        Schema::table('courses', function (Blueprint $table) {
            $table->string('curriculum')->default('2024');
        });

        Schema::table('career_student', function (Blueprint $table) {
            $table->string('curriculum')->default('2024');
        });

        // Restore data
        $curriculums = DB::table('curriculums')->get();
        foreach ($curriculums as $curr) {
            DB::table('courses')
                ->where('curriculum_id', $curr->id)
                ->update(['curriculum' => (string)$curr->year]);

            DB::table('career_student')
                ->where('curriculum_id', $curr->id)
                ->update(['curriculum' => (string)$curr->year]);
        }

        // Drop foreign keys and new columns
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['curriculum_id']);
            $table->dropColumn('curriculum_id');
        });

        Schema::table('career_student', function (Blueprint $table) {
            $table->dropForeign(['curriculum_id']);
            $table->dropColumn('curriculum_id');
        });

        Schema::dropIfExists('curriculums');
    }
};
