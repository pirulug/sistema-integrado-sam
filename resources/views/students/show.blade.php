<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perfil del Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header Actions -->
                    <div class="flex items-center justify-between pb-6 border-b border-gray-200 dark:border-gray-700 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->paternal_last_name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $student->full_name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student->study_program }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                Editar
                            </a>
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Volver
                            </a>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Info -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Información Personal</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">DNI</span>
                                    <span class="text-sm font-semibold">{{ $student->dni }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Código de Estudiante</span>
                                    <span class="text-sm font-semibold">{{ $student->student_code }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Nombres</span>
                                    <span class="text-sm font-semibold">{{ $student->first_name }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Apellido Paterno</span>
                                    <span class="text-sm font-semibold">{{ $student->paternal_last_name }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Apellido Materno</span>
                                    <span class="text-sm font-semibold">{{ $student->maternal_last_name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Academic Info -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Contacto y Fechas Académicas</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Email Institucional</span>
                                    <span class="text-sm font-semibold break-all">{{ $student->institutional_email }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Email Personal</span>
                                    <span class="text-sm font-semibold break-all">{{ $student->personal_email ?? '-' }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Teléfono</span>
                                        <span class="text-sm font-semibold">{{ $student->phone ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Celular</span>
                                        <span class="text-sm font-semibold">{{ $student->mobile ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Ingreso</span>
                                        <span class="text-sm font-semibold">{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Egreso</span>
                                        <span class="text-sm font-semibold">{{ $student->graduation_date ? \Carbon\Carbon::parse($student->graduation_date)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Titulación</span>
                                        <span class="text-sm font-semibold">{{ $student->degree_date ? \Carbon\Carbon::parse($student->degree_date)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
