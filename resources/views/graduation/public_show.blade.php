<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Seguimiento de Titulación - {{ $student->full_name }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
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
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-between">
        
        <!-- Header -->
        <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent tracking-tight">
                        SISAM
                    </span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        Consulta
                    </span>
                </div>
                <div class="flex items-center gap-4">
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
                        <button @click="toggle()" type="button" class="p-2 rounded-xl bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 transition" title="Cambiar tema">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                            </svg>
                        </button>
                    </div>

                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Volver al Inicio</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow py-12 relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[300px] pointer-events-none overflow-hidden opacity-20 dark:opacity-10 z-0">
                <div class="absolute top-[-10%] left-[20%] w-[300px] h-[300px] bg-indigo-400 rounded-full blur-[80px]"></div>
                <div class="absolute top-[10%] right-[20%] w-[300px] h-[300px] bg-purple-400 rounded-full blur-[80px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700/50">
                    <div class="p-6 sm:p-10">
                        <!-- Header Info -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 dark:border-gray-700 pb-6 mb-8 gap-4">
                            <div>
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest block mb-1">
                                    Estudiante
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">
                                    {{ $student->paternal_last_name }} {{ $student->maternal_last_name }}, {{ $student->first_name }}
                                </h3>
                                <div class="mt-3 flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center">
                                        DNI: <strong class="ms-1 text-gray-800 dark:text-gray-200">{{ $student->dni }}</strong>
                                    </span>
                                    <span class="inline-flex items-center">
                                        Código: <strong class="ms-1 text-gray-800 dark:text-gray-200">{{ $student->student_code }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-start md:items-end">
                                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                                    {{ mb_strtoupper($student->study_program) }}
                                </span>
                                @if($student->shift)
                                    <span class="mt-1.5 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-50 dark:bg-cyan-950/40 text-cyan-700 dark:text-cyan-400 border border-cyan-100 dark:border-cyan-900/30">
                                        Turno: {{ $student->shift }}
                                    </span>
                                @endif
                                <span class="mt-1.5 text-sm text-gray-600 dark:text-gray-400 font-medium">
                                    Periodo: {{ \Carbon\Carbon::parse($student->admission_date)->year }} - {{ $student->graduation_date ? \Carbon\Carbon::parse($student->graduation_date)->year : 'En curso' }}
                                </span>
                            </div>
                        </div>

                        <!-- Progress Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                            <!-- Card 1: Overall Status -->
                            <div class="bg-gray-50/50 dark:bg-gray-900/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-800/80 flex flex-col items-center justify-center text-center">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Estado General</span>
                                @php
                                    $st = $student->overall_status;
                                    $badgeClass = 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                                    if ($st == 'Titulado') {
                                        $badgeClass = 'bg-emerald-600 text-white';
                                    } elseif ($st == 'Apto') {
                                        $badgeClass = 'bg-indigo-600 text-white';
                                    } elseif ($st == 'En Proceso') {
                                        $badgeClass = 'bg-amber-500 text-white';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-5 py-2 rounded-full text-lg font-bold shadow-sm {{ $badgeClass }}">
                                    {{ $st }}
                                </span>
                                @if($student->degree_date)
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">
                                        Titulado el: {{ \Carbon\Carbon::parse($student->degree_date)->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Card 2: U.D. Progress -->
                            <div class="bg-gray-50/50 dark:bg-gray-900/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-800/80 flex flex-col items-center justify-center text-center">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Unidades Didácticas (Cursos)</span>
                                @php
                                    $pendingCount = $student->pendingCourses()->count();
                                    $totalCount = $student->curriculum ? $student->curriculum->courses->count() : 0;
                                    $approvedCount = $totalCount - $pendingCount;
                                @endphp
                                <div class="text-3xl font-extrabold text-gray-900 dark:text-white">
                                    {{ $approvedCount }} / {{ $totalCount }}
                                </div>
                                <span class="text-sm font-bold mt-2 {{ $pendingCount > 0 ? 'text-red-500 dark:text-red-400' : 'text-emerald-500 dark:text-emerald-400' }}">
                                    {{ $pendingCount }} U.D. pendientes
                                </span>
                            </div>

                            <!-- Card 3: EFSRT Status -->
                            <div class="bg-gray-50/50 dark:bg-gray-900/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-800/80 flex flex-col items-center justify-center text-center">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Módulos de Práctica (EFSRT)</span>
                                <div class="flex gap-3">
                                    @if($student->curriculum)
                                        @foreach($student->efsrtStatusList() as $efs)
                                            <div class="relative flex items-center justify-center w-11 h-11 rounded-full border border-gray-200 dark:border-gray-700 cursor-default"
                                                 title="{{ $efs['module'] }}: {{ $efs['module_name'] }} ({{ ucfirst($efs['status']) }})">
                                                @if($efs['status'] == 'approved')
                                                    <span class="absolute inset-0 bg-emerald-100 dark:bg-emerald-900/30 border-emerald-500 rounded-full"></span>
                                                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                @elseif($efs['status'] == 'rejected')
                                                    <span class="absolute inset-0 bg-red-100 dark:bg-red-900/30 border-red-500 rounded-full"></span>
                                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                @else
                                                    <span class="absolute inset-0 bg-gray-100 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 rounded-full"></span>
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-xs text-gray-400">Sin prácticas</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Courses Breakdown by Semester -->
                        @if($student->curriculum)
                            <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-6">
                                    Detalle de Unidades Didácticas (Malla {{ $student->curriculum->year }})
                                </h4>

                                @php
                                    $groupedCourses = $student->curriculum->courses->groupBy('period');
                                    $periodsOrder = ['I', 'II', 'III', 'IV', 'V', 'VI'];
                                @endphp

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($periodsOrder as $periodName)
                                        @if(isset($groupedCourses[$periodName]))
                                            <div class="bg-gray-50/50 dark:bg-gray-900/20 p-5 rounded-2xl border border-gray-100 dark:border-gray-800/80">
                                                <h5 class="font-bold text-sm text-indigo-600 dark:text-indigo-450 border-b border-gray-100 dark:border-gray-700 pb-2.5 mb-4">
                                                    Periodo {{ $periodName }}
                                                </h5>
                                                <ul class="space-y-4">
                                                    @foreach($groupedCourses[$periodName]->sortBy('code') as $course)
                                                        @php
                                                            $isCompleted = $student->courses->contains($course->id);
                                                        @endphp
                                                        <li class="flex items-start">
                                                            <div class="flex items-center h-5 mt-0.5">
                                                                @if($isCompleted)
                                                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                                @else
                                                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-650" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                @endif
                                                            </div>
                                                            <div class="ms-3 text-xs">
                                                                <span class="font-semibold {{ $isCompleted ? 'text-gray-800 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">
                                                                    {{ $course->name }}
                                                                </span>
                                                                <div class="text-gray-400 dark:text-gray-500 font-mono mt-0.5">
                                                                    {{ $course->code }} • {{ $course->credits }} Cr • {{ $course->hours }}h
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} SISAM. Todos los derechos reservados. Programa de Estudios de Diseño y Programación Web.
            </div>
        </footer>

    </body>
</html>
