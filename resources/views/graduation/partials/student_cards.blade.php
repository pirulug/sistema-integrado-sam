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
                @if ($student->photo_url)
                    <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}" class="w-11 h-11 rounded-xl object-cover border border-indigo-200 dark:border-indigo-800 flex-shrink-0 shadow-sm">
                @else
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                        {{ strtoupper($initials) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate" title="{{ $student->full_name }}">
                        {{ $student->paternal_last_name }} {{ $student->maternal_last_name }}, {{ $student->first_name }}
                    </h3>
                    <div class="mt-1 flex flex-wrap items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700/70 text-gray-700 dark:text-gray-300 font-mono text-[11px]">
                            {{ $student->document_type ?? 'DNI' }}: {{ $student->dni }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700/70 text-gray-700 dark:text-gray-300 font-mono text-[11px]">
                            {{ $student->student_code }}
                        </span>
                    </div>
                    <div class="mt-1 text-[11px] truncate {{ $curriculum ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-amber-600 dark:text-amber-400 font-medium' }}">
                        {{ $curriculum ? "Malla: {$curriculum->name} ({$curriculum->year})" : "Sin Malla asignada" }}
                    </div>
                    @if ($student->degree_date)
                        <div class="mt-1.5 flex flex-wrap items-center gap-1.5 text-[11px]">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 font-medium border border-emerald-200 dark:border-emerald-800">
                                Titulado: {{ \Carbon\Carbon::parse($student->degree_date)->format('d/m/Y') }}
                                @if ($student->degree_grade !== null)
                                    <span class="ms-1.5 ps-1.5 border-s border-emerald-300 dark:border-emerald-700 font-bold">Nota: {{ number_format($student->degree_grade, 2) }}</span>
                                @endif
                            </span>
                            @if ($student->degree_modality)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-purple-50 dark:bg-purple-950/60 text-purple-800 dark:text-purple-300 font-medium border border-purple-200 dark:border-purple-800 max-w-[220px] truncate" title="Modalidad: {{ $student->degree_modality }}">
                                    {{ $student->degree_modality }}
                                </span>
                            @endif
                        </div>
                    @endif
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
                        <span>{{ $totalCourses }} total</span>
                    </div>
                @else
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800/60 text-xs text-amber-800 dark:text-amber-300">
                        No se ha asignado una malla curricular.
                    </div>
                @endif
            </div>

            <!-- 3. EFSRT Mini Badges (xl: 2 cols) -->
            <div class="xl:col-span-2 flex flex-col justify-center">
                <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Módulos EFSRT</span>
                <div class="flex items-center space-x-2">
                    @if ($curriculum)
                        @foreach ($student->efsrtStatusList() as $efs)
                            @php
                                $status = $efs['status'];
                                $bgColor = 'bg-gray-100 dark:bg-gray-700 text-gray-400 border-gray-200 dark:border-gray-600';
                                if ($status == 'approved') {
                                    $bgColor = 'bg-emerald-500 text-white border-emerald-600 shadow-sm shadow-emerald-500/20';
                                } elseif ($status == 'rejected') {
                                    $bgColor = 'bg-rose-500 text-white border-rose-600 shadow-sm shadow-rose-500/20';
                                }

                                if (preg_match('/\b(III|II|IV|VI|V|I)\b/i', $efs['module'], $matches)) {
                                    $shortModule = strtoupper($matches[1]);
                                } else {
                                    $shortModule = 'M' . $loop->iteration;
                                }

                                $pivotData = $efs['pivot'];
                            @endphp
                            <button type="button" 
                                    class="open-efsrt-modal-btn w-8 h-8 rounded-full border flex items-center justify-center text-xs font-bold font-mono transition transform hover:scale-105 {{ $bgColor }}"
                                    data-student-id="{{ $student->id }}"
                                    data-student-name="{{ $student->full_name }}"
                                    data-efsrt-id="{{ $efs['id'] }}"
                                    data-efsrt-module="{{ $efs['module'] }}: {{ $efs['module_name'] }}"
                                    data-efsrt-period="Periodo {{ $efs['period'] }}"
                                    data-efsrt-hours="{{ $efs['hours'] }}"
                                    data-practice-lines="{{ json_encode($efs['practice_lines'] ?? []) }}"
                                    data-status="{{ $status }}"
                                    data-company="{{ $pivotData ? $pivotData->company_name : '' }}"
                                    data-practice-line="{{ $pivotData ? $pivotData->practice_line : '' }}"
                                    data-activities="{{ $pivotData ? $pivotData->activities : '' }}"
                                    data-hours="{{ $pivotData ? $pivotData->hours : '' }}"
                                    data-start-date="{{ $pivotData ? $pivotData->start_date : '' }}"
                                    data-end-date="{{ $pivotData ? $pivotData->end_date : '' }}"
                                    title="{{ $efs['module'] }}: {{ $efs['module_name'] }} ({{ ucfirst($status) }})">
                                @if ($status == 'approved')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif ($status == 'rejected')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @else
                                    {{ $shortModule }}
                                @endif
                            </button>
                        @endforeach
                    @else
                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">N/A</span>
                    @endif
                </div>
            </div>

            <!-- 4. Graduation Status Badge & Actions (xl: 3 cols) -->
            <div class="xl:col-span-3 flex flex-row xl:flex-col items-center xl:items-end justify-between xl:justify-center gap-3 pt-3 xl:pt-0 border-t xl:border-t-0 border-gray-100 dark:border-gray-700/80">
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

                    @if (Auth::user()->canManage())
                        <!-- Button for Apto -->
                        <button type="button" 
                                id="titular-btn-{{ $student->id }}"
                                class="titular-btn {{ $st == 'Apto' ? '' : 'hidden' }} inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-md transition duration-150"
                                data-student-id="{{ $student->id }}"
                                data-student-name="{{ $student->full_name }}"
                                data-degree-date="{{ $student->degree_date ? $student->degree_date : date('Y-m-d') }}"
                                data-degree-modality="{{ $student->degree_modality ?? '' }}"
                                data-degree-grade="{{ $student->degree_grade ?? '' }}"
                                data-is-titulado="false">
                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                            Titular
                        </button>

                        <!-- Button for Titulado (Editar Titulación) -->
                        <button type="button" 
                                id="edit-titular-btn-{{ $student->id }}"
                                class="titular-btn {{ $st == 'Titulado' ? '' : 'hidden' }} inline-flex items-center px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 text-xs font-bold rounded-lg shadow-sm hover:bg-emerald-100 dark:hover:bg-emerald-900 transition duration-150"
                                data-student-id="{{ $student->id }}"
                                data-student-name="{{ $student->full_name }}"
                                data-degree-date="{{ $student->degree_date ? $student->degree_date : date('Y-m-d') }}"
                                data-degree-modality="{{ $student->degree_modality ?? '' }}"
                                data-degree-grade="{{ $student->degree_grade ?? '' }}"
                                data-is-titulado="true"
                                title="Editar fecha o modalidad de titulación">
                            <svg class="w-3.5 h-3.5 me-1 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar Titulación
                        </button>
                    @endif
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
                            @if (Auth::user()->canManage())
                                <div class="flex items-center space-x-2 text-xs font-semibold me-2">
                                    <button type="button" class="bulk-courses-btn text-indigo-600 dark:text-indigo-400 hover:underline" data-student-id="{{ $student->id }}" data-action="approve_all">Marcar todo</button>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <button type="button" class="bulk-courses-btn text-gray-500 dark:text-gray-400 hover:underline" data-student-id="{{ $student->id }}" data-action="clear_all">Desmarcar todo</button>
                                </div>
                            @endif
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
                                                @if (Auth::user()->canManage())
                                                    <span class="flex items-center space-x-1 font-semibold text-[11px]">
                                                        <button type="button" class="bulk-courses-btn text-blue-600 dark:text-blue-400 hover:underline" data-student-id="{{ $student->id }}" data-period="{{ $periodName }}" data-action="approve_period">Todo</button>
                                                        <span class="text-gray-300 dark:text-gray-600">|</span>
                                                        <button type="button" class="bulk-courses-btn text-gray-500 dark:text-gray-400 hover:underline" data-student-id="{{ $student->id }}" data-period="{{ $periodName }}" data-action="clear_period">Nada</button>
                                                    </span>
                                                @endif
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
                                                                       class="course-checkbox h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 {{ Auth::user()->canManage() ? 'cursor-pointer' : 'cursor-not-allowed opacity-75' }}"
                                                                       data-student-id="{{ $student->id }}"
                                                                       data-course-id="{{ $course->id }}"
                                                                       data-period="{{ $periodName }}"
                                                                       {{ $isCompleted ? 'checked' : '' }}
                                                                       {{ Auth::user()->canManage() ? '' : 'disabled' }} />
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
                            @if (Auth::user()->canManage())
                                Las asignaturas marcadas se guardan de forma instantánea en la base de datos.
                            @else
                                <span class="text-teal-600 dark:text-teal-400 font-semibold">Modo Observador:</span> Visualización de unidades didácticas en solo lectura.
                            @endif
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
