<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $careers = [
            [
                "name" => "ASISTENCIA ADMINISTRATIVA",
                "code" => "AA",
                "description" => "Programa de estudio de Asistencia Administrativa",
                "status" => "activo",
                "shifts" => ["Mañana", "Noche"],
            ],
            [
                "name" => "CONTABILIDAD",
                "code" => "CONT",
                "description" => "Programa de estudio de Contabilidad",
                "status" => "activo",
                "shifts" => ["Noche"],
            ],
            [
                "name" => "DISEÑO Y PROGRAMACIÓN WEB",
                "code" => "DPW",
                "description" => "Programa de estudio de Diseño y Programación Web",
                "status" => "activo",
                "shifts" => ["Mañana", "Tarde", "Noche"],
            ],
            [
                "name" => "ENFERMERÍA TÉCNICA",
                "code" => "ET",
                "description" => "Programa de estudio de Enfermería Técnica",
                "status" => "activo",
                "shifts" => ["Mañana", "Tarde"],
            ],
            [
                "name" => "FARMACIA TÉCNICA",
                "code" => "FT",
                "description" => "Programa de estudio de Farmacia Técnica",
                "status" => "activo",
                "shifts" => ["Mañana", "Tarde"],
            ],
            [
                "name" => "INDUSTRIAS ALIMENTARIAS",
                "code" => "IA",
                "description" => "Programa de estudio de Industrias Alimentarias",
                "status" => "activo",
                "shifts" => ["Mañana"],
            ],
            [
                "name" => "MECÁNICA DE PRODUCCIÓN INDUSTRIAL",
                "code" => "MPI",
                "description" => "Programa de estudio de Mecánica de Producción Industrial",
                "status" => "activo",
                "shifts" => ["Tarde", "Noche"],
            ],
            [
                "name" => "PRODUCCIÓN AGROPECUARIA",
                "code" => "PA",
                "description" => "Programa de estudio de Producción Agropecuaria",
                "status" => "activo",
                "shifts" => ["Mañana"],
            ],
        ];

        foreach ($careers as $career) {
            Career::create($career);
        }
    }
}
