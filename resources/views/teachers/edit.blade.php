<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Profesor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('teachers.update', $teacher) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- DNI -->
                            <div>
                                <x-input-label for="dni" :value="__('DNI')" />
                                <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni', $teacher->dni)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                            </div>

                            <!-- Teacher Code -->
                            <div>
                                <x-input-label for="teacher_code" :value="__('Código de Profesor')" />
                                <x-text-input id="teacher_code" name="teacher_code" type="text" class="mt-1 block w-full" :value="old('teacher_code', $teacher->teacher_code)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('teacher_code')" />
                            </div>

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('Nombres')" />
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $teacher->first_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <!-- Paternal Last Name -->
                            <div>
                                <x-input-label for="paternal_last_name" :value="__('Apellido Paterno')" />
                                <x-text-input id="paternal_last_name" name="paternal_last_name" type="text" class="mt-1 block w-full" :value="old('paternal_last_name', $teacher->paternal_last_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('paternal_last_name')" />
                            </div>

                            <!-- Maternal Last Name -->
                            <div>
                                <x-input-label for="maternal_last_name" :value="__('Apellido Materno')" />
                                <x-text-input id="maternal_last_name" name="maternal_last_name" type="text" class="mt-1 block w-full" :value="old('maternal_last_name', $teacher->maternal_last_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('maternal_last_name')" />
                            </div>

                            <!-- Institutional Email -->
                            <div>
                                <x-input-label for="institutional_email" :value="__('Email Institucional')" />
                                <x-text-input id="institutional_email" name="institutional_email" type="email" class="mt-1 block w-full" :value="old('institutional_email', $teacher->institutional_email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('institutional_email')" />
                            </div>

                            <!-- Personal Email -->
                            <div>
                                <x-input-label for="personal_email" :value="__('Email Personal')" />
                                <x-text-input id="personal_email" name="personal_email" type="email" class="mt-1 block w-full" :value="old('personal_email', $teacher->personal_email)" />
                                <x-input-error class="mt-2" :messages="$errors->get('personal_email')" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Teléfono Fijo')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $teacher->phone)" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- Mobile -->
                            <div>
                                <x-input-label for="mobile" :value="__('Celular')" />
                                <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full" :value="old('mobile', $teacher->mobile)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mobile')" />
                            </div>

                            <!-- Hire Date -->
                            <div>
                                <x-input-label for="hire_date" :value="__('Fecha de Contratación')" />
                                <x-text-input id="hire_date" name="hire_date" type="date" class="mt-1 block w-full" :value="old('hire_date', $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('Y-m-d') : '')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hire_date')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('teachers.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
