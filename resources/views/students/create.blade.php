<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('students.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- DNI -->
                            <div>
                                <x-input-label for="dni" :value="__('DNI')" />
                                <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                            </div>

                            <!-- Student Code -->
                            <div>
                                <x-input-label for="student_code" :value="__('Código de Estudiante')" />
                                <x-text-input id="student_code" name="student_code" type="text" class="mt-1 block w-full" :value="old('student_code')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('student_code')" />
                            </div>

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('Nombres')" />
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <!-- Paternal Last Name -->
                            <div>
                                <x-input-label for="paternal_last_name" :value="__('Apellido Paterno')" />
                                <x-text-input id="paternal_last_name" name="paternal_last_name" type="text" class="mt-1 block w-full" :value="old('paternal_last_name')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('paternal_last_name')" />
                            </div>

                            <!-- Maternal Last Name -->
                            <div>
                                <x-input-label for="maternal_last_name" :value="__('Apellido Materno')" />
                                <x-text-input id="maternal_last_name" name="maternal_last_name" type="text" class="mt-1 block w-full" :value="old('maternal_last_name')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('maternal_last_name')" />
                            </div>

                            <!-- Study Program -->
                            <div>
                                <x-input-label for="study_program" :value="__('Programa de Estudio')" />
                                <x-text-input id="study_program" name="study_program" type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 cursor-not-allowed" :value="old('study_program', 'Diseño y programación web')" readonly required />
                                <x-input-error class="mt-2" :messages="$errors->get('study_program')" />
                            </div>

                            <!-- Institutional Email -->
                            <div>
                                <x-input-label for="institutional_email" :value="__('Email Institucional')" />
                                <x-text-input id="institutional_email" name="institutional_email" type="email" class="mt-1 block w-full" :value="old('institutional_email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('institutional_email')" />
                            </div>

                            <!-- Personal Email -->
                            <div>
                                <x-input-label for="personal_email" :value="__('Email Personal')" />
                                <x-text-input id="personal_email" name="personal_email" type="email" class="mt-1 block w-full" :value="old('personal_email')" />
                                <x-input-error class="mt-2" :messages="$errors->get('personal_email')" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Teléfono Fijo')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- Mobile -->
                            <div>
                                <x-input-label for="mobile" :value="__('Celular')" />
                                <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full" :value="old('mobile')" />
                                <x-input-error class="mt-2" :messages="$errors->get('mobile')" />
                            </div>

                            <!-- Admission Date -->
                            <div>
                                <x-input-label for="admission_date" :value="__('Fecha de Ingreso')" />
                                <x-text-input id="admission_date" name="admission_date" type="date" class="mt-1 block w-full" :value="old('admission_date')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('admission_date')" />
                            </div>

                            <!-- Graduation Date -->
                            <div>
                                <x-input-label for="graduation_date" :value="__('Fecha de Egreso')" />
                                <x-text-input id="graduation_date" name="graduation_date" type="date" class="mt-1 block w-full" :value="old('graduation_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('graduation_date')" />
                            </div>



                            <!-- Malla Curricular -->
                            <div>
                                <x-input-label for="curriculum_id" :value="__('Malla Curricular')" />
                                <select id="curriculum_id" name="curriculum_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">-- Seleccionar Malla --</option>
                                    @foreach($curriculums as $curriculum)
                                        <option value="{{ $curriculum->id }}" {{ old('curriculum_id') == $curriculum->id ? 'selected' : '' }}>
                                            {{ $curriculum->name }} ({{ $curriculum->year }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('curriculum_id')" />
                            </div>

                            <!-- Turno (Shift) -->
                            <div>
                                <x-input-label for="shift" :value="__('Turno')" />
                                <select id="shift" name="shift" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">-- Seleccionar Turno --</option>
                                    <option value="Diurno (Mañana)" {{ old('shift') == 'Diurno (Mañana)' ? 'selected' : '' }}>Diurno (Mañana)</option>
                                    <option value="Diurno (Tarde)" {{ old('shift') == 'Diurno (Tarde)' ? 'selected' : '' }}>Diurno (Tarde)</option>
                                    <option value="Nocturno (Noche)" {{ old('shift') == 'Nocturno (Noche)' ? 'selected' : '' }}>Nocturno (Noche)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Guardar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
