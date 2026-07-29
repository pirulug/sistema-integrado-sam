<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SISAM - Diseño y Programación Web</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Dark Mode Detection -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-between transition-colors duration-250">
        
        <!-- Header -->
        <header class="bg-white/80 dark:bg-gray-800/85 backdrop-blur border-b border-gray-100 dark:border-gray-750 sticky top-0 z-50 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent tracking-tight">
                        SISAM
                    </span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 border border-indigo-100/30">
                        P.E.
                    </span>
                </div>
                <nav class="flex items-center gap-4">
                    <!-- Theme Toggle Switch -->
                    <div x-data="{
                        darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggle() {
                            this.darkMode = !this.darkMode;
                            if (this.darkMode) {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('theme', 'dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('theme', 'light');
                            }
                            window.dispatchEvent(new CustomEvent('theme-changed', { detail: this.darkMode }));
                        }
                    }" @theme-changed.window="darkMode = $event.detail" class="flex items-center">
                        <button @click="toggle()" type="button" class="p-2 rounded-xl bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 transition-colors" title="Cambiar tema">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                            </svg>
                        </button>
                    </div>

                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-100 dark:hover:border-gray-600 transition">
                        Acceso Personal
                    </a>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Background Decorative Lights -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none overflow-hidden opacity-25 dark:opacity-15 z-0">
                <div class="absolute top-[-5%] left-[5%] w-[450px] h-[450px] bg-indigo-500 rounded-full blur-[140px]"></div>
                <div class="absolute top-[15%] right-[5%] w-[400px] h-[400px] bg-purple-500 rounded-full blur-[140px]"></div>
            </div>

            <!-- Hero & Query Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Hero Info -->
                    <div class="lg:col-span-7">
                        <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-150/20 px-3 py-1.5 rounded-full inline-block mb-4">
                            Programa de Estudios
                        </span>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6 leading-tight">
                            Diseño y <span class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">Programación</span> Web
                        </h1>
                        <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl">
                            Formación técnica profesional especializada. Aprende a diseñar interfaces gráficas modernas y a desarrollar sistemas informáticos basados en tecnologías web avanzadas.
                        </p>

                        <!-- Key Stats Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-150 dark:border-gray-800 pt-8">
                            <div class="bg-white/40 dark:bg-gray-800/20 p-4 rounded-xl border border-gray-150/30 dark:border-gray-700/30">
                                <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block mb-1">Duración</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">06 Periodos Académicos</span>
                            </div>
                            <div class="bg-white/40 dark:bg-gray-800/20 p-4 rounded-xl border border-gray-150/30 dark:border-gray-700/30">
                                <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block mb-1">Créditos</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">129 Créditos</span>
                            </div>
                            <div class="bg-white/40 dark:bg-gray-800/20 p-4 rounded-xl border border-gray-150/30 dark:border-gray-700/30">
                                <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block mb-1">Título</span>
                                <span class="text-xs font-bold text-gray-900 dark:text-white">Profesional Técnico</span>
                            </div>
                        </div>
                    </div>

                    <!-- Query Box -->
                    <div class="lg:col-span-5">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 p-6 sm:p-8 relative">
                            <div class="absolute -top-3 right-4 bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-md">
                                Consulta de Alumnos
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                Seguimiento de Titulación
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">
                                Consulta el avance de tus cursos aprobados y prácticas profesionales ingresando tu DNI.
                            </p>

                            <!-- Error Alert -->
                            @if (session('error'))
                                <div class="mb-5 p-3.5 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-150/20 dark:border-red-800 text-red-600 dark:text-red-400 text-xs font-medium flex items-center gap-2.5">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            <form action="{{ route('graduation.public-lookup') }}" method="GET" class="space-y-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="dni" required placeholder="Ingresa tu DNI" class="w-full ps-10 pe-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/40 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition font-medium text-sm" autocomplete="off" />
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow transition duration-150 gap-2">
                                    <span>Consultar mi Progreso</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Perfil de Egreso -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="bg-gradient-to-br from-white to-gray-50/50 dark:from-gray-800 dark:to-gray-850/50 rounded-3xl border border-gray-150/60 dark:border-gray-750/50 shadow-md p-8 sm:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <div class="lg:col-span-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">
                                Identidad Profesional
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white mt-2 mb-4">
                                Perfil de Egreso
                            </h2>
                            <div class="w-12 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded"></div>
                        </div>
                        <div class="lg:col-span-8 space-y-6 text-gray-650 dark:text-gray-300 text-sm sm:text-base leading-relaxed">
                            <p>
                                El profesional técnico del programa de estudios de **Diseño y Programación Web** es un profesional con sólidos conocimientos con capacidad para producir los elementos necesarios de sitios y sistemas basados en tecnología web con énfasis en el diseño y programación de una interfaz gráfica, funcionales, interactivas, accesibles de fácil compresión y basadas en estándares web que contribuyan al desarrollo de las empresas de la mano con la tecnología de las comunicaciones y manejo de la información basados en la web, demostrando siempre compromiso, responsabilidad, honestidad, respeto y proactividad.
                            </p>
                            <p class="border-t border-gray-200/55 dark:border-gray-700/60 pt-5">
                                <strong class="text-gray-900 dark:text-white">Ámbito de Acción:</strong> Desarrollan proyectos informáticos basados en tecnología web en entidades públicas y privadas, de acuerdo a los requerimientos y necesidades de los sectores de servicio y productivos del país; en empresas de desarrollo de software y centros de desarrollo informático, como diagramadores, analistas, diseñadores y programadores.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Certificación Modular -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-150/40 dark:border-gray-800/40">
                <div class="text-center mb-12">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Progreso Académico</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">Certificaciones Modulares</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Nuestra malla curricular se divide en tres módulos formativos con certificación oficial.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Modulo 1 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-100/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-5">
                            <span class="font-bold text-sm">M1</span>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Módulo I</span>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-1 mb-3">
                            Diseño y Elaboración de Páginas Web
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Enfoque en maquetación estructurada, diseño de interfaces visuales con HTML/CSS, diseño adaptable y principios fundamentales de usabilidad y experiencia de usuario.
                        </p>
                    </div>

                    <!-- Modulo 2 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-100/20 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-5">
                            <span class="font-bold text-sm">M2</span>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Módulo II</span>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-1 mb-3">
                            Desarrollo de Aplicaciones Web
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Orientado al desarrollo del lado del servidor y del cliente, lógica de programación avanzada, programación de bases de datos relacionales y no relacionales, y sistemas dinámicos.
                        </p>
                    </div>

                    <!-- Modulo 3 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-xl bg-pink-50 dark:bg-pink-950/40 border border-pink-100/20 flex items-center justify-center text-pink-600 dark:text-pink-400 mb-5">
                            <span class="font-bold text-sm">M3</span>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Módulo III</span>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-1 mb-3">
                            Integración de Soluciones Web
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Desarrollo e integración de API, microservicios, seguridad informática web, despliegue en la nube, optimización de sistemas y automatización de procesos de software.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Competencias (Tabs Interactivas) -->
            <section x-data="{ tab: 'technical' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-150/40 dark:border-gray-800/40">
                <div class="text-center mb-10">
                    <span class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">Capacidades</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">Competencias del Programa</h2>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex justify-center border-b border-gray-200 dark:border-gray-700 max-w-md mx-auto mb-10">
                    <button @click="tab = 'technical'" :class="tab === 'technical' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="w-1/2 pb-4 text-center border-b-2 font-bold text-sm transition focus:outline-none">
                        Técnicas / Específicas
                    </button>
                    <button @click="tab = 'employability'" :class="tab === 'employability' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="w-1/2 pb-4 text-center border-b-2 font-bold text-sm transition focus:outline-none">
                        Para la Empleabilidad
                    </button>
                </div>

                <!-- Tab Content: Technical -->
                <div x-show="tab === 'technical'" class="space-y-6 max-w-4xl mx-auto">
                    <div class="flex gap-4 p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <span class="font-bold text-xs">01</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Diseño UX/UI y Maquetación</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                Diseñar la presentación, animación, organización y navegación de los contenidos y servicios web, de acuerdo a las demandas del negocio, buenas prácticas de diseño, técnicas de diseño web, usabilidad y experiencia del usuario objetivo.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <span class="font-bold text-xs">02</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Desarrollo de Software y Programación</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                Desarrollar la construcción de programas de los sistemas de información, de acuerdo al diseño funcional, estándares internacionales de TI, buenas prácticas de programación y políticas de seguridad de la organización.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <span class="font-bold text-xs">03</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Pruebas e Implantación</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                Desarrollar las pruebas integrales de los sistemas de información y servicios de TI en la fase de implantación, de acuerdo al diseño funcional, buenas prácticas de TI y políticas de seguridad de la organización.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tab Content: Employability -->
                <div x-show="tab === 'employability'" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-4xl mx-auto" style="display: none;">
                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Comunicación Efectiva</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Expresar de manera clara conceptos, ideas, sentimientos, hechos y opiniones en forma oral y escrita.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Tecnologías de Información</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Manejar herramientas informáticas de las TIC para buscar, analizar información y realizar tareas.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Inglés</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Comprender y comunicar ideas, cotidianamente, a nivel oral y escrito en idioma inglés.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Solución de Problemas</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Identificar situaciones complejas para evaluar posibles soluciones aplicando herramientas flexibles.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Ética</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Establecer relaciones con respeto y justicia en ámbitos personales e institucionales.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Emprendimiento</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Identificar nuevas oportunidades de proyectos o negocios que generen valor y sean sostenibles.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Innovación</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Desarrollar procedimientos sistemáticos enfocados en la mejora significativa de un proceso o producto.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 shadow-sm flex gap-3">
                        <div class="text-indigo-500 font-bold text-sm">&#10004;</div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">Trabajo Colaborativo</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                Participar de forma activa en el logro de objetivos y metas comunes integrándose con respeto.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Plan de Estudios Dinámico ("Jalado de la BD") -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-150/40 dark:border-gray-800/40">
                <div class="text-center mb-12">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Malla Curricular</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">Plan de Estudios</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Visualiza las unidades didácticas del programa académico 2020 por periodos de estudios.</p>
                </div>

                @if($coursesByPeriod->isNotEmpty())
                    <div x-data="{ activePeriod: 'I' }" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start max-w-5xl mx-auto">
                        <!-- Navigation Sidebar -->
                        <div class="lg:col-span-3 flex flex-row lg:flex-col overflow-x-auto lg:overflow-visible gap-2 border-b lg:border-b-0 lg:border-l border-gray-200 dark:border-gray-700 pb-3 lg:pb-0 lg:pl-3">
                            @php
                                $periods = ['I', 'II', 'III', 'IV', 'V', 'VI'];
                            @endphp
                            @foreach($periods as $p)
                                @if($coursesByPeriod->has($p))
                                    <button @click="activePeriod = '{{ $p }}'" 
                                            :class="activePeriod === '{{ $p }}' ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 border-indigo-500' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/40 border-transparent'"
                                            class="flex-shrink-0 text-left px-4 py-2.5 rounded-lg border-l-2 font-bold text-xs transition focus:outline-none">
                                        {{ $p }} Periodo
                                    </button>
                                @endif
                            @endforeach
                        </div>

                        <!-- Courses Listing Container -->
                        <div class="lg:col-span-9 bg-white dark:bg-gray-800/50 border border-gray-150 dark:border-gray-700/50 rounded-2xl p-6 shadow-sm min-h-[350px]">
                            @foreach($periods as $p)
                                @if($coursesByPeriod->has($p))
                                    <div x-show="activePeriod === '{{ $p }}'" class="space-y-4" style="display: none;">
                                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                                            <h3 class="font-extrabold text-sm text-gray-900 dark:text-white">
                                                Unidades Didácticas del Periodo {{ $p }}
                                            </h3>
                                            <span class="text-[10px] font-bold uppercase bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 px-2.5 py-1 rounded-full border border-indigo-100/20">
                                                {{ $coursesByPeriod->get($p)->count() }} Cursos
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 gap-3">
                                            @foreach($coursesByPeriod->get($p)->sortBy('code') as $course)
                                                <div class="p-3.5 bg-gray-50/50 dark:bg-gray-900/40 rounded-xl border border-gray-150/40 dark:border-gray-700/45 flex items-center justify-between gap-4">
                                                    <div>
                                                        <h4 class="font-semibold text-xs text-gray-800 dark:text-gray-200">
                                                            {{ $course->name }}
                                                        </h4>
                                                        <span class="font-mono text-[10px] text-gray-400 dark:text-gray-500">
                                                            Código: {{ $course->code }}
                                                        </span>
                                                    </div>
                                                    <div class="flex gap-4 text-right flex-shrink-0 text-[11px] text-gray-500 dark:text-gray-400 font-semibold">
                                                        <span>{{ $course->credits }} Cr</span>
                                                        <span>{{ $course->hours }} Horas</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 max-w-lg mx-auto">
                        <p class="text-sm text-gray-400">No hay mallas curriculares o cursos registrados en este momento.</p>
                    </div>
                @endif
            </section>

            <!-- Ámbito de Desempeño -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-150/40 dark:border-gray-800/40">
                <div class="text-center mb-12">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Inserción Laboral</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">Ámbito de Desempeño</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Nuestros egresados cuentan con una amplia salida laboral en organizaciones públicas y privadas.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Informática</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Sistemas</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Diseño y desarrollo web</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Programación de sistemas web</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Desarrollo móvil</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Centros de desarrollo</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Gestión de la calidad</h4>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-150 dark:border-gray-700/50 text-center hover:border-indigo-500/30 transition">
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white">Administración</h4>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-br from-indigo-50/50 to-purple-50/50 dark:from-indigo-950/20 dark:to-purple-950/20 rounded-2xl border border-indigo-150/25 dark:border-indigo-900/30 text-center max-w-3xl mx-auto">
                    <h4 class="font-bold text-sm text-gray-900 dark:text-white mb-2">Fomento al Emprendimiento</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        También nuestros egresados podrán visualizar las posibilidades de emprender su propia empresa de desarrollo de sistemas web, con lo que se fomenta el autoempleo y se generaran nuevas fuentes de trabajo en el país.
                    </p>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} SISAM. Todos los derechos reservados. Programa de Estudios de Diseño y Programación Web.
            </div>
        </footer>

    </body>
</html>
