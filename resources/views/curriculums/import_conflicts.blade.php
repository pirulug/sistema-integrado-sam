<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Resolución de Conflictos de Cursos - Malla: ") }} {{ $curriculum->name }} ({{ $curriculum->year }})
            </h2>
            <form method="POST" action="{{ route('curriculums.import-conflicts.cancel') }}" onsubmit="return confirm('¿Está seguro de que desea descartar los cursos pendientes?');">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                    Descartar y Cancelar
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Summary Card -->
            <div class="bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-lg p-5 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-amber-600 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ms-3 flex-1">
                        <h3 class="text-sm font-semibold text-amber-900 dark:text-amber-200">
                            Revisión de cursos duplicados o con códigos en conflicto
                        </h3>
                        <p class="mt-1 text-xs text-amber-700 dark:text-amber-300 leading-relaxed">
                            Se vincularon automáticamente <strong>{{ $savedCount }}</strong> cursos a la malla <strong>{{ $curriculum->name }}</strong>. A continuación se presentan <strong>{{ count($conflicts) }}</strong> curso(s) que presentan colisión de código con asignaturas existentes. Puedes corregir el código o nombre, decidir si actualizar el curso existente, crearlo como nuevo con el código corregido, u omitirlo.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Error Alerts -->
            @if (session("error"))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md dark:bg-red-900/30 dark:text-red-400 shadow-sm" role="alert">
                    <p class="font-medium text-sm">{{ session("error") }}</p>
                </div>
            @endif

            @if (session("import_errors"))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md dark:bg-red-900/30 dark:text-red-400 shadow-sm" role="alert">
                    <p class="font-semibold text-sm mb-1">Se encontraron los siguientes inconvenientes:</p>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach (session("import_errors") as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Conflict Resolution Form -->
            <form method="POST" action="{{ route('curriculums.import-conflicts.resolve') }}">
                @csrf

                <div class="space-y-6">
                    @foreach ($conflicts as $conflict)
                        @php
                            $tempId = $conflict["temp_id"];
                            $data = $conflict["data"];
                            $rowNum = $conflict["row_number"];
                            $reasons = $conflict["reasons"];
                            $existingSummary = $conflict["existing_summary"];
                            $existingId = $conflict["existing_course_id"];
                            $defaultAction = $conflict["action"];
                        @endphp

                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden" x-data="{ action: '{{ $defaultAction }}' }">
                            <!-- Card Header -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/60 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        Fila CSV #{{ $rowNum }}
                                    </span>
                                    @foreach ($reasons as $reason)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                            {{ $reason }}
                                        </span>
                                    @endforeach
                                </div>

                                <!-- Action Selector -->
                                <div class="flex items-center space-x-2">
                                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                        Acción para esta fila:
                                    </label>
                                    <select name="rows[{{ $tempId }}][action]" x-model="action" class="text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 py-1.5 px-2.5 font-medium shadow-sm">
                                        <option value="update">Actualizar curso existente</option>
                                        <option value="create">Crear como nuevo (con código editado)</option>
                                        <option value="ignore">Omitir / No incluir en la malla</option>
                                    </select>
                                </div>
                            </div>

                            @if ($existingSummary)
                                <div class="px-4 py-2 bg-blue-50 dark:bg-blue-950/30 border-b border-blue-100 dark:border-blue-900/50 text-xs text-blue-800 dark:text-blue-300 flex items-center">
                                    <svg class="w-4 h-4 me-1.5 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Curso existente en el sistema: <strong>{{ $existingSummary }}</strong></span>
                                </div>
                            @endif

                            <!-- Card Body: Editable Inputs -->
                            <div class="p-5" x-show="action !== 'ignore'">
                                <input type="hidden" name="rows[{{ $tempId }}][existing_course_id]" value="{{ $existingId }}" />

                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                    <!-- Code -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Código del Curso <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][code]" value="{{ old('rows.'.$tempId.'.code', $data['code'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Name -->
                                    <div class="lg:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Nombre / Unidad Académica <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][name]" value="{{ old('rows.'.$tempId.'.name', $data['name'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Period -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Periodo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][period]" value="{{ old('rows.'.$tempId.'.period', $data['period'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Credits & Hours -->
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                Créditos
                                            </label>
                                            <input type="number" name="rows[{{ $tempId }}][credits]" value="{{ old('rows.'.$tempId.'.credits', $data['credits'] ?? 0) }}" min="0" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                Horas
                                            </label>
                                            <input type="number" name="rows[{{ $tempId }}][hours]" value="{{ old('rows.'.$tempId.'.hours', $data['hours'] ?? 0) }}" min="0" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ignored State Preview -->
                            <div class="p-4 bg-gray-100 dark:bg-gray-900/40 text-xs text-gray-500 dark:text-gray-400 italic" x-show="action === 'ignore'">
                                Este curso será omitido y no se vinculará a la malla ni se modificará.
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Form Submit Footer -->
                <div class="sticky bottom-4 z-20 mt-8 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        Los cursos procesados serán vinculados automáticamente a la malla <strong>{{ $curriculum->name }}</strong>.
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar y Vincular Cursos
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
