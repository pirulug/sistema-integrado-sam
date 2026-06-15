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
        $careerAA = Career::where("code", "AA")->first();
        $careerCONT = Career::where("code", "CONT")->first();
        $careerDPW = Career::where("code", "DPW")->first();
        $careerET = Career::where("code", "ET")->first();

        $courses = [];

        if ($careerAA) {
            $courses[] = ["name" => "Documentación Comercial y Archivo", "code" => "AA-101", "credits" => 4, "career_id" => $careerAA->id];
            $courses[] = ["name" => "Digitación de Textos", "code" => "AA-102", "credits" => 3, "career_id" => $careerAA->id];
            $courses[] = ["name" => "Atención al Cliente y Protocolo", "code" => "AA-103", "credits" => 3, "career_id" => $careerAA->id];
        }

        if ($careerCONT) {
            $courses[] = ["name" => "Contabilidad General I", "code" => "CONT-101", "credits" => 5, "career_id" => $careerCONT->id];
            $courses[] = ["name" => "Documentación Comercial", "code" => "CONT-102", "credits" => 3, "career_id" => $careerCONT->id];
            $courses[] = ["name" => "Tributación I", "code" => "CONT-103", "credits" => 4, "career_id" => $careerCONT->id];
        }

        if ($careerDPW) {
            $courses[] = ["name" => "Fundamentos de Programación", "code" => "DPW-101", "credits" => 4, "career_id" => $careerDPW->id];
            $courses[] = ["name" => "Diseño Web Frontend", "code" => "DPW-102", "credits" => 4, "career_id" => $careerDPW->id];
            $courses[] = ["name" => "Bases de Datos Relacionales", "code" => "DPW-103", "credits" => 5, "career_id" => $careerDPW->id];
        }

        if ($careerET) {
            $courses[] = ["name" => "Anatomía Fisiología y Patología", "code" => "ET-101", "credits" => 5, "career_id" => $careerET->id];
            $courses[] = ["name" => "Primeros Auxilios", "code" => "ET-102", "credits" => 3, "career_id" => $careerET->id];
            $courses[] = ["name" => "Administración de Medicamentos", "code" => "ET-103", "credits" => 4, "career_id" => $careerET->id];
        }

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
