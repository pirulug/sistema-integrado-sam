<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Database\Seeder;

class CurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curriculum2020 = Curriculum::firstOrCreate(
            ["year" => "2020"],
            ["name" => "Malla Curricular 2020"]
        );

        $curriculum2019 = Curriculum::firstOrCreate(
            ["year" => "2019"],
            ["name" => "Malla Curricular 2019"]
        );

        // ==========================================
        // PLAN 2020 COURSES (42 Unidades Didácticas)
        // ==========================================
        $courses2020Data = [
            // Periodo I
            [
                "code" => "DPW-2020-I-01",
                "name" => "Diseño gráfico para la web",
                "period" => "I",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-I-02",
                "name" => "Maquetación web",
                "period" => "I",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-I-03",
                "name" => "Soporte para diseño web",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-I-04",
                "name" => "Marketing digital",
                "period" => "I",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-I-05",
                "name" => "Lógica matemática",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-I-06",
                "name" => "Fundamentos de informática y de la web",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-I-07",
                "name" => "Análisis de Interpretación de textos",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-I-08",
                "name" => "Ofimática",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo II
            [
                "code" => "DPW-2020-II-01",
                "name" => "Mapas de navegación",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-II-02",
                "name" => "Diseño web",
                "period" => "II",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-II-03",
                "name" => "Documentación de diseño web",
                "period" => "II",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2020-II-04",
                "name" => "Administración web",
                "period" => "II",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2020-II-05",
                "name" => "Animación de páginas web",
                "period" => "II",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-II-06",
                "name" => "Matemática para programadores",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-II-07",
                "name" => "Técnicas de comunicación",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-II-08",
                "name" => "Aplicaciones en internet",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo III
            [
                "code" => "DPW-2020-III-01",
                "name" => "Programación de componentes de software",
                "period" => "III",
                "credits" => 4,
                "hours" => 96,
            ],
            [
                "code" => "DPW-2020-III-02",
                "name" => "Análisis y diseño de sistemas de información",
                "period" => "III",
                "credits" => 4,
                "hours" => 96,
            ],
            [
                "code" => "DPW-2020-III-03",
                "name" => "Estándares de codificación",
                "period" => "III",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-III-04",
                "name" => "Diseño de base de datos",
                "period" => "III",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2020-III-05",
                "name" => "Metodología de programación",
                "period" => "III",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2020-III-06",
                "name" => "Lenguaje de consulta SQL",
                "period" => "III",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2020-III-07",
                "name" => "Inglés para la comunicación oral",
                "period" => "III",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo IV
            [
                "code" => "DPW-2020-IV-01",
                "name" => "Plantillas de estilos web",
                "period" => "IV",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-IV-02",
                "name" => "Metodología de desarrollo de software",
                "period" => "IV",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-IV-03",
                "name" => "Programación web",
                "period" => "IV",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2020-IV-04",
                "name" => "Gestión de contenidos",
                "period" => "IV",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2020-IV-05",
                "name" => "Administración de base de datos",
                "period" => "IV",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-IV-06",
                "name" => "Comprensión y redacción en inglés",
                "period" => "IV",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo V
            [
                "code" => "DPW-2020-V-01",
                "name" => "Servicios web",
                "period" => "V",
                "credits" => 5,
                "hours" => 128,
            ],
            [
                "code" => "DPW-2020-V-02",
                "name" => "Desarrollo de aplicaciones móviles",
                "period" => "V",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2020-V-03",
                "name" => "Métricas de software",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-V-04",
                "name" => "Prueba unitaria de software",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-V-05",
                "name" => "Solución de Problemas",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-V-06",
                "name" => "Comportamiento Ético",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-V-07",
                "name" => "Emprendimiento",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo VI
            [
                "code" => "DPW-2020-VI-01",
                "name" => "Gestión de aplicaciones web",
                "period" => "VI",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-VI-02",
                "name" => "Interacción con dispositivos móviles",
                "period" => "VI",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2020-VI-03",
                "name" => "Prueba de calidad de software",
                "period" => "VI",
                "credits" => 4,
                "hours" => 96,
            ],
            [
                "code" => "DPW-2020-VI-04",
                "name" => "Realidad aumentada",
                "period" => "VI",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2020-VI-05",
                "name" => "Mantenimiento de software",
                "period" => "VI",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2020-VI-06",
                "name" => "Innovación",
                "period" => "VI",
                "credits" => 3,
                "hours" => 64,
            ],
        ];

        $course2020Ids = [];
        foreach ($courses2020Data as $courseItem) {
            $course = Course::updateOrCreate(
                ["code" => $courseItem["code"]],
                [
                    "name" => $courseItem["name"],
                    "period" => $courseItem["period"],
                    "credits" => $courseItem["credits"],
                    "hours" => $courseItem["hours"],
                ]
            );

            $course2020Ids[] = $course->id;
        }

        $curriculum2020->courses()->syncWithoutDetaching($course2020Ids);

        // ==========================================
        // PLAN 2019 COURSES (42 Unidades Didácticas)
        // ==========================================
        $courses2019Data = [
            // Periodo I
            [
                "code" => "DPW-2019-I-01",
                "name" => "Diseño gráfico para la web",
                "period" => "I",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-I-02",
                "name" => "Maquetación Web",
                "period" => "I",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-I-03",
                "name" => "Soporte para diseño web",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-I-04",
                "name" => "Metodología de la programación",
                "period" => "I",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-I-05",
                "name" => "Lógica Matemática",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-I-06",
                "name" => "Informática",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-I-07",
                "name" => "Comunicación Efectiva I",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-I-08",
                "name" => "Comunicación Idioma extranjero",
                "period" => "I",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo II
            [
                "code" => "DPW-2019-II-01",
                "name" => "Mapas de navegación",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-II-02",
                "name" => "Plantillas de estilos web",
                "period" => "II",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-II-03",
                "name" => "Diseño Web",
                "period" => "II",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-II-04",
                "name" => "Documentación de Diseño Web",
                "period" => "II",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2019-II-05",
                "name" => "Administración Web",
                "period" => "II",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2019-II-06",
                "name" => "Matemática para programadores",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-II-07",
                "name" => "Comunicación Efectiva II",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-II-08",
                "name" => "Herramientas informáticas básicas",
                "period" => "II",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo III
            [
                "code" => "DPW-2019-III-01",
                "name" => "Programación de componentes de Software",
                "period" => "III",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2019-III-02",
                "name" => "Análisis y diseño de SI",
                "period" => "III",
                "credits" => 4,
                "hours" => 96,
            ],
            [
                "code" => "DPW-2019-III-03",
                "name" => "Estándares de codificación",
                "period" => "III",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-III-04",
                "name" => "Diseño de base de datos",
                "period" => "III",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2019-III-05",
                "name" => "Lenguaje consulta SQL",
                "period" => "III",
                "credits" => 3,
                "hours" => 64,
            ],
            [
                "code" => "DPW-2019-III-06",
                "name" => "Inglés Técnico",
                "period" => "III",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-III-07",
                "name" => "Herramientas informáticas avanzadas",
                "period" => "III",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo IV
            [
                "code" => "DPW-2019-IV-01",
                "name" => "Prueba unitaria de Software",
                "period" => "IV",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-IV-02",
                "name" => "Animación de páginas Web",
                "period" => "IV",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-IV-03",
                "name" => "Metodología de desarrollo de software",
                "period" => "IV",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-IV-04",
                "name" => "Programación Web",
                "period" => "IV",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2019-IV-05",
                "name" => "Web Services y SOAP",
                "period" => "IV",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2019-IV-06",
                "name" => "Administración de base de datos",
                "period" => "IV",
                "credits" => 3,
                "hours" => 80,
            ],

            // Periodo V
            [
                "code" => "DPW-2019-V-01",
                "name" => "Marketing digital",
                "period" => "V",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-V-02",
                "name" => "Gestión de contenidos",
                "period" => "V",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2019-V-03",
                "name" => "Desarrollo de aplicaciones móviles",
                "period" => "V",
                "credits" => 4,
                "hours" => 96,
            ],
            [
                "code" => "DPW-2019-V-04",
                "name" => "Métricas de Software",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-V-05",
                "name" => "Innovación I",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-V-06",
                "name" => "Ética y Ciudadanía",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-V-07",
                "name" => "Emprendimiento",
                "period" => "V",
                "credits" => 2,
                "hours" => 48,
            ],

            // Periodo VI
            [
                "code" => "DPW-2019-VI-01",
                "name" => "Gestión de aplicaciones Web",
                "period" => "VI",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-VI-02",
                "name" => "Interacción con dispositivos móviles",
                "period" => "VI",
                "credits" => 4,
                "hours" => 112,
            ],
            [
                "code" => "DPW-2019-VI-03",
                "name" => "Pruebas de calidad de software",
                "period" => "VI",
                "credits" => 4,
                "hours" => 96,
            ],
            [
                "code" => "DPW-2019-VI-04",
                "name" => "Realidad aumentada",
                "period" => "VI",
                "credits" => 3,
                "hours" => 80,
            ],
            [
                "code" => "DPW-2019-VI-05",
                "name" => "Mantenimiento de software",
                "period" => "VI",
                "credits" => 2,
                "hours" => 48,
            ],
            [
                "code" => "DPW-2019-VI-06",
                "name" => "Innovación II",
                "period" => "VI",
                "credits" => 3,
                "hours" => 64,
            ],
        ];

        $course2019Ids = [];
        foreach ($courses2019Data as $courseItem) {
            $course = Course::updateOrCreate(
                ["code" => $courseItem["code"]],
                [
                    "name" => $courseItem["name"],
                    "period" => $courseItem["period"],
                    "credits" => $courseItem["credits"],
                    "hours" => $courseItem["hours"],
                ]
            );

            $course2019Ids[] = $course->id;
        }

        $curriculum2019->courses()->syncWithoutDetaching($course2019Ids);
    }
}
