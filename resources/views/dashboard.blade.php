<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <i data-feather="bar-chart-2" class="w-7 h-7 text-indigo-600 dark:text-indigo-400"></i>
                    <span>{{ __("Panel Estadístico y Control Académico") }}</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Métricas consolidadas de matrícula, progreso curricular, prácticas pre-profesionales (EFSRT) y titulación.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('graduation.index') }}" class="inline-flex items-center px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                    <i data-feather="award" class="w-4 h-4 me-1.5"></i>
                    <span>Seguimiento de Titulación</span>
                </a>
                <a href="{{ route('students.index') }}" class="inline-flex items-center px-3.5 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl text-xs font-bold shadow-sm transition">
                    <i data-feather="users" class="w-4 h-4 me-1.5 text-gray-500"></i>
                    <span>Estudiantes</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Top Core KPIs (5 Cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- KPI 1: Estudiantes -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estudiantes</span>
                        <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl text-indigo-600 dark:text-indigo-400">
                            <i data-feather="users" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalStudents }}</div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Matrícula registrada</span>
                    </div>
                </div>

                <!-- KPI 2: Titulados -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-emerald-200 dark:border-emerald-900/60 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Titulados</span>
                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/50 rounded-xl text-emerald-600 dark:text-emerald-400">
                            <i data-feather="check-circle" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-emerald-700 dark:text-emerald-300">
                            {{ $tituladosCount }} <span class="text-xs font-bold text-emerald-600">({{ $tituladosPct }}%)</span>
                        </div>
                        <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">Grado conferido</span>
                    </div>
                </div>

                <!-- KPI 3: Aptos -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-indigo-200 dark:border-indigo-900/60 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Aptos Titular</span>
                        <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl text-indigo-600 dark:text-indigo-400">
                            <i data-feather="award" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-indigo-700 dark:text-indigo-300">
                            {{ $aptosCount }} <span class="text-xs font-bold text-indigo-600">({{ $aptosPct }}%)</span>
                        </div>
                        <a href="{{ route('graduation.index', ['status' => 'Apto']) }}" class="text-[11px] text-indigo-600 dark:text-indigo-400 hover:underline font-semibold flex items-center mt-0.5">
                            <span>Pendientes de titular</span>
                            <i data-feather="arrow-right" class="w-3 h-3 ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- KPI 4: En Proceso -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-amber-200 dark:border-amber-900/60 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">En Proceso</span>
                        <div class="p-2.5 bg-amber-50 dark:bg-amber-950/50 rounded-xl text-amber-600 dark:text-amber-400">
                            <i data-feather="clock" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-amber-700 dark:text-amber-300">
                            {{ $enProcesoCount }} <span class="text-xs font-bold text-amber-600">({{ $enProcesoPct }}%)</span>
                        </div>
                        <span class="text-[11px] text-amber-600 dark:text-amber-400 font-medium">Cursando o prácticas</span>
                    </div>
                </div>

                <!-- KPI 5: Docentes -->
                <div class="col-span-2 sm:col-span-2 lg:col-span-1 bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Docentes</span>
                        <div class="p-2.5 bg-gray-100 dark:bg-gray-700/70 rounded-xl text-gray-600 dark:text-gray-300">
                            <i data-feather="briefcase" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalTeachers }}</div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Plana docente</span>
                    </div>
                </div>
            </div>

            <!-- 2. Row 1: Graduation Funnel & Shift Distribution (2 Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Card: Estado General de Titulación (7 Cols) -->
                <div class="lg:col-span-7 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="pie-chart" class="w-5 h-5 me-2 text-indigo-600 dark:text-indigo-400"></i>
                                    Estado General de Graduación y Titulación
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Distribución de los {{ $totalStudents }} estudiantes según su condición académica actual.
                                </p>
                            </div>
                        </div>

                        <!-- Multi-Segment Visual Progress Bar -->
                        <div class="w-full h-4 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden flex my-4">
                            <div style="width: {{ $tituladosPct }}%" class="bg-emerald-500 h-full transition-all duration-500" title="Titulados: {{ $tituladosCount }} ({{ $tituladosPct }}%)"></div>
                            <div style="width: {{ $aptosPct }}%" class="bg-indigo-600 h-full transition-all duration-500" title="Aptos: {{ $aptosCount }} ({{ $aptosPct }}%)"></div>
                            <div style="width: {{ $enProcesoPct }}%" class="bg-amber-500 h-full transition-all duration-500" title="En Proceso: {{ $enProcesoCount }} ({{ $enProcesoPct }}%)"></div>
                            <div style="width: {{ $sinMallaPct }}%" class="bg-gray-400 dark:bg-gray-500 h-full transition-all duration-500" title="Sin Malla: {{ $sinMallaCount }} ({{ $sinMallaPct }}%)"></div>
                        </div>

                        <!-- Progress Breakdown Bars -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                            <!-- Titulados -->
                            <div class="p-3.5 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/40 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                                    <div>
                                        <div class="text-xs font-bold text-gray-900 dark:text-white">Titulados</div>
                                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Trámite concluido</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-emerald-700 dark:text-emerald-300">{{ $tituladosCount }}</div>
                                    <span class="text-[10px] font-bold text-emerald-600">{{ $tituladosPct }}%</span>
                                </div>
                            </div>

                            <!-- Aptos -->
                            <div class="p-3.5 rounded-2xl bg-indigo-50/70 dark:bg-indigo-950/20 border border-indigo-200 dark:border-indigo-900/40 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="w-3.5 h-3.5 rounded-full bg-indigo-600 flex-shrink-0"></span>
                                    <div>
                                        <div class="text-xs font-bold text-gray-900 dark:text-white">Aptos para Titulación</div>
                                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Requisitos 100%</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-indigo-700 dark:text-indigo-300">{{ $aptosCount }}</div>
                                    <span class="text-[10px] font-bold text-indigo-600">{{ $aptosPct }}%</span>
                                </div>
                            </div>

                            <!-- En Proceso -->
                            <div class="p-3.5 rounded-2xl bg-amber-50/70 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="w-3.5 h-3.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                                    <div>
                                        <div class="text-xs font-bold text-gray-900 dark:text-white">En Proceso</div>
                                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Cursos o EFSRT pend.</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-amber-700 dark:text-amber-300">{{ $enProcesoCount }}</div>
                                    <span class="text-[10px] font-bold text-amber-600">{{ $enProcesoPct }}%</span>
                                </div>
                            </div>

                            <!-- Sin Malla -->
                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-700/80 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="w-3.5 h-3.5 rounded-full bg-gray-400 flex-shrink-0"></span>
                                    <div>
                                        <div class="text-xs font-bold text-gray-900 dark:text-white">Sin Malla Asignada</div>
                                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Por configurar</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-gray-700 dark:text-gray-300">{{ $sinMallaCount }}</div>
                                    <span class="text-[10px] font-bold text-gray-500">{{ $sinMallaPct }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Card: Distribución por Turno (5 Cols) -->
                <div class="lg:col-span-5 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="sun" class="w-5 h-5 me-2 text-cyan-600 dark:text-cyan-400"></i>
                                    Matrícula por Turno
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Preferencia horaria de los estudiantes registrados.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4 mt-4">
                            @php
                                $shiftIcons = [
                                    'Diurno (Mañana)' => 'sun',
                                    'Diurno (Tarde)' => 'cloud',
                                    'Nocturno (Noche)' => 'moon',
                                    'Sin Turno' => 'help-circle'
                                ];
                                $shiftColors = [
                                    'Diurno (Mañana)' => 'bg-amber-500',
                                    'Diurno (Tarde)' => 'bg-cyan-500',
                                    'Nocturno (Noche)' => 'bg-indigo-600',
                                    'Sin Turno' => 'bg-gray-400'
                                ];
                            @endphp

                            @foreach ($shiftsRaw as $shiftName => $count)
                                @php
                                    $pct = $totalStudents > 0 ? round(($count / $totalStudents) * 100, 1) : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                        <span class="text-gray-700 dark:text-gray-300 flex items-center">
                                            <i data-feather="{{ $shiftIcons[$shiftName] ?? 'clock' }}" class="w-3.5 h-3.5 me-1.5 text-gray-400"></i>
                                            {{ $shiftName }}
                                        </span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $count }} alumnos <span class="text-gray-400">({{ $pct }}%)</span></span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-300 {{ $shiftColors[$shiftName] ?? 'bg-indigo-600' }}" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 mt-6 border-t border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center justify-between text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                            <span>Distribución por Género</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            @php
                                $mascCount = $genderStats['Masculino'] ?? 0;
                                $femCount = $genderStats['Femenino'] ?? 0;
                                $mascPct = $totalStudents > 0 ? round(($mascCount / $totalStudents) * 100, 1) : 0;
                                $femPct = $totalStudents > 0 ? round(($femCount / $totalStudents) * 100, 1) : 0;
                            @endphp
                            <div class="p-2.5 rounded-xl bg-blue-50/70 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-900/40 flex items-center justify-between">
                                <span class="font-semibold text-blue-700 dark:text-blue-300">Masculino:</span>
                                <span class="font-black text-blue-800 dark:text-blue-200">{{ $mascCount }} <span class="text-[10px] font-bold text-blue-600">({{ $mascPct }}%)</span></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-pink-50/70 dark:bg-pink-950/20 border border-pink-200 dark:border-pink-900/40 flex items-center justify-between">
                                <span class="font-semibold text-pink-700 dark:text-pink-300">Femenino:</span>
                                <span class="font-black text-pink-800 dark:text-pink-200">{{ $femCount }} <span class="text-[10px] font-bold text-pink-600">({{ $femPct }}%)</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Row 2: Mallas Curriculares & EFSRT Practices (2 Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Mallas Curriculares (6 Cols) -->
                <div class="lg:col-span-6 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="book" class="w-5 h-5 me-2 text-indigo-600 dark:text-indigo-400"></i>
                                    Mallas Curriculares Vigentes
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Planes de estudio configurados y distribución de estudiantes.
                                </p>
                            </div>
                            <a href="{{ route('curriculums.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                                Ver todas
                            </a>
                        </div>

                        @if ($curriculumsStats->isEmpty())
                            <div class="p-6 text-center text-xs text-gray-400 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700">
                                No se registran mallas curriculares en el sistema.
                            </div>
                        @else
                            <div class="space-y-3.5">
                                @foreach ($curriculumsStats as $curr)
                                    <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-200/80 dark:border-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white flex items-center">
                                                <span>{{ $curr->name }}</span>
                                                <span class="ms-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300">
                                                    Año {{ $curr->year }}
                                                </span>
                                            </div>
                                            <div class="mt-1 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                                <span><strong class="text-gray-800 dark:text-gray-200">{{ $curr->courses_count }}</strong> Cursos / U.D.</span>
                                                <span>&bull;</span>
                                                <span><strong class="text-gray-800 dark:text-gray-200">{{ $curr->courses->sum('credits') }}</strong> Créditos</span>
                                                <span>&bull;</span>
                                                <span><strong class="text-gray-800 dark:text-gray-200">{{ $curr->courses->sum('hours') }}</strong> Horas</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <div class="text-right">
                                                <div class="text-sm font-black text-gray-900 dark:text-white">{{ $curr->students_count }}</div>
                                                <span class="text-[10px] text-gray-400 uppercase font-semibold">Alumnos</span>
                                            </div>
                                            <a href="{{ route('curriculums.show', $curr->id) }}" class="p-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-indigo-600 transition" title="Ver estructura de cursos">
                                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Prácticas Pre-Profesionales (EFSRT) (6 Cols) -->
                <div class="lg:col-span-6 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="file-text" class="w-5 h-5 me-2 text-emerald-600 dark:text-emerald-400"></i>
                                    Prácticas Pre-Profesionales (EFSRT)
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Control de cumplimiento de los 3 módulos formativos de prácticas.
                                </p>
                            </div>
                        </div>

                        <!-- EFSRT Global Progress Cards -->
                        <div class="grid grid-cols-3 gap-3 mb-5">
                            <div class="p-3 bg-emerald-50/80 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/40 rounded-2xl text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Aprobados</span>
                                <div class="text-xl font-black text-emerald-700 dark:text-emerald-300 mt-1">{{ $efsrtStats['total_approved'] }}</div>
                            </div>
                            <div class="p-3 bg-amber-50/80 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40 rounded-2xl text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Pendientes</span>
                                <div class="text-xl font-black text-amber-700 dark:text-amber-300 mt-1">{{ $efsrtStats['total_pending'] }}</div>
                            </div>
                            <div class="p-3 bg-red-50/80 dark:bg-red-950/20 border border-red-200 dark:border-red-900/40 rounded-2xl text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-red-600 dark:text-red-400">Rechazados</span>
                                <div class="text-xl font-black text-red-700 dark:text-red-300 mt-1">{{ $efsrtStats['total_rejected'] }}</div>
                            </div>
                        </div>

                        <!-- Per Module Breakdown -->
                        <div class="space-y-3">
                            @foreach ($efsrtModuleStats as $mStat)
                                @php
                                    $modTotal = $mStat['approved'] + $mStat['pending'] + $mStat['rejected'];
                                    $modApprovedPct = $modTotal > 0 ? round(($mStat['approved'] / $modTotal) * 100, 1) : 0;
                                @endphp
                                <div class="p-3.5 bg-gray-50/70 dark:bg-gray-900/40 rounded-2xl border border-gray-200/80 dark:border-gray-700/80">
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                                        <div class="text-gray-900 dark:text-white">
                                            <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $mStat['module'] }}:</span>
                                            <span>{{ $mStat['name'] }}</span>
                                        </div>
                                        <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold">{{ $mStat['approved'] }} / {{ $modTotal }} ({{ $modApprovedPct }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300" style="width: {{ $modApprovedPct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Row 3: Plan de Estudios por Periodos & Cohortes (2 Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Estructura por Periodo Académico (7 Cols) -->
                <div class="lg:col-span-7 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                <i data-feather="layers" class="w-5 h-5 me-2 text-indigo-600 dark:text-indigo-400"></i>
                                Estructura de Asignaturas por Periodo (I al VI)
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                Total de cursos, créditos y horas formativas por semestre académico.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5 mt-4">
                        @foreach ($periodsOrder as $pName)
                            @php
                                $pData = $coursesByPeriod->get($pName);
                                $pCourses = $pData ? $pData->total_courses : 0;
                                $pCredits = $pData ? $pData->total_credits : 0;
                                $pHours = $pData ? $pData->total_hours : 0;
                            @endphp
                            <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-gray-900/40 border border-gray-200/80 dark:border-gray-700/80 flex flex-col justify-between">
                                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-2 mb-2">
                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Periodo {{ $pName }}</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300">
                                        {{ $pCourses }} U.D.
                                    </span>
                                </div>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between text-gray-500 dark:text-gray-400">
                                        <span>Créditos:</span>
                                        <strong class="text-gray-800 dark:text-gray-200">{{ $pCredits }} Cr</strong>
                                    </div>
                                    <div class="flex justify-between text-gray-500 dark:text-gray-400">
                                        <span>Horas:</span>
                                        <strong class="text-gray-800 dark:text-gray-200">{{ $pHours }} h</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between text-xs font-semibold text-gray-600 dark:text-gray-300">
                        <span>Total Plan de Estudios:</span>
                        <span>{{ $totalCourses }} Asignaturas &bull; {{ $totalCredits }} Créditos &bull; {{ $totalHours }} Horas</span>
                    </div>
                </div>

                <!-- Right: Cohortes de Ingreso (5 Cols) -->
                <div class="lg:col-span-5 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="calendar" class="w-5 h-5 me-2 text-indigo-600 dark:text-indigo-400"></i>
                                    Cohortes de Ingreso (Por Año)
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Evolución histórica de estudiantes por fecha de admisión.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3 mt-4">
                            @if (empty($cohorts))
                                <div class="p-6 text-center text-xs text-gray-400 bg-gray-50 dark:bg-gray-900/30 rounded-2xl">
                                    No hay registros de cohortes disponibles.
                                </div>
                            @else
                                @foreach ($cohorts as $cYear => $cCount)
                                    @php
                                        $cPct = $totalStudents > 0 ? round(($cCount / $totalStudents) * 100, 1) : 0;
                                    @endphp
                                    <div>
                                        <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                            <span class="text-gray-800 dark:text-gray-200">Promoción / Admisión {{ $cYear }}</span>
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $cCount }} estudiantes ({{ $cPct }}%)</span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-300" style="width: {{ $cPct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 mt-6 border-t border-gray-100 dark:border-gray-700/60 text-[11px] text-gray-400 text-center">
                        Seguimiento por promoción y cohorte institucional
                    </div>
                </div>
            </div>

            <!-- 5. Row 4: Priority Action: Aptos para Titular & Recent Activity (2 Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Estudiantes Aptos para Titular (7 Cols) -->
                <div class="lg:col-span-7 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-indigo-200 dark:border-indigo-900/60 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="check-square" class="w-5 h-5 me-2 text-indigo-600 dark:text-indigo-400"></i>
                                    Estudiantes Aptos para Titulación Inmediata
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Estudiantes que cumplieron el 100% de la malla curricular y los 3 módulos EFSRT.
                                </p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300">
                                {{ $aptosStudents->count() }} de {{ $aptosCount }}
                            </span>
                        </div>

                        @if ($aptosStudents->isEmpty())
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                                Actualmente no hay estudiantes con condición de Apto pendientes de titulación.
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach ($aptosStudents as $aptStudent)
                                    <div class="p-3.5 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-200/80 dark:border-indigo-800/50 flex items-center justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="text-xs font-bold text-gray-900 dark:text-white truncate">
                                                {{ $aptStudent->paternal_last_name }} {{ $aptStudent->maternal_last_name }}, {{ $aptStudent->first_name }}
                                            </div>
                                            <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-mono">
                                                DNI: {{ $aptStudent->dni }} &bull; Código: {{ $aptStudent->student_code }}
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('graduation.index', ['search' => $aptStudent->dni]) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition">
                                                <i data-feather="award" class="w-3.5 h-3.5 me-1"></i>
                                                <span>Titular</span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Accesos Rápidos de Administración (5 Cols) -->
                <div class="lg:col-span-5 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                                    <i data-feather="zap" class="w-5 h-5 me-2 text-amber-500"></i>
                                    Accesos Rápidos del Sistema
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Acceso directo a las herramientas principales de gestión.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 gap-3 mt-4">
                            @if (Auth::user()->isAdmin())
                                <!-- Admin: Usuarios -->
                                <a href="{{ route('users.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-indigo-50 dark:bg-indigo-950/60 rounded-xl text-indigo-600 dark:text-indigo-400 w-fit mb-2">
                                        <i data-feather="shield" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-indigo-600">Usuarios y Claves</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Control de accesos</span>
                                </a>

                                <!-- Admin: Estudiantes -->
                                <a href="{{ route('students.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-blue-50 dark:bg-blue-950/60 rounded-xl text-blue-600 dark:text-blue-400 w-fit mb-2">
                                        <i data-feather="users" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-blue-600">Estudiantes</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Gestión y CSV</span>
                                </a>

                                <!-- Admin: Plana Docente -->
                                <a href="{{ route('teachers.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-purple-50 dark:bg-purple-950/60 rounded-xl text-purple-600 dark:text-purple-400 w-fit mb-2">
                                        <i data-feather="user-plus" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-purple-600">Plana Docente</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Gestión y CSV</span>
                                </a>

                                <!-- Admin: Mallas Curriculares -->
                                <a href="{{ route('curriculums.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-emerald-50 dark:bg-emerald-950/60 rounded-xl text-emerald-600 dark:text-emerald-400 w-fit mb-2">
                                        <i data-feather="grid" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-emerald-600">Mallas Curriculares</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Planes y cursos</span>
                                </a>

                                <!-- Admin: Cursos -->
                                <a href="{{ route('courses.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-amber-50 dark:bg-amber-950/60 rounded-xl text-amber-600 dark:text-amber-400 w-fit mb-2">
                                        <i data-feather="book-open" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-amber-600">Catálogo Cursos</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Gestión y CSV</span>
                                </a>

                                <!-- Admin: EFSRT -->
                                <a href="{{ route('efsrts.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-cyan-50 dark:bg-cyan-950/60 rounded-xl text-cyan-600 dark:text-cyan-400 w-fit mb-2">
                                        <i data-feather="briefcase" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-cyan-600">Módulos EFSRT</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Prácticas</span>
                                </a>
                            @else
                                <!-- Docente: Estudiantes -->
                                <a href="{{ route('students.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-indigo-50 dark:bg-indigo-950/60 rounded-xl text-indigo-600 dark:text-indigo-400 w-fit mb-2">
                                        <i data-feather="users" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-indigo-600">Estudiantes</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Registro e importación</span>
                                </a>

                                <!-- Docente: Seguimiento de Titulación -->
                                <a href="{{ route('graduation.index') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-pink-50 dark:bg-pink-950/60 rounded-xl text-pink-600 dark:text-pink-400 w-fit mb-2">
                                        <i data-feather="award" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-pink-600">Seguimiento</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Control de titulación</span>
                                </a>

                                <!-- Docente: Alumnos Aptos -->
                                <a href="{{ route('graduation.index', ['status' => 'Apto']) }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-emerald-50 dark:bg-emerald-950/60 rounded-xl text-emerald-600 dark:text-emerald-400 w-fit mb-2">
                                        <i data-feather="check-circle" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-emerald-600">Alumnos Aptos</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Listos para titular</span>
                                </a>

                                <!-- Docente: Mi Perfil -->
                                <a href="{{ route('profile.edit') }}" class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 transition group flex flex-col justify-between">
                                    <div class="p-2 bg-purple-50 dark:bg-purple-950/60 rounded-xl text-purple-600 dark:text-purple-400 w-fit mb-2">
                                        <i data-feather="user" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-purple-600">Mi Perfil</span>
                                    <span class="text-[10px] text-gray-400 mt-0.5">Datos y cuenta</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
