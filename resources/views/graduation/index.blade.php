<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span>{{ __("Seguimiento de Titulación") }}</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Control de avance curricular, módulos de prácticas (EFSRT) y estado de graduación de los estudiantes.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Alert -->
            @if (session("success"))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-xl dark:bg-emerald-950/40 dark:text-emerald-300 shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm font-medium">{{ session("success") }}</p>
                    </div>
                </div>
            @endif

            <!-- Quick Metrics Dashboard Banner -->
            @php
                $totalCount = $students->count();
                $tituladosCount = $students->where("overall_status", "Titulado")->count();
                $aptosCount = $students->where("overall_status", "Apto")->count();
                $enProcesoCount = $students->where("overall_status", "En Proceso")->count();
                $sinMallaCount = $students->where("overall_status", "Sin Malla")->count();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
                <!-- Card 1: Total -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex items-center justify-between">
                    <div class="min-w-0">
                        <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block truncate">Total Alumnos</span>
                        <div class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $totalCount }}</div>
                    </div>
                    <div class="p-2.5 bg-gray-100 dark:bg-gray-700/70 rounded-xl text-gray-600 dark:text-gray-300 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Aptos -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-indigo-200 dark:border-indigo-900/60 flex items-center justify-between">
                    <div class="min-w-0">
                        <span class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider block truncate">Aptos Titular</span>
                        <div class="text-2xl font-black text-indigo-700 dark:text-indigo-300 mt-1">{{ $aptosCount }}</div>
                    </div>
                    <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Titulados -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-emerald-200 dark:border-emerald-900/60 flex items-center justify-between">
                    <div class="min-w-0">
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider block truncate">Titulados</span>
                        <div class="text-2xl font-black text-emerald-700 dark:text-emerald-300 mt-1">{{ $tituladosCount }}</div>
                    </div>
                    <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/50 rounded-xl text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>

                <!-- Card 4: En Proceso -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-amber-200 dark:border-amber-900/60 flex items-center justify-between">
                    <div class="min-w-0">
                        <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider block truncate">En Proceso</span>
                        <div class="text-2xl font-black text-amber-700 dark:text-amber-300 mt-1">{{ $enProcesoCount }}</div>
                    </div>
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-950/50 rounded-xl text-amber-600 dark:text-amber-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Card 5: Sin Malla -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 flex items-center justify-between">
                    <div class="min-w-0">
                        <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block truncate">Sin Malla</span>
                        <div class="text-2xl font-black text-gray-700 dark:text-gray-300 mt-1">{{ $sinMallaCount }}</div>
                    </div>
                    <div class="p-2.5 bg-gray-100 dark:bg-gray-700/70 rounded-xl text-gray-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filters Panel -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 p-5">
                <form method="GET" action="{{ route('graduation.index') }}" class="space-y-4">
                    <!-- Quick status filter chips -->
                    <div class="flex flex-wrap items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-700/70">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider me-2">Filtrar por:</span>
                        <a href="{{ route('graduation.index', array_merge(request()->except('status'), ['status' => ''])) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ empty($status) ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-700/80 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            Todos ({{ $totalCount }})
                        </a>
                        <a href="{{ route('graduation.index', array_merge(request()->except('status'), ['status' => 'Apto'])) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ $status === 'Apto' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/60 hover:bg-indigo-100 dark:hover:bg-indigo-900/50' }}">
                            Solo Aptos ({{ $aptosCount }})
                        </a>
                        <a href="{{ route('graduation.index', array_merge(request()->except('status'), ['status' => 'En Proceso'])) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ $status === 'En Proceso' ? 'bg-amber-600 text-white shadow-sm' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60 hover:bg-amber-100 dark:hover:bg-amber-900/50' }}">
                            En Proceso ({{ $enProcesoCount }})
                        </a>
                        <a href="{{ route('graduation.index', array_merge(request()->except('status'), ['status' => 'Titulado'])) }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ $status === 'Titulado' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/50' }}">
                            Titulados ({{ $tituladosCount }})
                        </a>
                    </div>

                    <!-- Input Filters Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <!-- Search input -->
                        <div>
                            <label for="search" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Buscar Estudiante</label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ $search }}" placeholder="DNI, Código o Nombre..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 ps-9 py-2.5 shadow-sm" />
                                <div class="absolute inset-y-0 left-0 ps-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Curriculum filter -->
                        <div>
                            <label for="curriculum_id" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Malla Curricular</label>
                            <select id="curriculum_id" name="curriculum_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm">
                                <option value="">Todas las Mallas</option>
                                @foreach ($curriculums as $c)
                                    <option value="{{ $c->id }}" {{ $curriculumId == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->year }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Shift filter -->
                        <div>
                            <label for="shift" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Turno</label>
                            <select id="shift" name="shift" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 py-2.5 shadow-sm">
                                <option value="">Todos los Turnos</option>
                                <option value="Diurno (Mañana)" {{ $shift == 'Diurno (Mañana)' ? 'selected' : '' }}>Diurno (Mañana)</option>
                                <option value="Diurno (Tarde)" {{ $shift == 'Diurno (Tarde)' ? 'selected' : '' }}>Diurno (Tarde)</option>
                                <option value="Nocturno (Noche)" {{ $shift == 'Nocturno (Noche)' ? 'selected' : '' }}>Nocturno (Noche)</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="status" value="{{ $status }}" />
                            <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Aplicar Filtros
                            </button>
                            @if ($search || $curriculumId || $shift || $status)
                                <a href="{{ route('graduation.index') }}" class="px-3 py-2.5 text-xs font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 underline" title="Limpiar todos los filtros">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Students Tracking List -->
            <div class="space-y-4">
                @if ($students->isEmpty())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl p-12 text-center border border-gray-200 dark:border-gray-700/80">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700/70 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">No se encontraron estudiantes</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                            No hay registros que coincidan con los criterios de búsqueda o filtros seleccionados.
                        </p>
                    </div>
                @else
                    @foreach ($students as $student)
                        @php
                            $st = $student->overall_status;
                            $curriculum = $student->curriculum;
                            $totalCourses = $curriculum ? $curriculum->courses->count() : 0;
                            $pendingCount = $student->pendingCourses()->count();
                            $approvedCount = $totalCourses - $pendingCount;
                            $percentage = $totalCourses > 0 ? round(($approvedCount / $totalCourses) * 100) : 0;

                            $initials = mb_substr($student->first_name, 0, 1) . mb_substr($student->paternal_last_name, 0, 1);
                        @endphp

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 hover:border-indigo-300 dark:hover:border-indigo-700/60 transition duration-150 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-5 items-center">
                                
                                <!-- 1. Student Identity (xl: 4 cols) -->
                                <div class="xl:col-span-4 flex items-start space-x-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                                        {{ strtoupper($initials) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate" title="{{ $student->full_name }}">
                                            {{ $student->paternal_last_name }} {{ $student->maternal_last_name }}, {{ $student->first_name }}
                                        </h3>
                                        <div class="mt-1 flex flex-wrap items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700/70 text-gray-700 dark:text-gray-300 font-mono text-[11px]">
                                                DNI: {{ $student->dni }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700/70 text-gray-700 dark:text-gray-300 font-mono text-[11px]">
                                                {{ $student->student_code }}
                                            </span>
                                        </div>
                                        <div class="mt-1 text-[11px] truncate {{ $curriculum ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-amber-600 dark:text-amber-400 font-medium' }}">
                                            {{ $curriculum ? "Malla: {$curriculum->name} ({$curriculum->year})" : "Sin Malla asignada" }}
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Course Progress Bar (xl: 3 cols) -->
                                <div class="xl:col-span-3 flex flex-col justify-center space-y-1.5">
                                    @if ($curriculum)
                                        <div class="flex items-center justify-between text-xs font-semibold">
                                            <span class="text-gray-600 dark:text-gray-300">Cursos / Unidades</span>
                                            <span id="pending-count-{{ $student->id }}" class="font-bold {{ $pendingCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                                {{ $approvedCount }}/{{ $totalCourses }} ({{ $percentage }}%)
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                                            <div id="progress-bar-{{ $student->id }}" class="h-full rounded-full transition-all duration-300 {{ $percentage == 100 ? 'bg-emerald-500' : 'bg-indigo-600' }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400">
                                            <span>{{ $pendingCount }} pendientes</span>
                                            <span class="truncate max-w-[130px]" title="Turno: {{ $student->shift ?? 'No asignado' }}">
                                                {{ $student->shift ? "Turno: {$student->shift}" : "" }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-400 dark:text-gray-500 italic py-2">
                                            Requiere asignación de Malla
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. EFSRT Modules (xl: 3 cols) -->
                                <div class="xl:col-span-3 flex flex-col items-start xl:items-center justify-center">
                                    <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                        Módulos Prácticas EFSRT
                                    </span>
                                    <div class="flex items-center gap-2">
                                        @if ($curriculum)
                                            @foreach ($student->efsrtStatusList() as $efs)
                                                @php
                                                    if (preg_match('/\b(III|II|IV|VI|V|I)\b/i', $efs['module'], $matches)) {
                                                        $shortModule = strtoupper($matches[1]);
                                                    } else {
                                                        $shortModule = 'M' . $loop->iteration;
                                                    }
                                                @endphp
                                                <button type="button" 
                                                        class="efsrt-indicator-btn group relative flex items-center justify-center w-8 h-8 rounded-full border transition duration-150 hover:scale-110 focus:outline-none"
                                                        data-student-id="{{ $student->id }}"
                                                        data-student-name="{{ $student->full_name }}"
                                                        data-efsrt-id="{{ $efs['id'] }}"
                                                        data-efsrt-module="{{ $efs['module'] }}"
                                                        data-efsrt-name="{{ $efs['module_name'] }}"
                                                        data-required-hours="{{ $efs['hours'] ?? '' }}"
                                                        data-period="{{ $efs['period'] ?? '' }}"
                                                        data-lines="{{ json_encode($efs['practice_lines'] ?? []) }}"
                                                        data-practice-line="{{ $efs['pivot'] ? $efs['pivot']->practice_line : '' }}"
                                                        data-activities="{{ $efs['pivot'] ? $efs['pivot']->activities : '' }}"
                                                        data-company="{{ $efs['pivot'] ? $efs['pivot']->company_name : '' }}"
                                                        data-hours="{{ $efs['pivot'] ? $efs['pivot']->hours : '' }}"
                                                        data-start="{{ $efs['pivot'] ? $efs['pivot']->start_date : '' }}"
                                                        data-end="{{ $efs['pivot'] ? $efs['pivot']->end_date : '' }}"
                                                        data-status="{{ $efs['status'] }}"
                                                        title="{{ $efs['module'] }}: {{ $efs['module_name'] }} (Clic para gestionar)">
                                                    
                                                    @if ($efs['status'] == 'approved')
                                                        <span class="absolute inset-0 bg-emerald-100 dark:bg-emerald-950/60 border-2 border-emerald-500 rounded-full"></span>
                                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @elseif ($efs['status'] == 'rejected')
                                                        <span class="absolute inset-0 bg-red-100 dark:bg-red-950/60 border-2 border-red-500 rounded-full"></span>
                                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    @else
                                                        <span class="absolute inset-0 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full group-hover:border-indigo-400"></span>
                                                        <span class="text-[11px] font-bold font-mono text-gray-500 dark:text-gray-400 z-10">{{ $shortModule }}</span>
                                                    @endif
                                                </button>
                                            @endforeach
                                        @else
                                            <span class="text-xs text-gray-400">Sin prácticas</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- 4. Status & Action Buttons (xl: 2 cols) -->
                                <div class="xl:col-span-2 flex flex-row xl:flex-col items-center xl:items-end justify-between xl:justify-center gap-2">
                                    <div>
                                        @php
                                            $badgeClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                            if ($st == 'Titulado') {
                                                $badgeClass = 'bg-emerald-600 text-white shadow-emerald-500/20';
                                            } elseif ($st == 'Apto') {
                                                $badgeClass = 'bg-indigo-600 text-white shadow-indigo-500/20 ring-2 ring-indigo-400/40 ring-offset-2 dark:ring-offset-gray-800 animate-pulse';
                                            } elseif ($st == 'En Proceso') {
                                                $badgeClass = 'bg-amber-500 text-white shadow-amber-500/20';
                                            }
                                        @endphp
                                        <span id="status-badge-{{ $student->id }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm {{ $badgeClass }}">
                                            {{ $st }}
                                        </span>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        @if ($curriculum)
                                            <button type="button" 
                                                    class="open-courses-modal-btn inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/80 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 transition shadow-sm focus:outline-none"
                                                    data-student-id="{{ $student->id }}">
                                                <svg class="w-3.5 h-3.5 me-1 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                </svg>
                                                <span>Ver Cursos</span>
                                            </button>
                                        @endif

                                        <button type="button" 
                                                id="titular-btn-{{ $student->id }}"
                                                class="titular-btn {{ $st == 'Apto' ? '' : 'hidden' }} inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-md transition duration-150"
                                                data-student-id="{{ $student->id }}"
                                                data-student-name="{{ $student->full_name }}">
                                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                            Titular
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Large Courses Modal for Student -->
                        @if ($curriculum)
                            <div id="courses-modal-{{ $student->id }}" class="courses-modal fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="courses-modal-title-{{ $student->id }}" role="dialog" aria-modal="true" x-data="{ activePeriod: 'all' }">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                    <!-- Background overlay -->
                                    <div class="courses-modal-overlay fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" data-student-id="{{ $student->id }}"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <!-- Modal Box -->
                                    <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-4xl lg:max-w-5xl w-full border border-gray-200 dark:border-gray-700">
                                        <!-- Modal Header -->
                                        <div class="px-6 py-5 bg-gray-50 dark:bg-gray-900/60 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="flex items-center space-x-3.5">
                                                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                                                    {{ strtoupper($initials) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100" id="courses-modal-title-{{ $student->id }}">
                                                        Unidades Didácticas: {{ $student->full_name }}
                                                    </h3>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        Malla: <strong>{{ $curriculum->name }} ({{ $curriculum->year }})</strong> &bull; DNI: <span class="font-mono">{{ $student->dni }}</span> &bull; Código: <span class="font-mono">{{ $student->student_code }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center space-x-2 text-xs font-semibold me-2">
                                                    <button type="button" class="bulk-courses-btn text-indigo-600 dark:text-indigo-400 hover:underline" data-student-id="{{ $student->id }}" data-action="approve_all">Marcar todo</button>
                                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                                    <button type="button" class="bulk-courses-btn text-gray-500 dark:text-gray-400 hover:underline" data-student-id="{{ $student->id }}" data-action="clear_all">Desmarcar todo</button>
                                                </div>
                                                <button type="button" class="close-courses-modal-btn text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none" data-student-id="{{ $student->id }}">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Period Quick Navigation Tabs -->
                                        @php
                                            $groupedCourses = $curriculum->courses->groupBy("period");
                                            $periodsOrder = ["I", "II", "III", "IV", "V", "VI"];
                                        @endphp
                                        <div class="px-6 py-2.5 bg-gray-100/70 dark:bg-gray-900/40 border-b border-gray-200 dark:border-gray-700/80 flex flex-wrap items-center gap-1.5">
                                            <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider me-2">Periodo:</span>
                                            <button type="button" @click="activePeriod = 'all'" :class="activePeriod === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50'" class="px-2.5 py-1 rounded-md text-xs font-semibold transition">
                                                Todos (VI)
                                            </button>
                                            @foreach ($periodsOrder as $p)
                                                @if (isset($groupedCourses[$p]))
                                                    <button type="button" @click="activePeriod = '{{ $p }}'" :class="activePeriod === '{{ $p }}' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50'" class="px-2.5 py-1 rounded-md text-xs font-semibold transition">
                                                        Periodo {{ $p }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>

                                        <!-- Modal Body: Periods Grid -->
                                        <div class="p-6 max-h-[65vh] overflow-y-auto">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                                @foreach ($periodsOrder as $periodName)
                                                    @if (isset($groupedCourses[$periodName]))
                                                        <div x-show="activePeriod === 'all' || activePeriod === '{{ $periodName }}'" class="bg-gray-50 dark:bg-gray-900/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700/80 flex flex-col justify-between shadow-sm">
                                                            <div>
                                                                <div class="border-b border-gray-200 dark:border-gray-700 pb-2 mb-3 flex items-center justify-between">
                                                                    <span class="font-bold text-xs text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">Periodo {{ $periodName }}</span>
                                                                    <span class="flex items-center space-x-1 font-semibold text-[11px]">
                                                                        <button type="button" class="bulk-courses-btn text-blue-600 dark:text-blue-400 hover:underline" data-student-id="{{ $student->id }}" data-period="{{ $periodName }}" data-action="approve_period">Todo</button>
                                                                        <span class="text-gray-300 dark:text-gray-600">|</span>
                                                                        <button type="button" class="bulk-courses-btn text-gray-500 dark:text-gray-400 hover:underline" data-student-id="{{ $student->id }}" data-period="{{ $periodName }}" data-action="clear_period">Nada</button>
                                                                    </span>
                                                                </div>
                                                                <ul class="space-y-3">
                                                                    @foreach ($groupedCourses[$periodName]->sortBy("code") as $course)
                                                                        @php
                                                                            $isCompleted = $student->courses->contains($course->id);
                                                                        @endphp
                                                                        <li class="p-2.5 rounded-lg border transition {{ $isCompleted ? 'bg-emerald-50/60 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-900/40' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-indigo-300' }}">
                                                                            <div class="flex items-start">
                                                                                <div class="flex items-center h-5 mt-0.5">
                                                                                    <input type="checkbox" 
                                                                                           id="chk-{{ $student->id }}-{{ $course->id }}" 
                                                                                           class="course-checkbox h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                                                                           data-student-id="{{ $student->id }}"
                                                                                           data-course-id="{{ $course->id }}"
                                                                                           data-period="{{ $periodName }}"
                                                                                           {{ $isCompleted ? 'checked' : '' }} />
                                                                                </div>
                                                                                <div class="ms-3 text-xs flex-1">
                                                                                    <label for="chk-{{ $student->id }}-{{ $course->id }}" class="font-semibold text-gray-800 dark:text-gray-200 cursor-pointer select-none block leading-tight">
                                                                                        {{ $course->name }}
                                                                                    </label>
                                                                                    <div class="mt-1 flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400 font-mono">
                                                                                        <span>{{ $course->code }}</span>
                                                                                        <span class="font-sans px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-[10px] font-semibold text-gray-600 dark:text-gray-300">{{ $course->credits }} Cr &bull; {{ $course->hours }}h</span>
                                                                                    </div>
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

                                        <!-- Modal Footer -->
                                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/60 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Las asignaturas marcadas se guardan de forma instantánea en la base de datos.
                                            </div>
                                            <button type="button" class="close-courses-modal-btn inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150" data-student-id="{{ $student->id }}">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- EFSRT Modal Form -->
    <div id="efsrt-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div id="efsrt-modal-overlay" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <form id="efsrt-modal-form" method="POST" action="">
                    @csrf
                    <div class="p-6">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700 mb-5">
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 flex items-center" id="modal-title">
                                <svg class="w-5 h-5 me-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Registrar Módulo de Práctica (EFSRT)
                            </h3>
                            <button type="button" class="close-modal-btn text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Read-only header information -->
                        <div class="mb-4 bg-gray-50 dark:bg-gray-900/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-800 text-xs space-y-1.5">
                            <div><span class="text-gray-500 dark:text-gray-400">Estudiante:</span> <strong id="modal-student-name" class="text-gray-900 dark:text-gray-100"></strong></div>
                            <div><span class="text-gray-500 dark:text-gray-400">Módulo:</span> <strong id="modal-efsrt-module" class="text-gray-900 dark:text-gray-100"></strong></div>
                            <div class="flex items-center justify-between pt-1 text-indigo-600 dark:text-indigo-400 font-semibold border-t border-gray-200/60 dark:border-gray-700/60">
                                <span id="modal-efsrt-period"></span>
                                <span id="modal-efsrt-req-hours"></span>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4">
                            <!-- Practice Line Selector / Input -->
                            <div>
                                <label for="modal-practice-line" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Línea de Práctica Formatíva
                                </label>
                                <select id="modal-practice-line" name="practice_line" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm mb-1.5">
                                    <option value="">-- Seleccionar Línea de Práctica --</option>
                                </select>
                                <input type="text" id="modal-practice-line-custom" placeholder="O especifique otra línea de práctica..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" style="display: none;" />
                            </div>

                            <!-- Activities Selector / Options -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        Actividad Formativa Realizada
                                    </label>
                                    <span class="text-[11px] text-gray-500 dark:text-gray-400">Seleccione la actividad del estudiante</span>
                                </div>
                                <div id="modal-activities-list" class="space-y-2 mb-2 p-2 rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 min-h-[50px]">
                                    <!-- Dynamic radio buttons for individual activities inserted here by JS -->
                                </div>
                                <input type="text" id="modal-activities-custom" placeholder="O redactar actividad personalizada..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" style="display: none;" />
                                <input type="hidden" id="modal-activities" name="activities" value="" />
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Nombre de la Empresa</label>
                                <input type="text" id="company_name" name="company_name" placeholder="Ej. Soluciones Web SAC" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" />
                            </div>

                            <!-- Hours and Status in a 2-column grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="hours" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Horas Acumuladas</label>
                                    <input type="number" id="hours" name="hours" min="0" placeholder="Ej. 96" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" />
                                </div>
                                <div>
                                    <label for="modal-status-select" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Estado</label>
                                    <select id="modal-status-select" name="status" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                        <option value="pending">Pendiente</option>
                                        <option value="approved">Aprobado</option>
                                        <option value="rejected">Rechazado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dates in a 2-column grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="start_date" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Fecha Inicio</label>
                                    <input type="date" id="start_date" name="start_date" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" />
                                </div>
                                <div>
                                    <label for="end_date" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Fecha Fin</label>
                                    <input type="date" id="end_date" name="end_date" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/40 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" class="close-modal-btn inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            Guardar Práctica
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Titulación Modal Form -->
    <div id="titular-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="titular-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div id="titular-modal-overlay" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <form id="titular-modal-form" method="POST" action="">
                    @csrf
                    <div class="p-6">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700 mb-5">
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 flex items-center" id="titular-modal-title">
                                <svg class="w-5 h-5 me-2 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                                Registrar Titulación
                            </h3>
                            <button type="button" class="close-titular-modal-btn text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Info display -->
                        <div class="mb-4 bg-emerald-50 dark:bg-emerald-950/40 p-3.5 rounded-xl border border-emerald-200 dark:border-emerald-800 text-xs">
                            <span class="text-emerald-800 dark:text-emerald-300">Estudiante Apto:</span> <strong id="titular-modal-student-name" class="text-emerald-900 dark:text-emerald-100 font-bold block mt-0.5"></strong>
                        </div>

                        <!-- Date selection -->
                        <div>
                            <label for="degree_date_input" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">Fecha de Titulación</label>
                            <input type="date" id="degree_date_input" name="degree_date" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/40 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" class="close-titular-modal-btn inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            Confirmar Titulación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Client-side Interactive Logic -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Large Courses Modal Toggle
            document.addEventListener("click", function(e) {
                const openBtn = e.target.closest(".open-courses-modal-btn");
                if (openBtn) {
                    const studentId = openBtn.dataset.studentId;
                    const modal = document.getElementById("courses-modal-" + studentId);
                    if (modal) {
                        modal.classList.remove("hidden");
                        document.body.classList.add("overflow-hidden");
                    }
                    return;
                }

                const closeBtn = e.target.closest(".close-courses-modal-btn");
                if (closeBtn) {
                    const studentId = closeBtn.dataset.studentId;
                    const modal = document.getElementById("courses-modal-" + studentId) || closeBtn.closest(".courses-modal");
                    if (modal) {
                        modal.classList.add("hidden");
                        document.body.classList.remove("overflow-hidden");
                    }
                    return;
                }

                const overlay = e.target.closest(".courses-modal-overlay");
                if (overlay) {
                    const studentId = overlay.dataset.studentId;
                    const modal = document.getElementById("courses-modal-" + studentId) || overlay.closest(".courses-modal");
                    if (modal) {
                        modal.classList.add("hidden");
                        document.body.classList.remove("overflow-hidden");
                    }
                    return;
                }
            });

            // 2. AJAX Course Toggling
            const courseCheckboxes = document.querySelectorAll(".course-checkbox");
            courseCheckboxes.forEach(chk => {
                chk.addEventListener("change", function() {
                    const studentId = this.dataset.studentId;
                    const courseId = this.dataset.courseId;
                    
                    this.disabled = true;

                    fetch(`/graduation/${studentId}/toggle-course/${courseId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.disabled = false;
                        if (data.success) {
                            // Update container li styling
                            const li = this.closest("li");
                            if (li) {
                                if (data.attached) {
                                    li.className = "p-2.5 rounded-lg border transition bg-emerald-50/60 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-900/40";
                                } else {
                                    li.className = "p-2.5 rounded-lg border transition bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-indigo-300";
                                }
                            }

                            // Update pending counter text
                            const counterEl = document.getElementById(`pending-count-${studentId}`);
                            if (counterEl) {
                                const total = document.querySelectorAll(`.course-checkbox[data-student-id="${studentId}"]`).length;
                                const approved = total - data.pending_count;
                                const pct = total > 0 ? Math.round((approved / total) * 100) : 0;

                                counterEl.innerText = `${approved}/${total} (${pct}%)`;
                                if (data.pending_count > 0) {
                                    counterEl.className = "font-bold text-amber-600 dark:text-amber-400";
                                } else {
                                    counterEl.className = "font-bold text-emerald-600 dark:text-emerald-400";
                                }

                                const pBar = document.getElementById(`progress-bar-${studentId}`);
                                if (pBar) {
                                    pBar.style.width = `${pct}%`;
                                    pBar.className = `h-full rounded-full transition-all duration-300 ${pct === 100 ? 'bg-emerald-500' : 'bg-indigo-600'}`;
                                }
                            }

                            // Update status badge
                            const badgeEl = document.getElementById(`status-badge-${studentId}`);
                            if (badgeEl) {
                                badgeEl.innerText = data.overall_status;
                                let badgeClass = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm ";
                                if (data.overall_status === "Titulado") {
                                    badgeClass += "bg-emerald-600 text-white shadow-emerald-500/20";
                                } else if (data.overall_status === "Apto") {
                                    badgeClass += "bg-indigo-600 text-white shadow-indigo-500/20 ring-2 ring-indigo-400/40 ring-offset-2 dark:ring-offset-gray-800 animate-pulse";
                                } else if (data.overall_status === "En Proceso") {
                                    badgeClass += "bg-amber-500 text-white shadow-amber-500/20";
                                } else {
                                    badgeClass += "bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300";
                                }
                                badgeEl.className = badgeClass;
                            }

                            // Show/hide titular button
                            const titularBtn = document.getElementById(`titular-btn-${studentId}`);
                            if (titularBtn) {
                                if (data.overall_status === "Apto") {
                                    titularBtn.classList.remove("hidden");
                                } else {
                                    titularBtn.classList.add("hidden");
                                }
                            }

                            if (window.showToast) {
                                window.showToast(data.attached ? "Curso marcado como aprobado." : "Curso desmarcado (pendiente).", "info");
                            }
                        }
                    })
                    .catch(err => {
                        this.disabled = false;
                        console.error("Error toggling course status:", err);
                        this.checked = !this.checked;
                        if (window.showToast) {
                            window.showToast("Error al actualizar el estado del curso.", "error");
                        }
                    });
                });
            });

            // 2.1 Bulk Course Operations (Select All / Clear All / Period)
            const bulkButtons = document.querySelectorAll(".bulk-courses-btn");
            bulkButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    const studentId = this.dataset.studentId;
                    const action = this.dataset.action;
                    const period = this.dataset.period || null;

                    bulkButtons.forEach(b => { if (b.dataset.studentId === studentId) b.disabled = true; });

                    fetch(`/graduation/${studentId}/bulk-courses`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            action: action,
                            period: period
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        bulkButtons.forEach(b => { if (b.dataset.studentId === studentId) b.disabled = false; });

                        if (data.success) {
                            // Update checkboxes from backend approved_ids list
                            const approvedIds = (data.approved_ids || []).map(id => parseInt(id));
                            const checkboxes = document.querySelectorAll(`.course-checkbox[data-student-id="${studentId}"]`);

                            checkboxes.forEach(chk => {
                                const courseId = parseInt(chk.dataset.courseId);
                                const isApproved = approvedIds.includes(courseId);
                                chk.checked = isApproved;

                                const li = chk.closest("li");
                                if (li) {
                                    if (isApproved) {
                                        li.className = "p-2.5 rounded-lg border transition bg-emerald-50/60 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-900/40";
                                    } else {
                                        li.className = "p-2.5 rounded-lg border transition bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-indigo-300";
                                    }
                                }
                            });

                            // Update counter and progress
                            const total = checkboxes.length;
                            const approved = total - data.pending_count;
                            const pct = total > 0 ? Math.round((approved / total) * 100) : 0;

                            const counterEl = document.getElementById(`pending-count-${studentId}`);
                            if (counterEl) {
                                counterEl.innerText = `${approved}/${total} (${pct}%)`;
                                if (data.pending_count > 0) {
                                    counterEl.className = "font-bold text-amber-600 dark:text-amber-400";
                                } else {
                                    counterEl.className = "font-bold text-emerald-600 dark:text-emerald-400";
                                }
                            }

                            const pBar = document.getElementById(`progress-bar-${studentId}`);
                            if (pBar) {
                                pBar.style.width = `${pct}%`;
                                pBar.className = `h-full rounded-full transition-all duration-300 ${pct === 100 ? 'bg-emerald-500' : 'bg-indigo-600'}`;
                            }

                            const badgeEl = document.getElementById(`status-badge-${studentId}`);
                            if (badgeEl) {
                                badgeEl.innerText = data.overall_status;
                                let badgeClass = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm ";
                                if (data.overall_status === "Titulado") {
                                    badgeClass += "bg-emerald-600 text-white shadow-emerald-500/20";
                                } else if (data.overall_status === "Apto") {
                                    badgeClass += "bg-indigo-600 text-white shadow-indigo-500/20 ring-2 ring-indigo-400/40 ring-offset-2 dark:ring-offset-gray-800 animate-pulse";
                                } else if (data.overall_status === "En Proceso") {
                                    badgeClass += "bg-amber-500 text-white shadow-amber-500/20";
                                } else {
                                    badgeClass += "bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300";
                                }
                                badgeEl.className = badgeClass;
                            }

                            const titularBtn = document.getElementById(`titular-btn-${studentId}`);
                            if (titularBtn) {
                                if (data.overall_status === "Apto") {
                                    titularBtn.classList.remove("hidden");
                                } else {
                                    titularBtn.classList.add("hidden");
                                }
                            }

                            if (window.showToast) {
                                window.showToast("Cursos actualizados exitosamente.", "success");
                            }
                        }
                    })
                    .catch(err => {
                        bulkButtons.forEach(b => { if (b.dataset.studentId === studentId) b.disabled = false; });
                        console.error("Error during bulk course updates:", err);
                        if (window.showToast) {
                            window.showToast("Error al procesar la actualización masiva de cursos.", "error");
                        }
                    });
                });
            });

            // 3. EFSRT Modal Logic
            const modal = document.getElementById("efsrt-modal");
            const modalForm = document.getElementById("efsrt-modal-form");
            const closeButtons = document.querySelectorAll(".close-modal-btn, #efsrt-modal-overlay");
            
            const indicatorButtons = document.querySelectorAll(".efsrt-indicator-btn");
            indicatorButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    const studentId = this.dataset.studentId;
                    const studentName = this.dataset.studentName;
                    const efsrtId = this.dataset.efsrtId;
                    const efsrtModule = this.dataset.efsrtModule;
                    const efsrtName = this.dataset.efsrtName || "";
                    const reqHours = this.dataset.requiredHours;
                    const period = this.dataset.period;
                    const currentLine = this.dataset.practiceLine || "";
                    const currentActivities = this.dataset.activities || "";
                    
                    let lines = [];
                    try {
                        lines = JSON.parse(this.dataset.lines || "[]");
                    } catch(e) {
                        lines = [];
                    }

                    const company = this.dataset.company;
                    const hours = this.dataset.hours;
                    const start = this.dataset.start;
                    const end = this.dataset.end;
                    const status = this.dataset.status;

                    modalForm.action = `/graduation/${studentId}/update-efsrt/${efsrtId}`;
                    
                    document.getElementById("modal-student-name").innerText = studentName;
                    document.getElementById("modal-efsrt-module").innerText = `${efsrtModule}: ${efsrtName}`;
                    document.getElementById("modal-efsrt-period").innerText = period ? `Periodo: ${period}` : "";
                    document.getElementById("modal-efsrt-req-hours").innerText = reqHours ? `Horas Requeridas: ${reqHours} hrs` : "";

                    // Populate practice lines dropdown & activities
                    const lineSelect = document.getElementById("modal-practice-line");
                    const customLineInput = document.getElementById("modal-practice-line-custom");
                    const customActInput = document.getElementById("modal-activities-custom");
                    const hiddenActInput = document.getElementById("modal-activities");
                    
                    lineSelect.innerHTML = '<option value="">-- Seleccionar Línea de Práctica --</option>';

                    let lineFound = false;
                    lines.forEach(item => {
                        const lineText = item.line || item.name || item;
                        const opt = document.createElement("option");
                        opt.value = lineText;
                        opt.textContent = lineText;
                        if (currentLine && currentLine === lineText) {
                            opt.selected = true;
                            lineFound = true;
                        }
                        lineSelect.appendChild(opt);
                    });

                    const customOpt = document.createElement("option");
                    customOpt.value = "custom";
                    customOpt.textContent = "-- Otra (especificar) --";
                    lineSelect.appendChild(customOpt);

                    if (currentLine && !lineFound) {
                        customOpt.selected = true;
                        customLineInput.style.display = "block";
                        customLineInput.value = currentLine;
                    } else {
                        customLineInput.style.display = "none";
                        customLineInput.value = "";
                    }

                    function updateActivitiesList(selectedLineText, preselectedAct) {
                        const listContainer = document.getElementById("modal-activities-list");
                        listContainer.innerHTML = "";

                        let foundLineObj = lines.find(l => (l.line || l.name || l) === selectedLineText);
                        let activitiesList = (foundLineObj && Array.isArray(foundLineObj.activities)) ? foundLineObj.activities : [];

                        if (activitiesList.length === 0) {
                            listContainer.innerHTML = '<p class="text-xs text-gray-400 italic p-1">No hay actividades predefinidas para esta línea. Ingrese la actividad abajo:</p>';
                            customActInput.style.display = "block";
                            customActInput.value = preselectedAct || "";
                            hiddenActInput.value = preselectedAct || "";
                            return;
                        }

                        let isCustomSelected = true;

                        activitiesList.forEach((actText, idx) => {
                            const row = document.createElement("label");
                            row.className = "flex items-start space-x-2 text-xs text-gray-700 dark:text-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800/60 p-1.5 rounded-lg transition border border-transparent hover:border-gray-200 dark:hover:border-gray-700";

                            const radio = document.createElement("input");
                            radio.type = "radio";
                            radio.name = "efsrt_activity_radio";
                            radio.value = actText;
                            radio.className = "mt-0.5 text-indigo-600 focus:ring-indigo-500";

                            if (preselectedAct && preselectedAct.trim() === actText.trim()) {
                                radio.checked = true;
                                isCustomSelected = false;
                                hiddenActInput.value = actText;
                            } else if (!preselectedAct && idx === 0) {
                                radio.checked = true;
                                isCustomSelected = false;
                                hiddenActInput.value = actText;
                            }

                            radio.onchange = function() {
                                if (this.checked) {
                                    hiddenActInput.value = this.value;
                                    customActInput.style.display = "none";
                                }
                            };

                            const span = document.createElement("span");
                            span.className = "leading-tight font-medium";
                            span.textContent = actText;

                            row.appendChild(radio);
                            row.appendChild(span);
                            listContainer.appendChild(row);
                        });

                        // Custom activity option
                        const customRow = document.createElement("label");
                        customRow.className = "flex items-center space-x-2 text-xs text-indigo-600 dark:text-indigo-400 font-semibold cursor-pointer p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800/60 transition";
                        
                        const customRadio = document.createElement("input");
                        customRadio.type = "radio";
                        customRadio.name = "efsrt_activity_radio";
                        customRadio.value = "custom";
                        customRadio.className = "text-indigo-600 focus:ring-indigo-500";

                        if (preselectedAct && isCustomSelected) {
                            customRadio.checked = true;
                            customActInput.style.display = "block";
                            customActInput.value = preselectedAct;
                            hiddenActInput.value = preselectedAct;
                        } else {
                            customActInput.style.display = "none";
                        }

                        customRadio.onchange = function() {
                            if (this.checked) {
                                customActInput.style.display = "block";
                                customActInput.focus();
                                hiddenActInput.value = customActInput.value;
                            }
                        };

                        customActInput.oninput = function() {
                            if (customRadio.checked) {
                                hiddenActInput.value = this.value;
                            }
                        };

                        const customSpan = document.createElement("span");
                        customSpan.textContent = "Otra actividad específica (redactar)";
                        customRow.appendChild(customRadio);
                        customRow.appendChild(customSpan);
                        listContainer.appendChild(customRow);
                    }

                    lineSelect.onchange = function() {
                        if (this.value === "custom") {
                            customLineInput.style.display = "block";
                            customLineInput.focus();
                            updateActivitiesList("", "");
                        } else {
                            customLineInput.style.display = "none";
                            updateActivitiesList(this.value, "");
                        }
                    };

                    updateActivitiesList(lineSelect.value, currentActivities);

                    document.getElementById("company_name").value = company || "";
                    document.getElementById("hours").value = hours || reqHours || "";
                    document.getElementById("start_date").value = start || "";
                    document.getElementById("end_date").value = end || "";
                    document.getElementById("modal-status-select").value = status || "pending";

                    modal.classList.remove("hidden");
                    document.body.classList.add("overflow-hidden");
                });
            });

            modalForm.addEventListener("submit", function() {
                const lineSelect = document.getElementById("modal-practice-line");
                const customLineInput = document.getElementById("modal-practice-line-custom");
                const customActInput = document.getElementById("modal-activities-custom");
                const hiddenActInput = document.getElementById("modal-activities");

                if (lineSelect.value === "custom" && customLineInput.value) {
                    const opt = document.createElement("option");
                    opt.value = customLineInput.value;
                    opt.textContent = customLineInput.value;
                    opt.selected = true;
                    lineSelect.appendChild(opt);
                }

                if (customActInput.style.display !== "none" && customActInput.value) {
                    hiddenActInput.value = customActInput.value;
                }
            });

            closeButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    modal.classList.add("hidden");
                    document.body.classList.remove("overflow-hidden");
                });
            });

            // 4. Titulación Modal Logic
            const titularModal = document.getElementById("titular-modal");
            const titularModalForm = document.getElementById("titular-modal-form");
            const closeTitularButtons = document.querySelectorAll(".close-titular-modal-btn, #titular-modal-overlay");
            
            document.addEventListener("click", function(e) {
                const btn = e.target.closest(".titular-btn");
                if (btn) {
                    const studentId = btn.dataset.studentId;
                    const studentName = btn.dataset.studentName;

                    titularModalForm.action = `/graduation/${studentId}/titular`;
                    document.getElementById("titular-modal-student-name").innerText = studentName;

                    titularModal.classList.remove("hidden");
                    document.body.classList.add("overflow-hidden");
                }
            });

            closeTitularButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    titularModal.classList.add("hidden");
                    document.body.classList.remove("overflow-hidden");
                });
            });

            // 5. Global ESC Key Handler
            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape") {
                    document.querySelectorAll(".courses-modal").forEach(function(m) {
                        m.classList.add("hidden");
                    });
                    if (modal && !modal.classList.contains("hidden")) {
                        modal.classList.add("hidden");
                    }
                    if (titularModal && !titularModal.classList.contains("hidden")) {
                        titularModal.classList.add("hidden");
                    }
                    document.body.classList.remove("overflow-hidden");
                }
            });
        });
    </script>
</x-app-layout>
