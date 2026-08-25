<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Resolución de Conflictos de Importación") }}
            </h2>
            <form method="POST" action="{{ route('students.import-conflicts.cancel') }}" onsubmit="return confirm('¿Está seguro de que desea descartar todos los registros pendientes?');">
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
                            Revisión de registros duplicados o similares
                        </h3>
                        <p class="mt-1 text-xs text-amber-700 dark:text-amber-300 leading-relaxed">
                            Se registraron automáticamente <strong>{{ $savedCount }}</strong> estudiantes sin conflicto. A continuación se presentan <strong>{{ count($conflicts) }}</strong> registro(s) que presentan duplicidad de DNI, código o correo institucional. Puedes editar los valores en cada fila, decidir si actualizar el registro existente, crearlo como nuevo con los datos editados, u omitirlo de la importación.
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
            <form method="POST" action="{{ route('students.import-conflicts.resolve') }}">
                @csrf

                <div class="space-y-6">
                    @foreach ($conflicts as $conflict)
                        @php
                            $tempId = $conflict["temp_id"];
                            $data = $conflict["data"];
                            $rowNum = $conflict["row_number"];
                            $reasons = $conflict["reasons"];
                            $existingSummary = $conflict["existing_summary"];
                            $existingId = $conflict["existing_student_id"];
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
                                        <option value="update">Actualizar existente</option>
                                        <option value="create">Crear como nuevo (con datos editados)</option>
                                        <option value="ignore">Omitir / Eliminar de importación</option>
                                    </select>
                                </div>
                            </div>

                            @if ($existingSummary)
                                <div class="px-4 py-2 bg-blue-50 dark:bg-blue-950/30 border-b border-blue-100 dark:border-blue-900/50 text-xs text-blue-800 dark:text-blue-300 flex items-center">
                                    <svg class="w-4 h-4 me-1.5 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Registro coincidente en el sistema: <strong>{{ $existingSummary }}</strong></span>
                                </div>
                            @endif

                            <!-- Card Body: Editable Inputs -->
                            <div class="p-5" x-show="action !== 'ignore'">
                                <input type="hidden" name="rows[{{ $tempId }}][existing_student_id]" value="{{ $existingId }}" />

                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <!-- Document Type -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Tipo Doc. <span class="text-red-500">*</span>
                                        </label>
                                        <select name="rows[{{ $tempId }}][document_type]" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                            <option value="DNI" {{ old('rows.'.$tempId.'.document_type', $data['document_type'] ?? 'DNI') == 'DNI' ? 'selected' : '' }}>DNI</option>
                                            <option value="CE" {{ old('rows.'.$tempId.'.document_type', $data['document_type'] ?? '') == 'CE' ? 'selected' : '' }}>CE</option>
                                        </select>
                                    </div>

                                    <!-- DNI / Document Number -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            N° Documento <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][dni]" value="{{ old('rows.'.$tempId.'.dni', $data['dni'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Student Code -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Código Estudiante <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][student_code]" value="{{ old('rows.'.$tempId.'.student_code', $data['student_code'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Nombres -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Nombres <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][first_name]" value="{{ old('rows.'.$tempId.'.first_name', $data['first_name'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Apellido Paterno -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Apellido Paterno <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][paternal_last_name]" value="{{ old('rows.'.$tempId.'.paternal_last_name', $data['paternal_last_name'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Apellido Materno -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Apellido Materno <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][maternal_last_name]" value="{{ old('rows.'.$tempId.'.maternal_last_name', $data['maternal_last_name'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Género -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Género
                                        </label>
                                        <select name="rows[{{ $tempId }}][gender]" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="Masculino" {{ old('rows.'.$tempId.'.gender', $data['gender'] ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="Femenino" {{ old('rows.'.$tempId.'.gender', $data['gender'] ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                    </div>

                                    <!-- Email Institucional -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Email Institucional <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="rows[{{ $tempId }}][institutional_email]" value="{{ old('rows.'.$tempId.'.institutional_email', $data['institutional_email'] ?? '') }}" required class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Email Personal -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Email Personal
                                        </label>
                                        <input type="email" name="rows[{{ $tempId }}][personal_email]" value="{{ old('rows.'.$tempId.'.personal_email', $data['personal_email'] ?? '') }}" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Programa de Estudio -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Programa de Estudio
                                        </label>
                                        <input type="text" name="rows[{{ $tempId }}][study_program]" value="{{ old('rows.'.$tempId.'.study_program', $data['study_program'] ?? 'Diseño y programación web') }}" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Fecha de Ingreso -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Fecha de Ingreso
                                        </label>
                                        <input type="date" name="rows[{{ $tempId }}][admission_date]" value="{{ old('rows.'.$tempId.'.admission_date', $data['admission_date'] ?? date('Y-m-d')) }}" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Fecha de Egreso -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Fecha de Egreso
                                        </label>
                                        <input type="date" name="rows[{{ $tempId }}][graduation_date]" value="{{ old('rows.'.$tempId.'.graduation_date', $data['graduation_date'] ?? '') }}" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    </div>

                                    <!-- Turno -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Turno
                                        </label>
                                        <select name="rows[{{ $tempId }}][shift]" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="Diurno (Mañana)" {{ ($data['shift'] ?? '') == 'Diurno (Mañana)' ? 'selected' : '' }}>Diurno (Mañana)</option>
                                            <option value="Diurno (Tarde)" {{ ($data['shift'] ?? '') == 'Diurno (Tarde)' ? 'selected' : '' }}>Diurno (Tarde)</option>
                                            <option value="Nocturno (Noche)" {{ ($data['shift'] ?? '') == 'Nocturno (Noche)' ? 'selected' : '' }}>Nocturno (Noche)</option>
                                        </select>
                                    </div>

                                    <!-- Malla Curricular -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            Malla Curricular
                                        </label>
                                        <select name="rows[{{ $tempId }}][curriculum_id]" class="w-full text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                            <option value="">-- Sin Malla --</option>
                                            @foreach ($curriculums as $c)
                                                <option value="{{ $c->id }}" {{ ($data['curriculum_id'] ?? '') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }} ({{ $c->year }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Ignored State Preview -->
                            <div class="p-4 bg-gray-100 dark:bg-gray-900/40 text-xs text-gray-500 dark:text-gray-400 italic" x-show="action === 'ignore'">
                                Esta fila será omitida y no se registrará ni actualizará en la base de datos.
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Form Submit Footer -->
                <div class="sticky bottom-4 z-20 mt-8 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        Revise que los datos modificados sean correctos antes de procesar la resolución.
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar y Finalizar Importación
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
