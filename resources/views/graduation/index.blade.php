<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seguimiento de Titulación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded dark:bg-green-900/30 dark:text-green-400" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Filters Panel -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('graduation.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search input -->
                        <div>
                            <label for="search" class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400 mb-1">Buscar Estudiante</label>
                            <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Nombre, Código o DNI..." class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" />
                        </div>

                        <!-- Curriculum filter -->
                        <div>
                            <label for="curriculum_id" class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400 mb-1">Malla Curricular</label>
                            <select id="curriculum_id" name="curriculum_id" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                <option value="">Todos</option>
                                @foreach($curriculums as $c)
                                    <option value="{{ $c->id }}" {{ $curriculumId == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->year }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Shift filter -->
                        <div>
                            <label for="shift" class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400 mb-1">Turno</label>
                            <select id="shift" name="shift" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                <option value="">Todos</option>
                                <option value="Diurno (Mañana)" {{ $shift == 'Diurno (Mañana)' ? 'selected' : '' }}>Diurno (Mañana)</option>
                                <option value="Diurno (Tarde)" {{ $shift == 'Diurno (Tarde)' ? 'selected' : '' }}>Diurno (Tarde)</option>
                                <option value="Nocturno (Noche)" {{ $shift == 'Nocturno (Noche)' ? 'selected' : '' }}>Nocturno (Noche)</option>
                            </select>
                        </div>

                        <!-- Status filter -->
                        <div>
                            <label for="status" class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400 mb-1">Estado Titulación</label>
                            <div class="flex space-x-2">
                                <select id="status" name="status" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">Todos</option>
                                    <option value="Titulado" {{ $status == 'Titulado' ? 'selected' : '' }}>Titulado</option>
                                    <option value="Apto" {{ $status == 'Apto' ? 'selected' : '' }}>Apto</option>
                                    <option value="En Proceso" {{ $status == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="Sin Malla" {{ $status == 'Sin Malla' ? 'selected' : '' }}>Sin Malla</option>
                                </select>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Students Tracking List -->
            <div class="space-y-4">
                @if($students->isEmpty())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500 dark:text-gray-400">
                        No se encontraron estudiantes para los filtros seleccionados.
                    </div>
                @else
                    @foreach($students as $student)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700 transition duration-150 hover:shadow-md">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                    <!-- Student Personal Data (Left) -->
                                    <div class="w-full lg:w-1/4">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $student->paternal_last_name }} {{ $student->maternal_last_name }}, {{ $student->first_name }}</h3>
                                        <div class="mt-2 space-y-1 text-sm text-gray-500 dark:text-gray-400 flex flex-col">
                                            <span class="inline-flex items-center">
                                                <!-- DNI Icon -->
                                                <svg class="w-4 h-4 me-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.333 0 4 1 4 3H6c0-2 2.667-3 4-3z"></path></svg>
                                                {{ $student->dni }}
                                            </span>
                                            @if($student->mobile || $student->phone)
                                                <span class="inline-flex items-center">
                                                    <!-- Phone Icon -->
                                                    <svg class="w-4 h-4 me-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    {{ $student->mobile ?? $student->phone }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Academic Info (Center) -->
                                    <div class="w-full lg:w-1/4 flex flex-col items-start lg:items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider text-center lg:text-left">{{ mb_strtoupper($student->study_program) }}</span>
                                        @if($student->shift)
                                            <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-800 dark:bg-cyan-900/40 dark:text-cyan-400">
                                                {{ $student->shift }}
                                            </span>
                                        @endif
                                        <span class="mt-2 text-sm text-gray-600 dark:text-gray-400 flex items-center font-medium">
                                            <!-- Calendar Icon -->
                                            <svg class="w-4 h-4 me-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($student->admission_date)->year }} - {{ $student->graduation_date ? \Carbon\Carbon::parse($student->graduation_date)->year : 'En curso' }}
                                        </span>
                                    </div>

                                    <!-- EFSRT Modules Status (Checkmarks) -->
                                    <div class="w-full lg:w-1/5 flex items-center justify-start lg:justify-center gap-2">
                                        @if($student->curriculum)
                                            @foreach($student->efsrtStatusList() as $efs)
                                                <button type="button" 
                                                        class="efsrt-indicator-btn group relative flex items-center justify-center w-8 h-8 rounded-full border transition duration-150 hover:scale-110 focus:outline-none"
                                                        data-student-id="{{ $student->id }}"
                                                        data-student-name="{{ $student->full_name }}"
                                                        data-efsrt-id="{{ $efs['id'] }}"
                                                        data-efsrt-module="{{ $efs['module'] }}"
                                                        data-company="{{ $efs['pivot'] ? $efs['pivot']->company_name : '' }}"
                                                        data-hours="{{ $efs['pivot'] ? $efs['pivot']->hours : '' }}"
                                                        data-start="{{ $efs['pivot'] ? $efs['pivot']->start_date : '' }}"
                                                        data-end="{{ $efs['pivot'] ? $efs['pivot']->end_date : '' }}"
                                                        data-status="{{ $efs['status'] }}"
                                                        title="{{ $efs['module'] }}: {{ $efs['module_name'] }}">
                                                    
                                                    @if($efs['status'] == 'approved')
                                                        <!-- Green Circle with Check -->
                                                        <span class="absolute inset-0 bg-emerald-100 dark:bg-emerald-900/30 border-emerald-500 rounded-full"></span>
                                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    @elseif($efs['status'] == 'rejected')
                                                        <!-- Red Circle with Cross -->
                                                        <span class="absolute inset-0 bg-red-100 dark:bg-red-900/30 border-red-500 rounded-full"></span>
                                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    @else
                                                        <!-- Gray Circle (Pending) -->
                                                        <span class="absolute inset-0 bg-gray-100 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 rounded-full"></span>
                                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    @endif
                                                </button>
                                            @endforeach
                                        @else
                                            <span class="text-xs text-gray-400">Sin prácticas</span>
                                        @endif
                                    </div>

                                    <!-- Overall Status Badge -->
                                    <div class="w-full lg:w-1/8 flex flex-col items-center justify-start lg:justify-center gap-2">
                                        @php
                                            $st = $student->overall_status;
                                            $badgeClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                            if ($st == 'Titulado') {
                                                $badgeClass = 'bg-emerald-600 text-white dark:bg-emerald-600';
                                            } elseif ($st == 'Apto') {
                                                $badgeClass = 'bg-indigo-600 text-white dark:bg-indigo-600';
                                            } elseif ($st == 'En Proceso') {
                                                $badgeClass = 'bg-amber-500 text-white dark:bg-amber-500';
                                            }
                                        @endphp
                                        <span id="status-badge-{{ $student->id }}" class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold shadow-sm {{ $badgeClass }}">
                                            {{ $st }}
                                        </span>
                                        
                                        <button type="button" 
                                                id="titular-btn-{{ $student->id }}"
                                                class="titular-btn mt-2 {{ $st == 'Apto' ? '' : 'hidden' }} inline-flex items-center px-2.5 py-1 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded shadow transition duration-150"
                                                data-student-id="{{ $student->id }}"
                                                data-student-name="{{ $student->full_name }}">
                                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                            Titular
                                        </button>
                                    </div>

                                    <!-- Pending Info and Accordion Trigger (Right) -->
                                    <div class="w-full lg:w-1/6 flex flex-col items-start lg:items-end justify-center">
                                        @if($student->curriculum)
                                            @php
                                                $pendingCount = $student->pendingCourses()->count();
                                                $pendingTextClass = $pendingCount > 0 ? 'text-red-600 dark:text-red-400 font-bold' : 'text-emerald-600 dark:text-emerald-400 font-bold';
                                            @endphp
                                            <span id="pending-count-{{ $student->id }}" class="text-sm {{ $pendingTextClass }}">
                                                {{ $pendingCount }} U.D. pendientes
                                            </span>
                                            <button type="button" 
                                                    class="toggle-courses-btn mt-2 inline-flex items-center text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 focus:outline-none"
                                                    data-student-id="{{ $student->id }}">
                                                <span>Ver cursos</span>
                                                <!-- Chevron icon -->
                                                <svg class="w-4 h-4 ms-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                        @else
                                            <span class="text-sm text-gray-400 font-medium">Requiere asignar Malla</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Collapsible Courses Grid (AJAX interactive checkbox) -->
                                @if($student->curriculum)
                                    <div id="courses-panel-{{ $student->id }}" class="hidden mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                            <h4 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Progreso de Unidades Didácticas (Malla {{ $student->curriculum->year }})</h4>
                                            <div class="flex items-center space-x-2 text-xs font-semibold">
                                                <button type="button" class="bulk-courses-btn text-blue-600 dark:text-blue-400 hover:underline" data-student-id="{{ $student->id }}" data-action="approve_all">Marcar todo</button>
                                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                                <button type="button" class="bulk-courses-btn text-gray-500 dark:text-gray-400 hover:underline" data-student-id="{{ $student->id }}" data-action="clear_all">Desmarcar todo</button>
                                            </div>
                                        </div>
                                        
                                        @php
                                            // Group curriculum courses by academic period (I to VI)
                                            $groupedCourses = $student->curriculum->courses->groupBy('period');
                                            $periodsOrder = ['I', 'II', 'III', 'IV', 'V', 'VI'];
                                        @endphp

                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                            @foreach($periodsOrder as $periodName)
                                                @if(isset($groupedCourses[$periodName]))
                                                    <div class="bg-gray-50 dark:bg-gray-900/30 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                                                        <h5 class="font-bold text-xs text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 pb-2 mb-3 flex items-center justify-between">
                                                            <span>Periodo {{ $periodName }}</span>
                                                            <span class="flex items-center space-x-1 font-semibold text-[10px]">
                                                                <button type="button" class="bulk-courses-btn text-blue-600 dark:text-blue-400 hover:underline" data-student-id="{{ $student->id }}" data-period="{{ $periodName }}" data-action="approve_period">Todo</button>
                                                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                                                <button type="button" class="bulk-courses-btn text-gray-500 dark:text-gray-400 hover:underline" data-student-id="{{ $student->id }}" data-period="{{ $periodName }}" data-action="clear_period">Nada</button>
                                                            </span>
                                                        </h5>
                                                        <ul class="space-y-3">
                                                            @foreach($groupedCourses[$periodName]->sortBy('code') as $course)
                                                                @php
                                                                    $isCompleted = $student->courses->contains($course->id);
                                                                @endphp
                                                                <li class="flex items-start">
                                                                    <div class="flex items-center h-5">
                                                                        <input type="checkbox" 
                                                                               id="chk-{{ $student->id }}-{{ $course->id }}" 
                                                                               class="course-checkbox h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                                                               data-student-id="{{ $student->id }}"
                                                                               data-course-id="{{ $course->id }}"
                                                                               {{ $isCompleted ? 'checked' : '' }} />
                                                                    </div>
                                                                    <div class="ms-3 text-xs">
                                                                        <label for="chk-{{ $student->id }}-{{ $course->id }}" class="font-semibold text-gray-800 dark:text-gray-200 cursor-pointer select-none">
                                                                            {{ $course->name }}
                                                                        </label>
                                                                        <div class="text-gray-500 dark:text-gray-400 font-mono mt-0.5">
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
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- EFSRT Modal Form -->
    <div id="efsrt-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="efsrt-modal-overlay" class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-950/80"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <form id="efsrt-modal-form" method="POST" action="">
                    @csrf
                    <div class="p-6">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700 mb-5">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100" id="modal-title">
                                Registrar Módulo de Práctica
                            </h3>
                            <button type="button" class="close-modal-btn text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Read-only header information -->
                        <div class="mb-4 bg-gray-50 dark:bg-gray-900/50 p-3 rounded-lg border border-gray-100 dark:border-gray-800 text-sm space-y-1">
                            <div><span class="text-gray-500">Estudiante:</span> <strong id="modal-student-name" class="text-gray-900 dark:text-gray-100"></strong></div>
                            <div><span class="text-gray-500">Módulo:</span> <strong id="modal-efsrt-module" class="text-gray-900 dark:text-gray-100"></strong></div>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4">
                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nombre de la Empresa</label>
                                <input type="text" id="company_name" name="company_name" placeholder="Ej. Soluciones Web SAC" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" />
                            </div>

                            <!-- Hours and Status in a 2-column grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="hours" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Horas Acumuladas</label>
                                    <input type="number" id="hours" name="hours" min="0" placeholder="Ej. 240" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" />
                                </div>
                                <div>
                                    <label for="modal-status-select" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Estado de Aprobación</label>
                                    <select id="modal-status-select" name="status" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                        <option value="pending">Pendiente</option>
                                        <option value="approved">Aprobado</option>
                                        <option value="rejected">Rechazado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dates in a 2-column grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha Inicio</label>
                                    <input type="date" id="start_date" name="start_date" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" />
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha Fin</label>
                                    <input type="date" id="end_date" name="end_date" class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/40 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" class="close-modal-btn inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            Guardar Práctica
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Client-side Interactive Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Accordion Toggle
            const toggleButtons = document.querySelectorAll('.toggle-courses-btn');
            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.studentId;
                    const panel = document.getElementById(`courses-panel-${studentId}`);
                    const icon = this.querySelector('svg');
                    
                    if (panel.classList.contains('hidden')) {
                        panel.classList.remove('hidden');
                        icon.classList.add('rotate-180');
                        this.querySelector('span').innerText = 'Ocultar cursos';
                    } else {
                        panel.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                        this.querySelector('span').innerText = 'Ver cursos';
                    }
                });
            });

            // 2. AJAX Course Toggling
            const courseCheckboxes = document.querySelectorAll('.course-checkbox');
            courseCheckboxes.forEach(chk => {
                chk.addEventListener('change', function() {
                    const studentId = this.dataset.studentId;
                    const courseId = this.dataset.courseId;
                    
                    // Disable checkbox during transaction to prevent double click
                    this.disabled = true;

                    fetch(`/graduation/${studentId}/toggle-course/${courseId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.disabled = false;
                        if (data.success) {
                            // Update pending counter text
                            const counterEl = document.getElementById(`pending-count-${studentId}`);
                            counterEl.innerText = `${data.pending_count} U.D. pendientes`;
                            
                            // Adjust counter color
                            if (data.pending_count > 0) {
                                counterEl.className = 'text-sm text-red-600 dark:text-red-400 font-bold';
                            } else {
                                counterEl.className = 'text-sm text-emerald-600 dark:text-emerald-400 font-bold';
                            }

                            // Update status badge
                            const badgeEl = document.getElementById(`status-badge-${studentId}`);
                            badgeEl.innerText = data.overall_status;
                            
                            let badgeClass = 'inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold shadow-sm ';
                            if (data.overall_status === 'Titulado') {
                                badgeClass += 'bg-emerald-600 text-white dark:bg-emerald-600';
                            } else if (data.overall_status === 'Apto') {
                                badgeClass += 'bg-indigo-600 text-white dark:bg-indigo-600';
                            } else if (data.overall_status === 'En Proceso') {
                                badgeClass += 'bg-amber-500 text-white dark:bg-amber-500';
                            } else {
                                badgeClass += 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            }
                            badgeEl.className = badgeClass;

                            // Show/hide titular button
                            const titularBtn = document.getElementById(`titular-btn-${studentId}`);
                            if (titularBtn) {
                                if (data.overall_status === 'Apto') {
                                    titularBtn.classList.remove('hidden');
                                } else {
                                    titularBtn.classList.add('hidden');
                                }
                            }
                        }
                    })
                    .catch(err => {
                        this.disabled = false;
                        console.error('Error toggling course status:', err);
                        // Revert check state on error
                        this.checked = !this.checked;
                    });
                });
            });

            // 2.1 Bulk Course Operations (Select All / Clear All / Period)
            const bulkButtons = document.querySelectorAll('.bulk-courses-btn');
            bulkButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.studentId;
                    const action = this.dataset.action;
                    const period = this.dataset.period || null;

                    // Disable bulk buttons to prevent multiple simultaneous requests
                    bulkButtons.forEach(b => { if (b.dataset.studentId === studentId) b.disabled = true; });

                    fetch(`/graduation/${studentId}/bulk-courses`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            action: action,
                            period: period
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Re-enable bulk buttons
                        bulkButtons.forEach(b => { if (b.dataset.studentId === studentId) b.disabled = false; });

                        if (data.success) {
                            // Update all checkboxes for this student based on approved_ids
                            const checkboxes = document.querySelectorAll(`.course-checkbox[data-student-id="${studentId}"]`);
                            checkboxes.forEach(chk => {
                                const courseId = parseInt(chk.dataset.courseId);
                                chk.checked = data.approved_ids.includes(courseId);
                            });

                            // Update pending counter text
                            const counterEl = document.getElementById(`pending-count-${studentId}`);
                            if (counterEl) {
                                counterEl.innerText = `${data.pending_count} U.D. pendientes`;
                                if (data.pending_count > 0) {
                                    counterEl.className = 'text-sm text-red-600 dark:text-red-400 font-bold';
                                } else {
                                    counterEl.className = 'text-sm text-emerald-600 dark:text-emerald-400 font-bold';
                                }
                            }

                            // Update status badge
                            const badgeEl = document.getElementById(`status-badge-${studentId}`);
                            if (badgeEl) {
                                badgeEl.innerText = data.overall_status;
                                let badgeClass = 'inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold shadow-sm ';
                                if (data.overall_status === 'Titulado') {
                                    badgeClass += 'bg-emerald-600 text-white dark:bg-emerald-600';
                                } else if (data.overall_status === 'Apto') {
                                    badgeClass += 'bg-indigo-600 text-white dark:bg-indigo-600';
                                } else if (data.overall_status === 'En Proceso') {
                                    badgeClass += 'bg-amber-500 text-white dark:bg-amber-500';
                                } else {
                                    badgeClass += 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                }
                                badgeEl.className = badgeClass;
                            }

                            // Show/hide titular button
                            const titularBtn = document.getElementById(`titular-btn-${studentId}`);
                            if (titularBtn) {
                                if (data.overall_status === 'Apto') {
                                    titularBtn.classList.remove('hidden');
                                } else {
                                    titularBtn.classList.add('hidden');
                                }
                            }
                        }
                    })
                    .catch(err => {
                        bulkButtons.forEach(b => { if (b.dataset.studentId === studentId) b.disabled = false; });
                        console.error('Error during bulk course updates:', err);
                    });
                });
            });

            // 3. EFSRT Modal Logic
            const modal = document.getElementById('efsrt-modal');
            const overlay = document.getElementById('efsrt-modal-overlay');
            const modalForm = document.getElementById('efsrt-modal-form');
            const closeButtons = document.querySelectorAll('.close-modal-btn, #efsrt-modal-overlay');
            
            const indicatorButtons = document.querySelectorAll('.efsrt-indicator-btn');
            indicatorButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.studentId;
                    const studentName = this.dataset.studentName;
                    const efsrtId = this.dataset.efsrtId;
                    const efsrtModule = this.dataset.efsrtModule;
                    
                    const company = this.dataset.company;
                    const hours = this.dataset.hours;
                    const start = this.dataset.start;
                    const end = this.dataset.end;
                    const status = this.dataset.status;

                    // Set form action
                    modalForm.action = `/graduation/${studentId}/update-efsrt/${efsrtId}`;
                    
                    // Set readable info
                    document.getElementById('modal-student-name').innerText = studentName;
                    document.getElementById('modal-efsrt-module').innerText = efsrtModule;

                    // Populate fields
                    document.getElementById('company_name').value = company || '';
                    document.getElementById('hours').value = hours || '';
                    document.getElementById('start_date').value = start || '';
                    document.getElementById('end_date').value = end || '';
                    document.getElementById('modal-status-select').value = status || 'pending';

                    // Show modal
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            });

            // Close modal functionality
            closeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            });

            // 4. Titulación Modal Logic
            const titularModal = document.getElementById('titular-modal');
            const titularModalForm = document.getElementById('titular-modal-form');
            const closeTitularButtons = document.querySelectorAll('.close-titular-modal-btn, #titular-modal-overlay');
            
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.titular-btn');
                if (btn) {
                    const studentId = btn.dataset.studentId;
                    const studentName = btn.dataset.studentName;

                    // Set form action
                    titularModalForm.action = `/graduation/${studentId}/titular`;
                    
                    // Set readable info
                    document.getElementById('titular-modal-student-name').innerText = studentName;

                    // Show modal
                    titularModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }
            });

            closeTitularButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    titularModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            });

            // ESC key closes all modals
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                    if (!titularModal.classList.contains('hidden')) {
                        titularModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                }
            });
        });
    </script>

    <!-- Titulación Modal Form -->
    <div id="titular-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="titular-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="titular-modal-overlay" class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-950/80"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <form id="titular-modal-form" method="POST" action="">
                    @csrf
                    <div class="p-6">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700 mb-5">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100" id="titular-modal-title">
                                Registrar Titulación
                            </h3>
                            <button type="button" class="close-titular-modal-btn text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Info display -->
                        <div class="mb-4 bg-gray-50 dark:bg-gray-900/50 p-3 rounded-lg border border-gray-100 dark:border-gray-800 text-sm">
                            <span class="text-gray-500">Estudiante:</span> <strong id="titular-modal-student-name" class="text-gray-900 dark:text-gray-100"></strong>
                        </div>

                        <!-- Date selection -->
                        <div>
                            <label for="degree_date_input" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha de Titulación</label>
                            <input type="date" id="degree_date_input" name="degree_date" required class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/40 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" class="close-titular-modal-btn inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            Registrar Titulación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
