<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ficha de Seguimiento de Titulación - {{ $student->full_name }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">
        <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">

        @vite(["resources/css/app.css", "resources/js/app.js"])

        <!-- Dark Mode Detection -->
        <script>
            if (localStorage.getItem("theme") === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        </script>

        <style>
            @media print {
                header, footer, .no-print {
                    display: none !important;
                }
                body {
                    background: white !important;
                    color: black !important;
                }
                .print-clean-card {
                    box-shadow: none !important;
                    border: 1px solid #e5e7eb !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-between" x-data="{ activePeriod: 'all', filterStatus: 'all' }">
        
        <!-- Header -->
        <header class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700/80 sticky top-0 z-50 no-print">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 text-decoration-none">
                        <img src="{{ asset('assets/logo.webp') }}" alt="SISAM" class="h-9 w-auto object-contain" />
                        <span class="text-2xl font-black bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent tracking-tight">
                            SISAM
                        </span>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/60">
                            Consulta Pública
                        </span>
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Print Button -->
                    <button onclick="window.print()" type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-xl bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 shadow-sm transition" title="Imprimir o Guardar en PDF">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span class="hidden sm:inline">Imprimir / PDF</span>
                    </button>

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
                        <button @click="toggle()" type="button" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition" title="Cambiar tema">
                            <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                            </svg>
                        </button>
                    </div>

                    <a href="{{ route('graduation.public-lookup') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Nueva Consulta</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow py-8 sm:py-12 relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[300px] pointer-events-none overflow-hidden opacity-20 dark:opacity-10 z-0 no-print">
                <div class="absolute top-[-10%] left-[20%] w-[300px] h-[300px] bg-indigo-400 rounded-full blur-[80px]"></div>
                <div class="absolute top-[10%] right-[20%] w-[300px] h-[300px] bg-purple-400 rounded-full blur-[80px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden print-clean-card">
                    <div class="p-6 sm:p-10">
                        
                        <!-- Header: Student Profile Banner -->
                        @php
                            $st = $student->overall_status;
                            $curriculum = $student->curriculum;
                            $totalCourses = $curriculum ? $curriculum->courses->count() : 0;
                            $pendingCourses = $student->pendingCourses();
                            $pendingCount = $pendingCourses->count();
                            $approvedCount = $totalCourses - $pendingCount;
                            $pctCourses = $totalCourses > 0 ? round(($approvedCount / $totalCourses) * 100) : 0;

                            $totalCredits = $curriculum ? $curriculum->courses->sum("credits") : 0;
                            $approvedCredits = $student->courses->sum("credits");
                            $totalHours = $curriculum ? $curriculum->courses->sum("hours") : 0;
                            $approvedHours = $student->courses->sum("hours");

                            $initials = mb_substr($student->first_name, 0, 1) . mb_substr($student->paternal_last_name, 0, 1);
                        @endphp

                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 dark:border-gray-700 pb-8 mb-8 gap-6">
                            <div class="flex items-start space-x-4">
                                <!-- Avatar Initials -->
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                    {{ strtoupper($initials) }}
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest block mb-1">
                                        Ficha Académica de Graduación
                                    </span>
                                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white leading-tight">
                                        {{ $student->paternal_last_name }} {{ $student->maternal_last_name }}, {{ $student->first_name }}
                                    </h1>
                                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-mono">
                                            DNI: {{ $student->dni }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-mono">
                                            Código: {{ $student->student_code }}
                                        </span>
                                        @if ($student->institutional_email)
                                            <span class="font-mono text-gray-600 dark:text-gray-400">{{ $student->institutional_email }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-start md:items-end">
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/40 px-3 py-1 rounded-full border border-indigo-100 dark:border-indigo-900/40">
                                    {{ mb_strtoupper($student->study_program) }}
                                </span>
                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    @if ($student->shift)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-cyan-50 dark:bg-cyan-950/40 text-cyan-700 dark:text-cyan-400 border border-cyan-100 dark:border-cyan-900/30">
                                            Turno: {{ $student->shift }}
                                        </span>
                                    @endif
                                    @if ($curriculum)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            Malla: {{ $curriculum->name }} ({{ $curriculum->year }})
                                        </span>
                                    @endif
                                </div>
                                <span class="mt-1.5 text-xs text-gray-500 dark:text-gray-400 font-medium">
                                    Periodo de Admisión: {{ \Carbon\Carbon::parse($student->admission_date)->year }} - {{ $student->graduation_date ? \Carbon\Carbon::parse($student->graduation_date)->year : 'En curso' }}
                                </span>
                            </div>
                        </div>

                        <!-- Progress Summary Grid (4 Cards) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                            <!-- Card 1: Estado General -->
                            <div class="bg-gray-50 dark:bg-gray-900/40 p-5 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 flex flex-col justify-between text-center">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Estado de Titulación</span>
                                @php
                                    $badgeClass = 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                                    if ($st == 'Titulado') {
                                        $badgeClass = 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20';
                                    } elseif ($st == 'Apto') {
                                        $badgeClass = 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20 ring-2 ring-indigo-400/30';
                                    } elseif ($st == 'En Proceso') {
                                        $badgeClass = 'bg-amber-500 text-white shadow-md shadow-amber-500/20';
                                    }
                                @endphp
                                <div class="my-2">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-base font-bold shadow-sm {{ $badgeClass }}">
                                        {{ $st }}
                                    </span>
                                </div>
                                @if ($student->degree_date)
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        Fecha de Titulación: <strong>{{ \Carbon\Carbon::parse($student->degree_date)->format('d/m/Y') }}</strong>
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $st == 'Apto' ? 'Cumple con todos los requisitos' : 'Pendiente de requisitos' }}
                                    </span>
                                @endif
                            </div>

                            <!-- Card 2: Avance de Cursos -->
                            <div class="bg-gray-50 dark:bg-gray-900/40 p-5 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 flex flex-col justify-between">
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-bold text-gray-400 uppercase tracking-wider">Unidades Didácticas</span>
                                    <span class="font-bold {{ $pctCourses == 100 ? 'text-emerald-600' : 'text-indigo-600 dark:text-indigo-400' }}">{{ $pctCourses }}%</span>
                                </div>
                                <div class="my-2">
                                    <div class="text-2xl font-black text-gray-900 dark:text-white">
                                        {{ $approvedCount }} <span class="text-sm font-normal text-gray-400">/ {{ $totalCourses }} cursos</span>
                                    </div>
                                    <!-- Progress bar -->
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full mt-2 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-300 {{ $pctCourses == 100 ? 'bg-emerald-500' : 'bg-indigo-600' }}" style="width: {{ $pctCourses }}%"></div>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold {{ $pendingCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                    {{ $pendingCount > 0 ? "{$pendingCount} cursos pendientes" : 'Todas las unidades completadas' }}
                                </span>
                            </div>

                            <!-- Card 3: Créditos y Horas -->
                            <div class="bg-gray-50 dark:bg-gray-900/40 p-5 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 flex flex-col justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Créditos y Horas</span>
                                <div class="my-2 space-y-1.5">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500 dark:text-gray-400">Créditos:</span>
                                        <strong class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $approvedCredits }} / {{ $totalCredits }} Cr</strong>
                                    </div>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500 dark:text-gray-400">Horas Lectivas:</span>
                                        <strong class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $approvedHours }} / {{ $totalHours }} h</strong>
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400 dark:text-gray-500">
                                    Basado en el plan de estudios vigente
                                </span>
                            </div>

                            <!-- Card 4: EFSRT (Prácticas) -->
                            <div class="bg-gray-50 dark:bg-gray-900/40 p-5 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 flex flex-col justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Prácticas (EFSRT)</span>
                                <div class="flex items-center justify-center gap-3 my-2">
                                    @if ($curriculum)
                                        @foreach ($student->efsrtStatusList() as $efs)
                                            @php
                                                $shortModule = preg_replace('/[^IVX0-9]/i', '', $efs['module']) ?: $efs['module'];
                                            @endphp
                                            <div class="flex flex-col items-center">
                                                <div class="relative flex items-center justify-center w-10 h-10 rounded-full border transition {{ $efs['status'] == 'approved' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950/40' : ($efs['status'] == 'rejected' ? 'border-red-500 bg-red-50 dark:bg-red-950/40' : 'border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800') }}"
                                                     title="{{ $efs['module'] }}: {{ $efs['module_name'] }}">
                                                    @if ($efs['status'] == 'approved')
                                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @elseif ($efs['status'] == 'rejected')
                                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    @else
                                                        <span class="text-xs font-bold font-mono text-gray-500 dark:text-gray-400">{{ $shortModule }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-[10px] font-bold text-gray-500 mt-1 uppercase">{{ $shortModule }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-xs text-gray-400">Sin prácticas</span>
                                    @endif
                                </div>
                                <div class="text-center text-[11px] font-semibold text-gray-500 dark:text-gray-400">
                                    {{ $student->efsrts->where('pivot.status', 'approved')->count() }} de {{ $student->curriculum ? $student->curriculum->efsrts->count() : 3 }} módulos aprobados
                                </div>
                            </div>
                        </div>

                        <!-- Courses Breakdown Section with Interactive Filter Tabs -->
                        @if ($curriculum)
                            @php
                                $groupedCourses = $curriculum->courses->groupBy("period");
                                $periodsOrder = ["I", "II", "III", "IV", "V", "VI"];
                            @endphp

                            <div class="border-t border-gray-200/80 dark:border-gray-700/80 pt-8">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                            Detalle de Unidades Didácticas (Malla {{ $curriculum->year }})
                                        </h2>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            Listado estructurado por periodo académico con indicación de estado de aprobación.
                                        </p>
                                    </div>

                                    <!-- Filter Status Toggle -->
                                    <div class="flex items-center space-x-1.5 p-1 bg-gray-100 dark:bg-gray-900/60 rounded-xl no-print">
                                        <button type="button" @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            Todos
                                        </button>
                                        <button type="button" @click="filterStatus = 'approved'" :class="filterStatus === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            Aprobados ({{ $approvedCount }})
                                        </button>
                                        <button type="button" @click="filterStatus = 'pending'" :class="filterStatus === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            Pendientes ({{ $pendingCount }})
                                        </button>
                                    </div>
                                </div>

                                <!-- Period Quick Navigation Pills -->
                                <div class="flex flex-wrap items-center gap-2 mb-6 no-print">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider me-1">Periodo:</span>
                                    <button type="button" @click="activePeriod = 'all'" :class="activePeriod === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300 hover:bg-gray-200'" class="px-3 py-1 rounded-lg text-xs font-bold transition">
                                        Todos (VI)
                                    </button>
                                    @foreach ($periodsOrder as $p)
                                        @if (isset($groupedCourses[$p]))
                                            <button type="button" @click="activePeriod = '{{ $p }}'" :class="activePeriod === '{{ $p }}' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300 hover:bg-gray-200'" class="px-3 py-1 rounded-lg text-xs font-bold transition">
                                                Periodo {{ $p }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Course Grid by Period -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($periodsOrder as $periodName)
                                        @if (isset($groupedCourses[$periodName]))
                                            <div x-show="activePeriod === 'all' || activePeriod === '{{ $periodName }}'" class="bg-gray-50/70 dark:bg-gray-900/30 p-5 rounded-2xl border border-gray-200/70 dark:border-gray-700/70 flex flex-col justify-between">
                                                <div>
                                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-2.5 mb-4 flex items-center justify-between">
                                                        <span class="font-bold text-xs text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                                                            Periodo {{ $periodName }}
                                                        </span>
                                                        <span class="text-[11px] font-semibold text-gray-400">
                                                            {{ $groupedCourses[$periodName]->whereIn('id', $student->courses->pluck('id'))->count() }} / {{ $groupedCourses[$periodName]->count() }} aprobados
                                                        </span>
                                                    </div>

                                                    <ul class="space-y-3">
                                                        @foreach ($groupedCourses[$periodName]->sortBy("code") as $course)
                                                            @php
                                                                $isCompleted = $student->courses->contains($course->id);
                                                            @endphp
                                                            <li x-show="filterStatus === 'all' || (filterStatus === 'approved' && {{ $isCompleted ? 'true' : 'false' }}) || (filterStatus === 'pending' && {{ !$isCompleted ? 'true' : 'false' }})" class="p-3 rounded-xl border transition {{ $isCompleted ? 'bg-emerald-50/80 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-900/40 text-gray-900 dark:text-gray-100' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400' }}">
                                                                <div class="flex items-start justify-between gap-3">
                                                                    <div class="flex-1">
                                                                        <span class="font-semibold text-xs block leading-snug {{ $isCompleted ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}">
                                                                            {{ $course->name }}
                                                                        </span>
                                                                        <div class="mt-1 flex items-center gap-2 text-[11px] text-gray-400 dark:text-gray-500 font-mono">
                                                                            <span>{{ $course->code }}</span>
                                                                            <span>&bull;</span>
                                                                            <span>{{ $course->credits }} Cr</span>
                                                                            <span>&bull;</span>
                                                                            <span>{{ $course->hours }}h</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-shrink-0">
                                                                        @if ($isCompleted)
                                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300">
                                                                                <svg class="w-3 h-3 me-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                                                </svg>
                                                                                Aprobado
                                                                            </span>
                                                                        @else
                                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                                                                Pendiente
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- EFSRT Practices Detail Section -->
                        @if ($curriculum && $curriculum->efsrts->isNotEmpty())
                            <div class="border-t border-gray-200/80 dark:border-gray-700/80 pt-8 mt-8">
                                <div class="mb-4">
                                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                        Detalle de Prácticas Preprofesionales (EFSRT)
                                    </h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        Registro de módulos formativos en situaciones reales de trabajo.
                                    </p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach ($student->efsrtStatusList() as $efs)
                                        @php
                                            $isApp = $efs['status'] === 'approved';
                                            $piv = $efs['pivot'];
                                        @endphp
                                        <div class="p-4 rounded-2xl border {{ $isApp ? 'border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/40 dark:bg-emerald-950/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30' }} flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $efs['module'] }}</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $isApp ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300' : ($efs['status'] === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300') }}">
                                                        {{ $isApp ? 'Aprobado' : ($efs['status'] === 'rejected' ? 'Rechazado' : 'Pendiente') }}
                                                    </span>
                                                </div>
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 mb-2">{{ $efs['module_name'] }}</h4>
                                                @if ($efs['period'] || $efs['hours'])
                                                    <div class="text-[11px] text-gray-500 dark:text-gray-400 mb-2">
                                                        <span>Periodo {{ $efs['period'] ?? '-' }}</span> &bull; 
                                                        <span>{{ $efs['hours'] ?? '-' }} hrs req. ({{ $efs['credits'] ?? '-' }} cr.)</span>
                                                    </div>
                                                @endif
                                                @if ($piv && $piv->practice_line)
                                                    <div class="text-xs bg-white dark:bg-gray-800 p-2.5 rounded-xl border border-gray-100 dark:border-gray-700 mb-2">
                                                        <span class="text-[10px] text-gray-400 block font-semibold uppercase">Línea de Práctica:</span>
                                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $piv->practice_line }}</span>
                                                        @if ($piv->company_name)
                                                            <div class="text-[11px] text-gray-500 mt-1">Empresa: <strong>{{ $piv->company_name }}</strong></div>
                                                        @endif
                                                        @if ($piv->hours)
                                                            <div class="text-[11px] text-gray-500">Horas acumuladas: <strong>{{ $piv->hours }} h</strong></div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-6 no-print">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} SISAM - Sistema Integrado de Seguimiento Académico y Matrícula. Programa de Estudios de Diseño y Programación Web.
            </div>
        </footer>

    </body>
</html>
