<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use App\Models\Efsrt;
use App\Models\Student;
use Illuminate\Database\Seeder;

class EfsrtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // EFSRT Modulos Formativos Plan 2020
        $efsrt2020_1 = Efsrt::updateOrCreate(
            [
                "module" => "Módulo I",
                "period" => "II",
            ],
            [
                "module_name" => "Diseño y elaboración de páginas web",
                "competency" => "Diseña la presentación, animación, organización y navegación de los contenidos y servicios web, de acuerdo a las demandas del negocio, buenas prácticas de diseño, técnicas de diseño web, usabilidad y experiencia del usuario objetivo.",
                "hours" => 96,
                "credits" => 3,
                "practice_lines" => [
                    [
                        "line" => "Diseño y creación de páginas web.",
                        "activities" => [
                            "Diseña páginas web",
                            "Realiza la maquetación de las páginas web",
                            "Elabora animaciones a las secciones de una página web"
                        ]
                    ],
                    [
                        "line" => "Gestión y documentación de sitios web.",
                        "activities" => [
                            "Realiza mantenimiento del sitio web",
                            "Publica contenidos a sitios web",
                            "Elabora la documentación y manuales de sitios web.",
                            "Administra y gestiona redes sociales"
                        ]
                    ],
                    [
                        "line" => "Elementos publicitarios",
                        "activities" => [
                            "Diseña elementos publicitarios web",
                            "Elabora elementos publicitarios para los artefactos web",
                            "Formula e implementa plan de marketing digital"
                        ]
                    ]
                ]
            ]
        );

        $efsrt2020_2 = Efsrt::updateOrCreate(
            [
                "module" => "Módulo II",
                "period" => "IV",
            ],
            [
                "module_name" => "Desarrollo de aplicaciones web",
                "competency" => "Desarrolla la construcción de programas de los sistemas de información, de acuerdo al diseño funcional, estándares internacionales de tecnologías de información, buenas prácticas de programación y políticas de seguridad de la organización.",
                "hours" => 160,
                "credits" => 5,
                "practice_lines" => [
                    [
                        "line" => "Gestión de base de datos",
                        "activities" => [
                            "Diseña base de datos",
                            "Crea e implementa base de datos",
                            "Administra y gestiona base de datos"
                        ]
                    ],
                    [
                        "line" => "Desarrollo de aplicaciones web",
                        "activities" => [
                            "Analiza y diseña aplicaciones web",
                            "Desarrolla aplicaciones web",
                            "Utiliza estándares de codificación en el desarrollo de aplicaciones web"
                        ]
                    ],
                    [
                        "line" => "Gestión de contenidos web",
                        "activities" => [
                            "Utiliza plantillas para los sitios web",
                            "Gestiona contenidos web"
                        ]
                    ]
                ]
            ]
        );

        $efsrt2020_3 = Efsrt::updateOrCreate(
            [
                "module" => "Módulo III",
                "period" => "VI",
            ],
            [
                "module_name" => "Integración de soluciones web",
                "competency" => "Desarrollar las pruebas integrales de los sistemas de información y servicios de tecnología de información en la fase de implantación, de acuerdo al diseño funcional, buenas prácticas de TI y políticas de seguridad de la organización.",
                "hours" => 128,
                "credits" => 4,
                "practice_lines" => [
                    [
                        "line" => "Integración de sistemas web",
                        "activities" => [
                            "Ejecuta el plan de pruebas de cada parte de un sistema de información",
                            "Realiza pruebas de calidad de software",
                            "Elabora las métricas del sistema web"
                        ]
                    ],
                    [
                        "line" => "Construye aplicaciones móviles",
                        "activities" => [
                            "Diseña y crea aplicaciones para dispositivos móviles",
                            "Desarrolla aplicaciones móviles para empresas",
                            "Desarrolla aplicaciones con realidad aumentada"
                        ]
                    ],
                    [
                        "line" => "Gestión de aplicaciones web",
                        "activities" => [
                            "Gestiona contenidos de aplicaciones web",
                            "Mantenimiento de aplicaciones web",
                            "Gestiona servicios web"
                        ]
                    ]
                ]
            ]
        );

        // EFSRT Modulos Formativos Plan 2019
        $efsrt2019_1 = Efsrt::updateOrCreate(
            [
                "module" => "Módulo I (Plan 2019)",
                "period" => "II",
            ],
            [
                "module_name" => "Diseño y elaboración de páginas web",
                "competency" => "Diseña la presentación, animación, organización y navegación de los contenidos y servicios web, de acuerdo a las demandas del negocio, buenas prácticas de diseño, técnicas de diseño web, usabilidad y experiencia del usuario objetivo.",
                "hours" => 96,
                "credits" => 3,
                "practice_lines" => [
                    [
                        "line" => "Creación de artefactos web",
                        "activities" => [
                            "Diseña los componentes de la web",
                            "Elabora artefactos de la web",
                            "Utiliza herramientas y plataformas"
                        ]
                    ],
                    [
                        "line" => "Gestión de sitios web",
                        "activities" => [
                            "Actualiza sitios web",
                            "Realiza mantenimiento del sitio web",
                            "Publica sitios web"
                        ]
                    ],
                    [
                        "line" => "Documentación web",
                        "activities" => [
                            "Formula la documentación para los artefactos",
                            "Elabora manuales de as aplicaciones web"
                        ]
                    ],
                    [
                        "line" => "Elementos publicitarios",
                        "activities" => [
                            "Diseña elementos publicitarios web",
                            "Elabora elementos publicitarios para web"
                        ]
                    ]
                ]
            ]
        );

        $efsrt2019_2 = Efsrt::updateOrCreate(
            [
                "module" => "Módulo II (Plan 2019)",
                "period" => "IV",
            ],
            [
                "module_name" => "Desarrollo de aplicaciones web",
                "competency" => "Desarrolla la construcción de programas de los sistemas de información, de acuerdo al diseño funcional, estándares internacionales de tecnologías de información, buenas prácticas de programación y políticas de seguridad de la organización.",
                "hours" => 160,
                "credits" => 5,
                "practice_lines" => [
                    [
                        "line" => "Administra base de datos",
                        "activities" => [
                            "Diseña base de datos",
                            "Elabora e implementa base de datos",
                            "Administra base de datos"
                        ]
                    ],
                    [
                        "line" => "Desarrollo aplicaciones web",
                        "activities" => [
                            "Elabora página web",
                            "Crea sitio web",
                            "Realiza aplicaciones web"
                        ]
                    ],
                    [
                        "line" => "Desarrollo de sistemas informáticos",
                        "activities" => [
                            "Analiza y diseña sistemas de información",
                            "Implementa sistemas de información",
                            "Realiza pruebas de sistemas de información"
                        ]
                    ]
                ]
            ]
        );

        $efsrt2019_3 = Efsrt::updateOrCreate(
            [
                "module" => "Módulo III (Plan 2019)",
                "period" => "VI",
            ],
            [
                "module_name" => "Integración de soluciones web",
                "competency" => "Desarrollar las pruebas integrales de los sistemas de información y servicios de tecnología de información en la fase de implantación, de acuerdo al diseño funcional, buenas prácticas de TI y políticas de seguridad de la organización.",
                "hours" => 128,
                "credits" => 4,
                "practice_lines" => [
                    [
                        "line" => "Implementa marketing digital",
                        "activities" => [
                            "Elabora y desarrolla plan de marketing digital",
                            "Implementa plataforma de comercio electrónico",
                            "Desarrolla tiendas virtuales"
                        ]
                    ],
                    [
                        "line" => "Construye aplicaciones móviles",
                        "activities" => [
                            "Desarrolla aplicaciones para dispositivos móviles",
                            "Desarrolla realizad aumentada para dispositivos"
                        ]
                    ],
                    [
                        "line" => "Integración de sistemas web",
                        "activities" => [
                            "Ejecuta el plan de pruebas de cada parte de un sistema de información",
                            "Realiza pruebas de calidad de software",
                            "Elabora las métricas del sistema web."
                        ]
                    ]
                ]
            ]
        );

        // Asociar a mallas si existen
        $curriculum2020 = Curriculum::where("year", "2020")->first();
        if ($curriculum2020) {
            $curriculum2020->efsrts()->syncWithoutDetaching([$efsrt2020_1->id, $efsrt2020_2->id, $efsrt2020_3->id]);
        }

        $curriculum2019 = Curriculum::where("year", "2019")->first();
        if ($curriculum2019) {
            $curriculum2019->efsrts()->syncWithoutDetaching([$efsrt2019_1->id, $efsrt2019_2->id, $efsrt2019_3->id]);
        }

        // Asociar prácticas a estudiantes de prueba si existen
        $student1 = Student::where("student_code", "EST2019001")->first();
        if ($student1) {
            $student1->efsrts()->syncWithoutDetaching([
                $efsrt2020_1->id => [
                    "company_name" => "Web Design Studio",
                    "practice_line" => "Diseño y creación de páginas web.",
                    "activities" => "Diseña páginas web, Realiza la maquetación de las páginas web",
                    "hours" => 96,
                    "start_date" => "2020-01-15",
                    "end_date" => "2020-03-15",
                    "status" => "approved"
                ],
                $efsrt2020_2->id => [
                    "company_name" => "App Developers Inc",
                    "practice_line" => "Desarrollo de aplicaciones web",
                    "activities" => "Desarrolla aplicaciones web con estándares de codificación",
                    "hours" => 160,
                    "start_date" => "2021-01-15",
                    "end_date" => "2021-03-15",
                    "status" => "approved"
                ],
                $efsrt2020_3->id => [
                    "company_name" => "Enterprise Solutions",
                    "practice_line" => "Construye aplicaciones móviles",
                    "activities" => "Diseña y crea aplicaciones para dispositivos móviles",
                    "hours" => 128,
                    "start_date" => "2022-01-15",
                    "end_date" => "2022-03-15",
                    "status" => "approved"
                ],
            ]);
        }

        $student2 = Student::where("student_code", "EST2026001")->first();
        if ($student2) {
            $student2->efsrts()->syncWithoutDetaching([
                $efsrt2020_1->id => [
                    "company_name" => "Tech Support SA",
                    "practice_line" => "Gestión y documentación de sitios web.",
                    "activities" => "Realiza mantenimiento del sitio web y publica contenidos",
                    "hours" => 96,
                    "start_date" => "2026-05-01",
                    "end_date" => "2026-07-01",
                    "status" => "approved"
                ],
                $efsrt2020_2->id => [
                    "company_name" => "Software Factory",
                    "practice_line" => "Gestión de base de datos",
                    "activities" => "Diseña base de datos y crea e implementa base de datos",
                    "hours" => 80,
                    "start_date" => "2026-08-01",
                    "end_date" => null,
                    "status" => "pending"
                ],
            ]);
        }
    }
}
