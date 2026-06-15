<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Career;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('csv/sam_unidades.csv');
        if (!file_exists($csvFile)) {
            $this->command->error("El archivo CSV no existe en la ruta: {$csvFile}");
            return;
        }

        $file = fopen($csvFile, 'r');
        // Omitir cabecera
        fgetcsv($file);

        $romansMap = [
            'I' => 1,
            'II' => 2,
            'III' => 3,
            'IV' => 4,
            'V' => 5,
            'VI' => 6,
        ];

        $counters = [];
        $careers = Career::all()->keyBy('name');

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 5) {
                continue;
            }

            $careerName = trim($row[0]);
            $period = trim($row[1]);
            $courseName = trim($row[2]);
            $credits = (int)trim($row[3]);
            $hours = (int)trim($row[4]);

            // Buscar carrera por nombre exacto en mayúsculas
            $career = $careers->get(strtoupper($careerName));
            if (!$career) {
                $this->command->warn("Carrera no encontrada para el curso: {$courseName} (Carrera: {$careerName})");
                continue;
            }

            $careerCode = $career->code;
            $periodNum = $romansMap[$period] ?? 1;
            $key = $careerCode . '_' . $periodNum;

            $counters[$key] = ($counters[$key] ?? 0) + 1;
            $sequence = str_pad($counters[$key], 2, '0', STR_PAD_LEFT);
            $code = "{$careerCode}-{$periodNum}{$sequence}";

            Course::create([
                'name' => $courseName,
                'code' => $code,
                'credits' => $credits,
                'hours' => $hours,
                'career_id' => $career->id,
            ]);
        }

        fclose($file);
    }
}
